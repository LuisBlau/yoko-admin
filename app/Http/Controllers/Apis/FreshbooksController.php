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

use App\Models\Accountingclients;

class FreshbooksController
{    
    public function authentication(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.freshbooks.com/auth/oauth/token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{
            "grant_type": "authorization_code",
            "client_secret": "e16c3fe9e73df86d69fbc69f34b4516f44ef8f8d8dc4a391a2c7ef0e9d78ed99",
            "code": "04ab3b20dffcd22ef653428d9ec8bce3",
            "client_id": "5d5551964e3de0d17332eaeac91996f4cc1a3a4b3f8844fabdbaaac8a3fad27c",
            "redirect_uri": '.env("APP_ENV").'
          }',
          CURLOPT_HTTPHEADER => array(
            "api-version: alpha",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
    }
    public function generateAuthToken()
    {
        $client = new Client();
        $URI = 'https://api.freshbooks.com/auth/oauth/token/?grant_type=authorization_code&client_secret=e16c3fe9e73df86d69fbc69f34b4516f44ef8f8d8dc4a391a2c7ef0e9d78ed99&client_id=5d5551964e3de0d17332eaeac91996f4cc1a3a4b3f8844fabdbaaac8a3fad27c&code=04ab3b20dffcd22ef653428d9ec8bce3&redirect_uri='.env("APP_ENV").'/dashboard';
        $response = $client->post($URI, []);
        return $response->getBody()->getContents();
    }
    public function getclients()
    {
        $client = new Client();
        $URI = 'https://api.freshbooks.com/accounting/account/<accountid>/users/clients';
        $response = $client->post($URI, []);
        return $response->getBody()->getContents();
    }
}