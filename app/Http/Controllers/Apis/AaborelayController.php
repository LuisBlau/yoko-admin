<?php

namespace App\Http\Controllers\Apis;

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

use App\Models\Aaborelay;

class AaborelayController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }

    public function add(Request $request)
    {
        // if(Aaborelay::where('extension_id', $request->extension)->where('destination_url', $request->destination_url)->first()) {
        //     throw new Exception("Duplicated.");
        // };
        
        $acc = Aaborelay::create([
            'extension_id' => $request->extension,
            'destination_url' => $request->destination_url
        ]);
        return response()->json($acc);
    }

    public function edit(Request $request)
    {
        $row = Aaborelay::where('id',$request->extension)->firstOrFail();

        if(Aaborelay::where('extension_id', $request->extension)->first() && ($request->extension != $request->u)) {
            throw new Exception("The Extension ID has been duplicated.");
        }
    
        $acc = $row->update([
            'extension_id' => $request->extension,
            'destination_url' => $request->destination_url
        ]);
        return response()->json($acc);
    }

    public function delete(Request $request)
    {
        $row = Aaborelay::where('id',$request->u)->firstOrFail();
        
        $acc = $row->delete();
        return response()->json($acc);
    }

    public function get(Request $request)
    {
        $row = Aaborelay::where('id',$request->tid)->first();
        return response()->json($row);
    }
}