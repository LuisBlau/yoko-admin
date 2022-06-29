<?php

namespace App\Http\Controllers\Apis;

use Session;
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

use App\Models\Agentinqueue;
use App\Models\Tenstreetlog;
use App\Models\Tenstreetconfig;
use App\Models\Confignonworkingday;
use App\Models\Configweeklyschedule;

class TenstreetController
{
    private function generateToken_()
    {
        $client = new Client();
        $URI = 'https://yokopbx.com/ns-api/oauth2/token/?grant_type=password&client_id=portal.yoko.us&client_secret=6353007fcb9bd721d756f7f0e4747e77&username=299@yoko&password=1dU336CN6Xvh';
        $response = $client->post($URI, []);
        return $response->getBody()->getContents();
    }
    
    public function read_agents_in_queue(Request $request)
    {
        $domain = $request->domain;
        $queue_name = $request->queue_name;

        $token = $this->generateToken_();
        $token = json_decode($token, true);
        if(!isset($token['access_token'])) {
            throw new Exception("Token generation error!");
        }

        try {
            $client = new Client();
            $URI = 'https://yokopbx.com/ns-api/?object=agent&action=read&domain='.$domain.'&queue_name='.$queue_name;
            $params['headers'] = ['Accept' => 'application/xml', 'Authorization' => 'Bearer ' . $token['access_token']];

            $response = $client->post($URI, $params);
            $response = $response->getBody()->getContents();

            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            $agent = array();
            if(isset($array['agent'])) {
                $agent = $array['agent'];
                if(!empty($agent)) {
                    Agentinqueue::create($agent);
                }
            } else {
                if(count($array)>0) {
                    foreach($array as $agent) {
                        $agent = $array['agent'];
                        if(!empty($agent)) {
                            Agentinqueue::create($agent);
                        }
                    }
                }
            }

            return response()->json($agent); 

        } catch (ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
            return $response;
        }
    }
    
