<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Role;
use App\Models\Login;
use App\Models\Apicollection;

class UsersController extends Controller
{
    public function manageusers()
    {
        $users = User::join('roles','roles.id','=','users.role_id')->select(['users.*', 'roles.role_name'])->get();
        $roles = Role::orderBy('id','asc')->get();

        return view('users.manageusers')
            ->with('users', $users)
            ->with('roles', $roles);
    }
    public function loginhistory()
    {
        $logins = Login::orderBy('id','desc')->get();
        return view('users.userloginhistory')
            ->with('logins', $logins);
    }
}
