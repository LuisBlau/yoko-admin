<?php

namespace App\Http\Controllers\Administration;

use Session;
use Mail;
use Config;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Accountsystemtopbxclient;

class AccountingclientController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }

    public function add(Request $request)
    {
        if(Accountsystemtopbxclient::where('account_id',$request->account_id)->where('domain',$request->domain)->first()) {
            throw new Exception("Duplicated.");
        };
        
        $acc = Accountsystemtopbxclient::create([
            'account_id' => $request->clientid,
            'domain' => $request->domain
        ]);
        return response()->json($acc);
    }

    public function edit(Request $request)
    {
        $row = Accountsystemtopbxclient::where('id',$request->u)->firstOrFail();
        
        $acc = $row->update([
            'account_id' => $request->client_id,
            'domain' => $request->domain
        ]);
        return response()->json($acc);
    }

    public function delete(Request $request)
    {
        $row = Accountsystemtopbxclient::where('id',$request->u)->firstOrFail();
        
        $acc = $row->delete();
        return response()->json($acc);
    }

    public function get(Request $request)
    {
        $row = Accountsystemtopbxclient::where('id',$request->tid)->first();
        return response()->json($row);
    }
}