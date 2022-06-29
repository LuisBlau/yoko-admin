<?php
function niceShort($attr) {
    if(isset($_COOKIE['curent_zone'])){
       //$current_time_zone = session()->get('current_time_zone');
       $current_time_zone = $_COOKIE['curent_zone'];
       $utc = strtotime($attr)-date('Z'); // Convert the time zone to GMT 0. If the server time is what ever no problem.
       $attr = $utc+$current_time_zone; // Convert the time to local time
       $attr = date("Y-m-d H:i:s", $attr);
    }
    return $attr;
}
function create_guid() { // Create GUID (Globally Unique Identifier)
    $guid = '';
    $namespace = rand(11111, 99999);
    $uid = uniqid('', true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = substr($hash,  0,  8) . '-' .
            substr($hash,  8,  4) . '-' .
            substr($hash, 12,  4) . '-' .
            substr($hash, 16,  4) . '-' .
            substr($hash, 20, 12);
    return $guid;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function formatphonenumber($phone) {
    if(  preg_match( '/(\d{1})(\d{3})(\d{3})(\d{4})$/', $phone,  $matches ) )
    {
        return  '+'.$matches[1].' ('. $matches[2].') '.$matches[3] . '-' . $matches[4];
    }
}