    private function generateRandomNumber($length = 15) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomNumber;
    }

    public function makeacall(Request $request)
    {
        $uid = $request->uid; //queue user so reporting etc is correct for this call
        $destination = $request->destination; //remote/cell number to call
        $origination = $request->origination; //did for queue
        $ani = $request->ani; //caller id that will be displayed for the remote call
        $callid = $this->generateRandomNumber();

        $token = $this->generateToken_();
        $token = json_decode($token, true);
        if(!isset($token['access_token'])) {
            throw new Exception("Token generation error!");
        }

        try {
            $client = new Client();
            $URI = 'https://yokopbx.com/ns-api/?format=json&object=call&action=call&callid='.$callid.'&uid='.$uid.'&destination='.$destination.'&origination='.$origination.'&ani='.$ani;
            $params['headers'] = ['Accept' => 'application/xml', 'Authorization' => 'Bearer ' . $token['access_token']];

            $response = $client->post($URI, $params);
            $response = $response->getBody()->getContents();

            return response()->json($response);

        } catch (ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
            return $response;
        }
    }
    public function archivecallrequest(Request $request)
    {
        $rid = $request->rid; //id of tenstreet_log table
        $callrequest = Tenstreetlog::findOrFail($rid);
        $callrequest->status = 'Archived';
        $result = $callrequest->save();
        return response()->json($result); 
    }
    public function sendtoqueue(Request $request)
    {
        $rid = $request->rid; //id of tenstreet_log table
        $callrequest = Tenstreetlog::findOrFail($rid);

        $domain = $callrequest->domain;
        $tsconfig = Tenstreetconfig::where('domain', $domain)->first();

        $uid = $tsconfig->queue_name.'@'.$domain; //queue user so reporting etc is correct for this call
        $destination = $callrequest->pphone; //remote/cell number to call
        $origination = $tsconfig->origination_did; //did for queue
        $ani = $tsconfig->ani_did; //caller id that will be displayed for the remote call
        $callid = $this->generateRandomNumber();

        $token = $this->generateToken_();
        $token = json_decode($token, true);
        if(!isset($token['access_token'])) {
            throw new Exception("Token generation error!");
        }

        try {
            $client = new Client();
            $URI = 'https://yokopbx.com/ns-api/?format=json&object=call&action=call&callid='.$callid.'&uid='.$uid.'&destination='.$destination.'&origination='.$origination.'&ani='.$ani;
            $params['headers'] = ['Accept' => 'application/xml', 'Authorization' => 'Bearer ' . $token['access_token']];

            $response = $client->post($URI, $params);
            $response = $response->getBody()->getContents();

            $callrequest->status = 'Manual';
            $callrequest->call_date = date('Y-m-d H:i:s');
            $callrequest->save();

            return response()->json($response); 

        } catch (ServerException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
            return $response;
        }
    }

    public function makeacalltopbx()
    {
        //var_dump($this->generateRandomNumber());exit;
        $weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        $weekday = $weekdays[date('w')];

        $today = date('Y-m-d');
echo date('Y-m-d H:i:s');
echo "<br>";
        $nwds = Confignonworkingday::where('dt', $today)->get();
        if(count($nwds)) return 'non-working day';

        $ws = Configweeklyschedule::find(1);
        $ws = json_decode($ws['weeklyschedule'], true);

        if(date('H:i')<$ws[$weekday.'_start']) return 'before-working-time';
        if(date('H:i')>$ws[$weekday.'_end']) return 'after-working-time';
        
        $payload = Tenstreetlog::whereNull('status')->where('autocall','!=','No')->where('after_hours',0)->get();
//var_dump(count($payload));exit;
        if(count($payload)>0) {
            $token = $this->generateToken_();
            $token = json_decode($token, true);
            if(!isset($token['access_token'])) {
                throw new Exception("Token generation error!");
            }
/*
            if(count($payload) < $count) {
                $count = count($payload);
            }
*/
            $callrequest = $payload[0];

            //foreach($payload as $callrequest) {
                //$callrequest = $payload[$i];
                $domain = $callrequest->domain;
                $tsconfig = Tenstreetconfig::where('domain', $domain)->first();

                $client = new Client();
                $URI = 'https://yokopbx.com/ns-api/?object=agent&action=read&domain='.$domain.'&queue_name='.$tsconfig->queue_name;
                $params['headers'] = ['Accept' => 'application/xml', 'Authorization' => 'Bearer ' . $token['access_token']];
    
                $response = $client->post($URI, $params);
                $response = $response->getBody()->getContents();
    
                $xml = simplexml_load_string($response);
                $json = json_encode($xml);
                $array = json_decode($json,TRUE);
    
                $available_count = 0;
                if(isset($array['agent'])) {
                    if(isset($array['entry_status']) && $array['entry_status']=='available') {
                        $available_count = 1;
                    } else {
                        foreach($array['agent'] as $agent) {
                            if(isset($agent['entry_status']) && $agent['entry_status']=='available') {
                                $available_count++;
                            }
                        }
                    }
                }
                echo "available agents = ".$available_count."  ";
                if($available_count==0) {
                    echo "no available agent!";
                    //continue;
                }

                //echo "available agents: ".$available_count;
                $uid = $tsconfig->queue_name.'@'.$domain; //queue user so reporting etc is correct for this call
                $destination = $callrequest->pphone; //remote/cell number to call
                $origination = $tsconfig->origination_did; //did for queue
                $ani = $tsconfig->ani_did; //caller id that will be displayed for the remote call
                $callid = $this->generateRandomNumber();

                try {
                    $client = new Client();
                    $URI = 'https://yokopbx.com/ns-api/?format=json&object=call&action=call&callid='.$callid.'&uid='.$uid.'&destination='.$destination.'&origination='.$origination.'&ani='.$ani;
                    //echo $URI;
                    $params['headers'] = ['Accept' => 'application/xml', 'Authorization' => 'Bearer ' . $token['access_token']];
                    $response = $client->post($URI, $params);
                    $response = $response->getBody()->getContents();

                    Tenstreetlog::where('id', $callrequest->id)->update([
                        'status' => 'Called',
                        'call_date' => date('Y-m-d H:i:s')
                    ]);
                } catch (ServerException $exception) {}
            //}
        }
        return response()->json(array('calls'=>count($payload)));
    }

    /*
    public function tenstreet_collection(Request $request)
    {
        $headers = $this->getRequestHeaders();
      
        $requestBody = file_get_contents('php://input');

        $result = array();
        $result['headers'] = $headers;
        $result['requestbody'] = $requestBody;        

        $collection = new Tenstreetcollection();
        $collection->headers = implode(', ', $headers);
        $collection->domain = "gptransco";//hard-coded
        $collection->body = $requestBody;
        $collection->save();

        $xml = simplexml_load_string($requestBody);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $tenstreet_array = array();
        if(isset($array['ReportData'])) {
            if(isset($array['ReportData']['Row'])) {
                $ts = $array['ReportData']['Row'];
                $tenstreet_array['domain'] = "gptransco";
                $tenstreet_array['subjectid'] = isset($ts['SubjectID'])?$ts['SubjectID']:'';
                $tenstreet_array['firstname'] = isset($ts['FirstName'])?$ts['FirstName']:'';
                $tenstreet_array['lastname'] = isset($ts['LastName'])?$ts['LastName']:'';
                $tenstreet_array['pphone'] = isset($ts['PPhone'])?$ts['PPhone']:'';
                $tenstreet_array['sphone'] = isset($ts['SPhone'])?$ts['SPhone']:'';
                $tenstreet_array['autocall'] = isset($ts['AutoCall'])?$ts['AutoCall']:'';
                $tenstreet_array['source'] = isset($ts['Source'])?$ts['Source']:'';
            }
        }
        Tenstreetlog::create($tenstreet_array);

        $responseXml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <TenstreetResponse>
            <Status>ACCEPTED</Status>
            <Description>All went according to plan.</Description>
        </TenstreetResponse>
        XML;
        //header("Content-type: text/xml; charset=utf-8");
        return $responseXml;
        //return response()->xml($responseXml);
    } */
}