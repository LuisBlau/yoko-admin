<?php


namespace App\Services;

class NsApiRequests
{
    /**
     * @var string
     */

    private $domain = 'https://yokopbx.com/';
    /**
     * @var string
     */

    private $user = '205@yoko';
    /**
     * @var string
     */

    private $clientId = 'yokoapi';

    /**
     * @var string
     */
    private $clientSecret = '14bcd6017ea31394628a00f40b5e360c';

    /**
     * @var string
     */
    private $userPassw = 'YokoUbie123';

    /**
     * @param $destination
     * @param $message
     * @param $fromNumber
     * @return bool|string
     */
    public function sendMessage($fromNumber = null, $destination = null , $message = null)
    {
        try {
            $url = 'http://yokopbx.com/ns-api/?object=sms&action=create';
            $msg = $message ? $message : '';
            $fields = array (
                'to' => urlencode($destination),
                'message' => urlencode($msg),
                'from' => urlencode($fromNumber)
            );

            $ch = curl_init();
            $headers = array();
            $headers[] = 'User-Agent: thinq-sms';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $this->formatCurlParamFields($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch,CURLOPT_FAILONERROR,true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);

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

    /**
     * @return JsonResponse
     */
    public function generateToken()
    {
        $data = array (
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->user,
            'password' => $this->userPassw,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://yokopbx.com/ns-api/oauth2/token/?');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->formatCurlParamFields($data));
        curl_setopt($ch,CURLOPT_FAILONERROR,true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    /**
     * @param $destination
     * @param $message
     * @param $fromNumber
     * @return bool|string
     */
    public function readMessage($fromNumber = null, $destination = null , $message = null)
    {
        //TODO fix everyting here, probably nothing works
        try {
            $url = 'http://yokopbx.com/ns-api/?object=sms&action=read';
            $fields = array (
                'session_id' => urlencode('b9674dd7ec9442c30ca2aad1c861e7ee'),
                'user' => urlencode('yoko'),
            );

            $ch = curl_init();
            $headers = array();
            $headers[] = 'User-Agent: thinq-sms';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, count($fields));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $this->formatParams($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch,CURLOPT_FAILONERROR,true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);

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

    /**
     * @param $fields
     * @return string|null
     */
    private function formatCurlParamFields($fields)
    {
        $fields_string = null;
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        return $fields_string;
    }
}