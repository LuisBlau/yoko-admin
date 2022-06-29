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
use App\Models\Netsapiens_domain;
use App\Models\Tenstreetconfig;
use App\Models\TenstreetCallRelayConfig;

class CustomerController extends Controller
{
    public function managecustomers()
    {
        $users = User::select(DB::raw('users.id, users.name, users.email, users.status, GROUP_CONCAT(customer_domains.domain) as domains'))
            ->leftJoin('customer_domains','customer_domains.user_id','=','users.id')
            ->where('users.role_id', 2)
            ->groupBy('customer_domains.user_id')
            ->groupBy('users.id')
            ->groupBy('users.name')
            ->groupBy('users.email')
            ->groupBy('users.status')
            ->get();

        $domains = Netsapiens_domain::distinct()->pluck('domain')->toArray();
        //print_r($domains);exit;
        return view('customers.managecustomers')
            ->with('domains', $domains)
            ->with('users', $users);
    }
    public function tenstreetconfiguration()
    {
        $configs = Tenstreetconfig::all();
        $domains = Netsapiens_domain::distinct()->pluck('domain')->toArray();
        return view('customers.tenstreetconfiguration')
            ->with('configs', $configs)
            ->with('domains', $domains);
    }
    public function tenstreetcallrelayconfig()
    {
        $configs = TenstreetCallRelayConfig::all();
        $domains = Netsapiens_domain::all();
        return view('customers.tenstreetcallrelayconfig')
            ->with('configs', $configs)
            ->with('domains', $domains);
    }
}