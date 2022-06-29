<?php

namespace App\Http\Controllers\Apis;

use Session;
use Exception;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use App\Models\Netsapiens_domain;
use App\Models\Netsapiensdomainsummary;
use App\Models\Netsapiensdomainextension;
use App\Models\Netsapiensdomainextentionswithsms;

class NetsapiensController
{
    private function formatParams($data)
    {
        $params = '';
        foreach($data as $key=>$value)
            $params .= $key.'='.$value.'&';

        $params = trim($params, '&');
        return $params;
    }
    private function generateToken()
    {
        $data = array (
            'grant_type' => 'password',
            'client_id' => 'portal.yoko.us',
            'client_secret' => '6353007fcb9bd721d756f7f0e4747e77',
            'username' => '299@yoko',
            'password' => '1dU336CN6Xvh',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://yokopbx.com/ns-api/oauth2/token/?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->formatParams($data));
        curl_setopt($ch,CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
        return response()->json($result, 201);
    }
    private function generateToken_()
    {
        $client = new Client();
        $URI = 'https://yokopbx.com/ns-api/oauth2/token/?grant_type=password&client_id=portal.yoko.us&client_secret=6353007fcb9bd721d756f7f0e4747e77&username=299@yoko&password=1dU336CN6Xvh';
        $response = $client->post($URI, []);
        return $response->getBody()->getContents();
    }
    public function pulldomains(Request $request)
    {
        $token = $this->generateToken_();
        $token = json_decode($token, true);
        if(!isset($token['access_token'])) {
            throw new Exception("Token generation error!");
        }
/*
Array
(
    [username] => 299@yoko
    [user] => 299
    [territory] => NetSapiens
    [domain] => yoko
    [uid] => 299@yoko
    [scope] => Super User
    [user_email] => noc@yokonetworks.com
    [displayName] => portal_yoko_us
    [access_token] => 570cd7d8f6d051dc5ea7603221672f7e
    [expires_in] => 3600
    [token_type] => Bearer
    [refresh_token] => ce9976b2971d00811133d4cdc369c56e
    [client_id] => portal.yoko.us
    [apiversion] => Version: 41.2.1
)
*/
        try {
            $client = new Client();  
            $URI = 'https://yokopbx.com/ns-api/?format=json&object=domain&action=read';
            $params['headers'] = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token['access_token']];
            $response = $client->post($URI, $params);
            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);
/*
Array
(
    [0] => Array
        (
            [domain] => 2vtrucking
            [territory] => NetSapiens
            [dial_match] => 
            [description] => 2V Trucking
            [moh] => yes
            [mor] => no
            [mot] => no
            [rmoh] => no
            [rating] => no
            [resi] => no
            [mksdir] => yes
            [call_limit] => 0
            [call_limit_ext] => 0
            [sub_limit] => 0
            [max_call_queue] => 0
            [max_aa] => 0
            [max_conference] => 0
            [max_department] => 0
            [max_user] => 0
            [max_device] => 0
            [time_zone] => US/Central
            [dial_plan] => 2vtrucking
            [dial_policy] => US and Canada
            [policies] => active
            [email_sender] => pbx@yokonetworks.com
            [smtp_host] => 
            [smtp_port] => 
            [smtp_uid] => 
            [smtp_pwd] => 
            [from_user] => [*]
            [from_host] => [*]
            [active_call] => 0
            [countForLimit] => 0
            [countExternal] => 0
            [sub_count] => 2
            [max_site] => 0
            [max_fax] => -1
            [sso] => no
        )
*/
            if(isset($response->error->message))
            {
                return response()->json($response->error->message, 500);
            } else {
                if(isset($response) && count($response)>0) {
                    Netsapiens_domain::truncate();
                    Netsapiens_domain::insert($response);
                }
                return response()->json(array('success'), 200);
            }
        } catch (ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
            return response()->json($response, 500);
        }
    }
    public function pulldomainsummaries(Request $request)
    {
        $domains = Netsapiens_domain::select('domain')->get();
        if(count($domains)>0) {
            $token = $this->generateToken_();
            $token = json_decode($token, true);
            if(!isset($token['access_token'])) {
                throw new Exception("Token generation error!");
            }

            Netsapiensdomainsummary::truncate();

            foreach($domains as $domain) {
                try {
                    $client = new Client();  
                    $URI = 'https://yokopbx.com/ns-api/?format=json&object=domain&action=read&billing=yes&domain='.$domain->domain;
                    $params['headers'] = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token['access_token']];
                    $response = $client->post($URI, $params);
                    $response = $response->getBody()->getContents();
                    $response = json_decode($response, true);
        
                    if(isset($response->error->message))
                    {
                        //return response()->json($response->error->message, 500);
                        continue;
                    } else {
                        if(isset($response) && count($response)>0) {
                            Netsapiensdomainsummary::insert($response);
                        }
                        //return response()->json($response, 200);
                    }
                } catch (ServerException $exception) {
                    //$response = $exception->getResponse()->getBody()->getContents();
                    //return response()->json($response, 500);
                }
            }
        }
    }
    public function collectextensions(Request $request)
    {
        $domains = Netsapiens_domain::select('domain')->get();
        if(count($domains)>0) {
            $token = $this->generateToken_();
            $token = json_decode($token, true);
            if(!isset($token['access_token'])) {
                throw new Exception("Token generation error!");
            }

            Netsapiensdomainextension::truncate();

            foreach($domains as $domain) {
                try {
                    $client = new Client();  
                    $URI = 'https://yokopbx.com/ns-api/?format=json&object=phonenumber&action=read&dialplan=DID Table&dest_domain='.$domain->domain;
                    $params['headers'] = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token['access_token']];
                    $response = $client->post($URI, $params);
                    $response = $response->getBody()->getContents();
                    $response = json_decode($response, true);
//print_r($response);exit;        
                    if(isset($response->error->message))
                    {
                        //return response()->json($response->error->message, 500);
                        continue;
                    } else {
                        if(isset($response) && count($response)>0) {
                            Netsapiensdomainextension::insert($response);
                        }
                        //return response()->json($response, 200);
                    }
                } catch (ServerException $exception) {
                    //$response = $exception->getResponse()->getBody()->getContents();
                    //return response()->json($response, 500);
                }
            }
        }
    }
    public function pulldomainextensionwithsms(Request $request)
    {
        $token = $this->generateToken_();
        $token = json_decode($token, true);
        if(!isset($token['access_token'])) {
            throw new Exception("Token generation error!");
        }

        try {
            $client = new Client();  
            $URI = 'https://yokopbx.com/ns-api/?object=smsnumber&action=read&domain';
            $params['headers'] = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token['access_token']];
            $response = $client->post($URI, $params);
            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);
            if(isset($response->error->message))
            {
                //return response()->json($response->error->message, 500);
            } else {
                if(isset($response) && count($response)>0) {
                    Netsapiensdomainextentionswithsms::truncate();
                    foreach($response as $row) {
                        Netsapiensdomainextentionswithsms::create($row);
                    }
                }
                //return response()->json($response, 200);
            }
        } catch (ServerException $exception) {
            //$response = $exception->getResponse()->getBody()->getContents();
            //return response()->json($response, 500);
        }
    }
}