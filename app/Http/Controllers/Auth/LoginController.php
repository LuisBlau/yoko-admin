<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;

use App\Models\Login;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function authenticated(Request $request, $user)
    {
        $user->lastaccessed = Carbon::now()->toDateTimeString();
        $user->save();

        /* $client = new Client;
        $response = $client->get('http://ipinfo.io/'.$request->getClientIp().'/geo');

        if ($response->getStatusCode() === 200) {
            $response = json_decode($response->getBody(), true);
            if (array_key_exists('country', $response)) {
                $login = Login::create([
                    'userid' => $user->id,
                    'ip' => $request->getClientIp(),
                    'country' => $response['country'],
                    'region' => $response['region'],
                    'city' => $response['city']
                ]);
            } else {
                $login = Login::create([
                    'userid' => $user->id,
                    'ip' => $request->getClientIp(),
                    'country' => '-',
                    'region' => '-',
                    'city' => '-'
                ]);
            }
        } else {
            $login = Login::create([
                'userid' => $user->id,
                'ip' => $request->getClientIp(),
                'country' => '-',
                'region' => '-',
                'city' => '-'
            ]);
        } */

        $login = Login::create([
                'userid' => $user->id,
                'ip' => $request->getClientIp(),
                'country' => '-',
                'region' => '-',
                'city' => '-'
            ]);
    }
}
