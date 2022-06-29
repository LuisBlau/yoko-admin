<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Netsapiens_domain;
use App\Models\Netsapiensdomainsummary;
use App\Models\Netsapiensdomainextension;
use App\Models\Netsapiensdomainextentionswithsms;
use App\Models\Messagelog;

class PbxController extends Controller
{
    public function testpeerless()
    {
        return view('pbx.peerless');
    }
    public function pbxdomains()
    {
        $domains = Netsapiens_domain::all();
        return view('pbx.pbxdomains')
            ->with('domains', $domains);
    }
    public function pbxdomaindetail($domain)
    {
        $usercount = Netsapiensdomainsummary::select('current_user')->where('domain', $domain)->first();
        $numext = Netsapiensdomainextension::select(DB::raw('count(*) as total'))->where('domain_owner', $domain)->get();
        $numextsms = Netsapiensdomainextentionswithsms::select(DB::raw('count(*) as total'))->where('domain', $domain)->get();
        
        $num = array();
        $num['numext'] = $numext[0]['total'];
        $num['numextsms'] = $numextsms[0]['total'];

        $matchrule = Netsapiensdomainextension::select('matchrule')->where('domain_owner', $domain)->get();
        $phones = array();
        foreach($matchrule as $mr) {
            $mr['matchrule'] = str_replace("sip:","+",$mr['matchrule']);
            $mr['matchrule'] = str_replace("@*","",$mr['matchrule']);
            $phones[] = $mr['matchrule'];
        }
        $msglogs = Messagelog::whereIn('from', $phones)->orWhereIn('recipients', $phones)->get();
//        print_r($msglogs);exit;
        return view('pbx.pbxdomaindetail')
            ->with('num', $num)
            ->with('domain', ucfirst($domain))
            ->with('usercount', $usercount['current_user'])
            ->with('msglogs', $msglogs);
    }
    public function pbxdomainsummary()
    {
        $domains = Netsapiensdomainsummary::all();
        return view('pbx.pbxdomainsummary')
            ->with('domains', $domains);
    }
    public function pbxdomainextension()
    {
        $domains = Netsapiensdomainextension::all();
        return view('pbx.pbxdomainextension')
            ->with('domains', $domains);
    }
    public function pbxsmsenablednumber()
    {
        $domains = Netsapiensdomainextentionswithsms::all();
        return view('pbx.pbxsmsenablednumber')
            ->with('domains', $domains);
    }
    public function resendfailedmessages()
    {
        $min = Messagelog::where('responseText', 'Failed')->min('created_on');
        $max = Messagelog::where('responseText', 'Failed')->max('created_on');
        //2021-06-12T19:30
        $min = date('Y-m-d\TH:i', strtotime($min));
        $max = date('Y-m-d\TH:i', strtotime($max));
        return view('pbx.resendfailedmessages')
            ->with('min', $min)
            ->with('max', $max);
    }
}