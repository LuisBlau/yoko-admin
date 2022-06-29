<?php

namespace App\Http\Controllers\Apis;

use App\Models\TenstreetCallRelayLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use App\Models\User;
use App\Models\Apicollection;
use App\Models\Messagelog;
use App\Models\Netsapiensdomainextension;
use App\Models\Netsapiensdomainextentionswithsms;
use App\Models\Failedjob;
use App\Models\Tenstreetcollection;
use App\Models\Tenstreetlog;
use App\Models\Confignonworkingday;
use App\Models\Configweeklyschedule;
use App\Models\Aaborelay;

class CollectionController
{
    function getRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    function _aabo_number($from, $to, $text, $newmsgid) {
        $from1 = str_replace('+','',$from);
        $to1 = str_replace('+','',$to);

        $aabo_relay_id = 0;
        $res1 = Netsapiensdomainextension::where('matchrule','regexp',$from1)->where('domain_owner','aabo')->first();
        if($res1) {
            $aabo_relay_id = $res1->id;
        }
        //$res2 = Netsapiensdomainextentionswithsms::where('number','regexp',$from1)->where('domain','aabo')->first();

        if($aabo_relay_id==0) {
            $res3 = Netsapiensdomainextension::where('matchrule','regexp',$to1)->where('domain_owner','aabo')->first();
            //$res4 = Netsapiensdomainextentionswithsms::where('number','regexp',$to1)->where('domain','aabo')->first();
            if($res3) {
                $aabo_relay_id = $res3->id;
            }
        }

        if($aabo_relay_id) {
            $aabo_relay = Aaborelay::where('extension_id', $aabo_relay_id)->first();

            $client = new Client();
            if($aabo_relay) {
                $URI = 'https://'. $aabo_relay->destination_url.'/api/smshook';
            } else {
                $URI = 'https://owner.aabocrm.com/api/smshook'; // for exception
            }
            //exit($URI);
            $params['headers'] = ['Content-Type' => 'application/json'];
            // 'applicationId' => '1fbbbf88-a581-4fbf-8200-f6dbf93cbd74',
            $params['body'] = json_encode(array('from' => $from, 'to' => $to, 'text' => $text));

            try {
                $response = $client->post($URI, $params);
            } catch (RequestException $e) {
                Failedjob::create([
                    'message_id' => $newmsgid,
                    'payload' => Psr7\Message::toString($e->getRequest()),
                    'exception' => $e->hasResponse()?Psr7\Message::toString($e->getResponse()):'',
                ]);
            }
            return true;
        }
        return false;
    }

    public function getcollection(Request $request)
    {
        $headers = $this->getRequestHeaders();

        // foreach ($headers as $header => $value) {
        //     echo "$header: $value <br />\n";
        // }
        //print_r(apache_request_headers());exit;

        $url = $request->url;
        //$headers = get_headers($url);

        $requestBody = file_get_contents('php://input');

        $result = array();
        $result['headers'] = $headers;
        $result['requestbody'] = $requestBody;


        $from = $request->from;// $from = '16305800201';
        $recipients = $request->to;// $recipients = array('18014251023');
        if(!is_array($recipients)) {
            $recipients = explode(',',$recipients);
        }
        $mediaURL = $request->media;// $mediaURL = "https://pbs.twimg.com/profile_images/875749462957670400/T0lwiBK8_400x400.jpg";
        if(is_array($mediaURL)) {
            $mediaURL = $mediaURL[0];
        }

        if($mediaURL) {
            $text = "";
        } else {
            $text = $request->text;
            $mediaURL = "";
        }

        $newmsg = Messagelog::create([
            'inbound' => 0,
            'from' => $from,
            'recipients' => implode(',', $recipients),
            'text' => $text,
            'mediaURL' => $mediaURL,
            'carrier' => "Yokopbx.com",
            'responseText' => "Failed"
        ]);

        $aaboflag = $this->_aabo_number($from, $recipients[0], $text, $newmsg->id);

        $collection = new Apicollection();
        $collection->message_id = $newmsg->id;
        $collection->headers = implode(', ', $headers);
        $collection->body = $requestBody;
        $collection->save();

        $client = new Client();
        $URI = 'https://mms1.pnwireless.net:443/partners/messageReceiving/3001299/submitMessage';
        $username = "3001299";
        $password = "935BCh46";
        $params['auth'] = [$username, $password];
        $params['headers'] = ['Content-Type' => 'application/json'];
        // 'applicationId' => '1fbbbf88-a581-4fbf-8200-f6dbf93cbd74',
        $params['body'] = json_encode(array('from' => $from, 'recipients' => $recipients, 'text' => $text, 'mediaURL' => $mediaURL));

        try {
            $response = $client->post($URI, $params);
        } catch (RequestException $e) {
            Failedjob::create([
                'message_id' => $newmsg->id,
                'payload' => Psr7\Message::toString($e->getRequest()),
                'exception' => $e->hasResponse()?Psr7\Message::toString($e->getResponse()):'',
            ]);
            return;
        }

        if($aaboflag) {
            $newmsg->carrier = 'AABO';
        }
        $newmsg->responseText = 'Sent';
        $newmsg->save();

        return response()->json($response->getBody()->getContents());
    }

