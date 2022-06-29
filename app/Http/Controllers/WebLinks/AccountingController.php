<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Accountsystemtopbxclient;
use App\Models\Accountingdailybillingcount;
use App\Models\Netsapiens_domain;
use App\Models\Accountingclients;

class AccountingController extends Controller
{
    public function accounttodomain()
    {
        $sql = "SELECT domain FROM netsapiens_domains WHERE domain NOT IN (SELECT DISTINCT domain FROM account_system_to_pbx_clients)";
        $domains = DB::select(DB::raw($sql));
        $domains = array_map(function ($value) {
            return $value->domain;
        }, $domains);
        //print_r($domains);exit;
        //$domains = Netsapiens_domain::all();
        $clients = Accountingclients::all();
        $data = Accountsystemtopbxclient::select('account_system_to_pbx_clients.*', 'accounting_clients.client')->join('accounting_clients','accounting_clients.id','=','account_system_to_pbx_clients.account_id')->get();
        return view('accounting.accounttodomain')
            ->with('domains', $domains)
            ->with('clients', $clients)
            ->with('data', $data);
    }
    public function accountingmonthlydata()
    {
        $data = Accountingdailybillingcount::join('netsapiens_domains','netsapiens_domains.id','=','accounting_daily_billing_counts.netsapiens_domain_id')->get();
        $domains = Netsapiens_domain::all();
        $clients = Accountingclients::all();
        
        return view('accounting.accountingmonthlydata')
            ->with('domains', $domains)
            ->with('clients', $clients)
            ->with('data', $data);
    }
}