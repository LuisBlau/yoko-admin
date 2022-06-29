<?php

namespace App\Http\Controllers\Apis;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;

class PeerlessController extends Controller
{
    private $domain = 'https://yokopbx.com/';
    private $user = '205@yoko';

    public function __construct()
    {
       $this->middleware('auth:api');
    }
    public function submitMessage(Request $request, $partnerID)
    {
        if (is_null($request->recipients) || !isset($request->recipients) &&
            is_null($request->from) || !isset($request->from)) {
            $data = [
                'success' => false,
                'message' => 'Bad Request'
            ];
            return response()->json($data, 400);
        }

        $result = $this->sendMessage($request->from, $request->recipients, $request->message, $request->mediaURL);
        $data = [
            'success' => true,
            'data' => $result
        ];
        return response()->json($data, 400);
    }
    private function sendMessage($from, $recipients, $text = null, $mediaURL = null)
    {
        $url = 'https://yokopbx.com/ns-api/';
        $result = array();
        if($recipients) {
            foreach($recipients as $recipient) {
                try {
                    $data = array (
                        'object' => 'message',
                        'action' => 'create',
                        'type' => 'sms',
                        'user' => $this->user,
                        'domain' => $this->domain,
                        'destination' => $recipient,
                        'message' => $text,
                        'from_num' => $from
                    );
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
                    curl_setopt($ch, CURLOPT_POST, count($data));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->formatParams($data));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
                    curl_setopt($ch,CURLOPT_FAILONERROR,false);
                    curl_setopt($ch, CURLOPT_HEADER, 1);
                    $result[] = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
                } catch (Exception $e) {
                    trigger_error(sprintf(
                        'Sent failed with error: #%d: %s',
                        $e->getCode(), $e->getMessage()));
                }
            }
        }
        return $result;
    }

    private function formatParams($data)
    {
        $params = '';
        foreach($data as $key=>$value)
            $params .= $key.'='.$value.'&';

        $params = trim($params, '&');
        return $params;
    }
}