    public function outboundpeerlessforaabo(Request $request)
    {
        $headers = $this->getRequestHeaders();

        // foreach ($headers as $header => $value) {
        //     echo "$header: $value <br />\n";
        // }
        //print_r(apache_request_headers());exit;

        //$url = $request->url;
        //$headers = get_headers($url);

        $requestBody = file_get_contents('php://input');

        //$result = array();
        //$result['headers'] = $headers;
        //$result['requestbody'] = $requestBody;


        $from = $request->from;// $from = '16305800201';

        $recipients = $request->to;// $recipients = array('18014251023');
        if(!is_array($recipients)) {
            $recipients = explode(',',$recipients);
        }
        $mediaURL = $request->media;// $mediaURL = "https://pbs.twimg.com/profile_images/875749462957670400/T0lwiBK8_400x400.jpg";
        if(is_array($mediaURL)) {
            $mediaURL = $mediaURL[0];
        }

        if($mediaURL) {
            $text = "";
            if(str_contains($mediaURL, 'pnwireless.net')) {
                $url_components = parse_url($mediaURL);
                parse_str($url_components['query'], $params);

                $awsMediaURL =  'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/images/' . $params['at'];
                Storage::disk('s3')->put('images/' . $params['at'], file_get_contents($mediaURL));
            }
        } else {
            $text = $request->text;
            $mediaURL = "";
            $awsMediaURL = "";
        }

        $newmsg = Messagelog::create([
            'inbound' => 0,
            'from' => $from,
            'recipients' => implode(',', $recipients),
            'text' => $text,
            //'mediaURL' => $mediaURL?$mediaURL:'',
            'mediaURL' => $awsMediaURL?$awsMediaURL:'',
            'carrier' => "AABO",
            'responseText' => "Failed"
        ]);

        $aaboflag = $this->_aabo_number($from, $recipients[0], $text, $newmsg->id);

        $collection = new Apicollection();
        $collection->message_id = $newmsg->id;
        $collection->headers = implode(', ', $headers);
        $collection->body = $requestBody;
        $collection->save();

        $client = new Client();
        $URI = 'https://mms1.pnwireless.net:443/partners/messageReceiving/3001299/submitMessage';
        $username = "3001299";
        $password = "935BCh46";
        $params['auth'] = [$username, $password];
        $params['headers'] = ['Content-Type' => 'application/json'];
        // 'applicationId' => '1fbbbf88-a581-4fbf-8200-f6dbf93cbd74',
        $params['body'] = json_encode(array('from' => $from, 'recipients' => $recipients, 'text' => $text, 'mediaURL' => $mediaURL));

        try {
            $response = $client->post($URI, $params);
        } catch (RequestException $e) {
            Failedjob::create([
                'message_id' => $newmsg->id,
                'payload' => Psr7\Message::toString($e->getRequest()),
                'exception' => $e->hasResponse()?Psr7\Message::toString($e->getResponse()):'',
            ]);
            return;
        }

        if($aaboflag) {
            $newmsg->carrier = 'AABO';
        }
        $newmsg->responseText = 'Sent';
        $newmsg->save();

        return response()->json($response->getBody()->getContents());
    }

