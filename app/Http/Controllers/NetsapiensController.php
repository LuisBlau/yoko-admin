<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;

class NetsapiensController extends Controller
{

    private $domain = 'https://yokopbx.com/';
    private $user = '205@yoko';
    //http://yokoapi.com/message/ns-api/destination/{phoneNumber}/from/{fromNumber}/message/{message}
    /**
     * @Route("/message/ns-api/destination/{phoneNumber}/from/{fromNumber}/message/{message}", name="send_message_netsapiens", methods={"GET"})
     *
     * @param Request $request
     * @param $phoneNumber
     * @param $fromNumber
     * @param $message
     * @return JsonResponse
     */
    public function sendAction(Request $request, $phoneNumber, $fromNumber,  $message)
    {

        if (is_null($phoneNumber) || !isset($phoneNumber) &&
            is_null($message) || !isset($message) &&
            is_null($fromNumber) || !isset($fromNumber)) {
            $data = [
                'success' => false,
                'message' => 'Bad Request'
            ];
            return response()->json($data, 400);
        }

        $result = $this->sendMessage($phoneNumber, $message, $fromNumber);
        $data = [
            'success' => true,
            'data' => $result
        ];
        return response()->json($data, 400);

    }

    /**
     * @Route("/nsmessages", name="nsmessages")
     *
     * @param Request $request
     * @param $phoneNumber
     * @param $fromNumber
     * @param $message
     * @return JsonResponse
     */
    public function generateTokenAction(Request $request)
    {
        $data = array (
            'grant_type' => 'password',
            'client_id' => 'yokoapi',
            'client_secret' => 'bc79f5e329f1c70569356ea19896dcb6',
            'username' => 'yokosms',
            'password' => '959GuM6TwfaXyrnnpvwL',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://yokopbx.com/ns-api/oauth2/token/?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->formatParams($data));
        curl_setopt($ch,CURLOPT_FAILONERROR,false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return response()->json($result, 201);
    }

    /**
     * @param $destination
     * @param $message
     * @param $fromNumber
     * @return bool|string
     */
    private function sendMessage($destination = null , $message = null, $fromNumber = null)
    {
        $url = 'https://yokopbx.com/ns-api/';

        try {
            $data = array (
                'object' => 'message',
                'action' => 'create',
                'type' => 'sms',
                'user' => $this->user,
                'domain' => $this->domain,
                'destination' => $destination,
                'message' => $message,
                'from_num' => $fromNumber
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
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

        } catch (Exception $e) {
            trigger_error(sprintf(
                'Sent failed with error: #%d: %s',
                $e->getCode(), $e->getMessage()));

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
//http://yokoapi.com/message/ns-api/destination/{phoneNumber}/from/{fromNumber}/message/{message}
