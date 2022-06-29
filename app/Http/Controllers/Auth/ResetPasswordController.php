<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use Session;
use Mail;
use Config;
use Exception;

use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
    }
    private function email_resettingpasswordinstruction($user) {
        $link = env("APP_URL","https://portal.yoko.us/");
        $link .= "password/reset?token=";
        $link .= $user->reset_token;

        $subject = "Instructions for resetting password";
        $msg = "Hi ".$user->name."!<br>We received a request to reset the password for your user account. You can change your password using the link below.<br>$link<br>If you haven't sent a request to change the password, you don't need to worry about this message.<br>Your password will not be changed unless you use the link above.<br>The Yoko Networks team";
        Mail::send([],[], function($message) use($user, $subject, $msg) {
            $message->to($user->email, $user->name)->subject($subject);
            $message->setBody($msg,'text/html'); // assuming text/plain
            $message->from(env("MAIL_FROM_ADDRESS", "noreply@yoko.us"), env("MAIL_FROM_NAME", "Yoko Networks"));
        });
        if (Mail::failures()) {
            //return response()->Fail('Sorry! Please try again latter');
            return false;
        } else {
            //return response()->json('Ok', 201);
            return true;
        }
    }

    public function sendnewpassword(Request $request)
    {
        $email = $request->emailaddress;
        $user = User::where('email', $email)->first();
        if($user) {
            $user->reset_token = bcrypt(generateRandomString(10));
            $user->update();
            if($this->email_resettingpasswordinstruction($user)) return true;
        }
        throw new Exception("Unknown error has been occurred.");
    }

    public function emailverification($token)
    {
        $user = User::where('verification_token',$token)->firstOrFail();
        return view('auth.emailverification')
            ->with('user', $user);
    }

    public function setpassword(Request $request)
    {
        $password = $request->password;
        $confirmpassword = $request->confirmpassword;
        $verification_token = $request->_token;

        if($password && $confirmpassword) {
            if($password==$confirmpassword) {
                $user = User::where('verification_token', $verification_token)->first();
                if($user) {
                    $encrypted = bcrypt($password);
                    $user->password = $encrypted;
                    $user->salt = $encrypted;
                    $user->reset_token = $encrypted;
                    $user->api_token = 'APH562OB05pE9ooYqwBuDiZI8wIpui1Wz0PMLg9d27VSN2Go5YPKj0Jhmfs5';
                    $user->status = '1';
                    $user->update();
                    
                    return redirect('/logout');
                }
            }
        }
        throw new Exception("Unknown exception occurred.");
    }
    public function forgotpassword(Request $request)
    {
        $password = $request->password;
        $confirmpassword = $request->confirmpassword;
        $reset_token = $request->_token;
        if($password && $confirmpassword) {
            if($password==$confirmpassword) {
                $user = User::where('reset_token', $reset_token)->first();

                if($user) {
                    $encrypted = bcrypt($password);
                    $user->password = $encrypted;
                    $user->salt = $encrypted;
                    $user->reset_token = $encrypted;
                    $user->api_token = 'APH562OB05pE9ooYqwBuDiZI8wIpui1Wz0PMLg9d27VSN2Go5YPKj0Jhmfs5';
                    $user->status = '1';
                    $user->update();

                    return redirect('/logout');
                }
            }
        }
        throw new Exception("Unknown exception occurred.");
    }
}