    public function inboundpeerless(Request $request)
    {
        $headers = $this->getRequestHeaders();
        $requestBody = file_get_contents('php://input');

        $result = array();
        $result['headers'] = $headers;
        $result['requestbody'] = $requestBody;

        $from = $request->from;// $from = '18014251023';
        $to = $request->recipients;// "recipients": ["+16305800201"],
        $ccRecipients = $request->ccRecipients;// "ccRecipients": [],
        if(is_array($to)) {
            $to = $to[0];
        }

        $awsMediaURL = "";
        $mediaURL = $request->mediaURL;// $mediaURL = "https://pbs.twimg.com/profile_images/875749462957670400/T0lwiBK8_400x400.jpg";
        if($mediaURL) {
            $message = $mediaURL;
            $type="mms";
            if(str_contains($mediaURL, 'pnwireless.net')) {
                $url_components = parse_url($mediaURL);
                parse_str($url_components['query'], $params);
                //exit(env('MAIL_FROM_ADDRESS'));
                $awsMediaURL =  'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/images/' . $params['at'];

                Storage::disk('s3')->put('images/' . $params['at'], file_get_contents($mediaURL));
            }
        } else {
            $message = $request->text;// $text = "This is a test!";
            $type="sms";
        }

        if($request->type) {
            $type=$request->type;
        }
        if($request->message) {
            $message=$request->message;
        }

                //exit($awsMediaURL);
        $newmsg = Messagelog::create([
            'inbound' => 1,
            'from' => $from,
            'recipients' => $to,
            'text' => ($type=='sms'?$message:''),
            //'mediaURL' => ($type=='mms'?$message:''),
            'mediaURL' => $awsMediaURL?$awsMediaURL:'',
            'carrier' => "Peerless",
            'responseText' => "Failed"
        ]);

        $aaboflag = $this->_aabo_number($from, $to, $message, $newmsg->id);

        $collection = new Apicollection();
        $collection->message_id = $newmsg->id;
        $collection->headers = implode(', ', $headers);
        $collection->body = $requestBody;
        $collection->save();

        $client = new Client(); //ThinQ
        $URI = 'https://yokopbx.com/ns-api/?object=sms&action=create';
        $params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded', 'User-Agent' => 'thinq-sms', 'HTTP_X_SMS_GUID' => '3d2c1a72-6dec-11ea-bd8a-b747e300855'];
        $params['body'] = http_build_query(array('from' => $from, 'to' => $to, 'type' => $type, 'message' => $message));
        try {
            $response = $client->post($URI, $params);
        } catch (RequestException $e) {

            Failedjob::create([
                'message_id' => $newmsg->id,
                'payload' => Psr7\Message::toString($e->getRequest()),
                'exception' => $e->hasResponse()?Psr7\Message::toString($e->getResponse()):'',
            ]);
            return;
        }

        if($aaboflag) {
            $newmsg->carrier = 'AABO';
        }
        $newmsg->responseText = 'Sent';
        $newmsg->save();
        return response()->json($response->getBody()->getContents());
    }

