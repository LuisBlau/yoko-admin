<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Aaborelay;
use App\Models\Netsapiensdomainextension;

class AaboController extends Controller
{
    public function aaborelay()
    {
        $data  = Aaborelay::all();
        $extensions = Netsapiensdomainextension::select('netsapiens_domain_extensions.id', 'netsapiens_domain_extensions.matchrule','aabo_relay.extension_id','aabo_relay.destination_url')
            ->leftJoin('aabo_relay','netsapiens_domain_extensions.id','=','aabo_relay.extension_id')
            ->where('netsapiens_domain_extensions.to_host', 'aabo')
            ->get();

        $arr = [];
        foreach($extensions as $extension) {
            $arr[$extension['id']] = $extension['matchrule'];
        }
        
        return view('aabo.aaborelay')
            ->with('arr', $arr)
            ->with('extensions', $extensions)
            ->with('data', $data);
    }
}