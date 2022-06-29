<?php


namespace App\Services;

class ParelessRequests
{
    /**
     * @var string
     */
    private $userId = '3001299';

    /**
     * @var string
     */
    private $userPassword = '935BCh46';

    /**
     * @param null $from
     * @param array $reciepients
     * @param null $message
     * @return bool|string
     */
    public function sendMessage($from = null, $reciepients = array(), $message = null)
    {
        try {
        $url = 'https://mms1.pnwireless.net:443/partners/messageReceiving/3001299/submitMessage';
        $ch = curl_init();

        $data = array(
            'from' => $from,
            'recipients' => $reciepients,
            'text' => $message ? $message : ''
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_USERPWD, $this->userId . ':' . $this->userPassword);
        curl_setopt($ch,CURLOPT_FAILONERROR,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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
}