    private function addtentreetrequest($ts)
    {
        $weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        $weekday = $weekdays[date('w')];
        $today = date('Y-m-d');
        /*
        $nwds = Confignonworkingday::where('dt', $today)->get();
        if(count($nwds)) return 'non-working day';
        */
        $ws = Configweeklyschedule::find(1);
        $ws = json_decode($ws['weeklyschedule'], true);

        $after_hours = 0;
        if(date('H:i')<$ws[$weekday.'_start']) $after_hours = 1;
        if(date('H:i')>$ws[$weekday.'_end']) $after_hours = 1;

        $tenstreet_array = array();
        $tenstreet_array['domain'] = "gptransco";
        $tenstreet_array['subjectid'] = isset($ts['SubjectID'])?$ts['SubjectID']:'';
        $tenstreet_array['firstname'] = isset($ts['FirstName'])?$ts['FirstName']:'';
        $tenstreet_array['lastname'] = isset($ts['LastName'])?$ts['LastName']:'';
        $tenstreet_array['pphone'] = isset($ts['PPhone'])?$ts['PPhone']:'';
        $tenstreet_array['sphone'] = isset($ts['SPhone'])?$ts['SPhone']:'';
        $tenstreet_array['autocall'] = isset($ts['AutoCall'])?$ts['AutoCall']:'';
        $tenstreet_array['source'] = isset($ts['Source'])?$ts['Source']:'';
        $tenstreet_array['after_hours'] = $after_hours;

        if($tenstreet_array['source']=='Internal App' && $tenstreet_array['autocall']=='') {
            $tenstreet_array['status'] = 'Archived';
        }
        if($tenstreet_array['autocall']=='No') {
            $tenstreet_array['status'] = 'Archived';
        }

        foreach($tenstreet_array as $k=>$v) {
            if(!$v) $tenstreet_array[$k] = '';
        }
        Tenstreetlog::create($tenstreet_array);
    }
    public function tenstreet(Request $request)
    {
        $headers = $this->getRequestHeaders();

        $requestBody = file_get_contents('php://input');

        $result = array();
        $result['headers'] = $headers;
        $result['requestbody'] = $requestBody;

        $collection = new Tenstreetcollection();
        $collection->headers = implode(', ', $headers);
        $collection->body = $requestBody;
        $collection->domain = "gptransco";//hard-coded
        $collection->save();

        $xml = simplexml_load_string($requestBody);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        if(isset($array['ReportData'])) {
            if(isset($array['ReportData']['Row'])) {
                $ts = $array['ReportData']['Row'];
                if(isset($ts[0])) {
                    foreach($ts as $_ts) {
                        $this->addtentreetrequest($_ts);
                    }
                } else {
                    $this->addtentreetrequest($ts);
                }
            }
        }

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
    }
    public function tenstreetLog(Request $request)
    {
        $headers = $this->getRequestHeaders();
        $requestBody = file_get_contents('php://input');
        $tenstreetCallRelayLog = new TenstreetCallRelayLog();
        $tenstreetCallRelayLog->headers = implode(', ', $headers);
        $tenstreetCallRelayLog->body = $requestBody;
        $tenstreetCallRelayLog->domain = "gptransco";//hard-coded
        $tenstreetCallRelayLog->tenstreet_response = ""; // at the moment, empty
        $tenstreetCallRelayLog->save();

        return response()->json([
            'message' => 'Logged successfully.',
        ], 201);
    }
    public function resendfailedmessages(Request $request)
    {
        $starttime = str_replace('T',' ',$request->starttime).':00';
        $endtime = str_replace('T',' ',$request->endtime).':59';

        $processed_count = 0;
        $failed_count = 0;
        $failedmessages = Messagelog::where('responseText', 'Failed')
                ->whereRaw("created_on >= '$starttime'")
                ->whereRaw("created_on <= '$endtime'")
                ->get();
        foreach($failedmessages as $msg) {
            if($msg->inbound==0) {
                $from = $msg->from;// $from = '16305800201';
                $recipients = explode(',', $msg->recipients);// $recipients = array('18014251023');
                $text = $msg->text;
                $mediaURL = $msg->mediaURL;// $mediaURL = "https://pbs.twimg.com/profile_images/875749462957670400/T0lwiBK8_400x400.jpg";

                $client = new Client();
                $URI = 'https://mms1.pnwireless.net:443/partners/messageReceiving/3001299/submitMessage';
                $username = "3001299";
                $password = "935BCh46";
                $params['auth'] = [$username, $password];
                $params['headers'] = ['Content-Type' => 'application/json'];
                // 'applicationId' => '1fbbbf88-a581-4fbf-8200-f6dbf93cbd74',
                $params['body'] = json_encode(array('from' => $from, 'recipients' => $recipients, 'text' => $text, 'mediaURL' => $mediaURL));
                try {
                    $response = $client->post($URI, $params);
                    $msg->responseText = 'Sent';
                    $msg->save();

                    $processed_count++;
                } catch (RequestException $e) {
                    $failed_count++;
                }
            } elseif($msg->inbound==1) {
                $from = $msg->from;// $from = '18014251023';
                $to = $msg->recipients;// "+16305800201"
                $mediaURL = $msg->mediaURL;// $mediaURL = "https://pbs.twimg.com/profile_images/875749462957670400/T0lwiBK8_400x400.jpg";
                if($mediaURL) {
                    $message = $mediaURL;
                    $type="mms";
                } else {
                    $message = $msg->text;// $text = "This is a test!";
                    $type="sms";
                }

                $client = new Client(); //ThinQ
                $URI = 'https://yokopbx.com/ns-api/?object=sms&action=create';
                $params['headers'] = ['Content-Type' => 'application/x-www-form-urlencoded', 'User-Agent' => 'thinq-sms', 'HTTP_X_SMS_GUID' => '3d2c1a72-6dec-11ea-bd8a-b747e300855'];
                $params['body'] = http_build_query(array('from' => $from, 'to' => $to, 'type' => $type, 'message' => $message));
                try {
                    $response = $client->post($URI, $params);
                    $msg->responseText = 'Sent';
                    $msg->save();

                    $processed_count++;
                } catch (RequestException $e) {
                    $failed_count++;
                }
            } else {
                $failed_count++;
            }
        }
        return response()->json(array('cnt'=>$processed_count, 'fcnt'=>$failed_count));
    }
}
