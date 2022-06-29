<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Customerdomains;
use App\Models\Netsapiens_domain;
use App\Models\Netsapiensdomainsummary;
use App\Models\Netsapiensdomainextension;
use App\Models\Netsapiensdomainextentionswithsms;
use App\Models\Messagelog;

class DashboardController extends Controller
{
    public function pbxdomaindetail()
    {
        $domain = 'aabo';
        //$usercount = Netsapiensdomainsummary::select('current_user')->where('domain', $domain)->first();
        $domains = Customerdomains::select('domain')->where('user_id', Auth::id())->pluck('domain');
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
        return view('dashboard.pbxdomaindetail')
            ->with('num', $num)
            ->with('domain', ucfirst($domain))
            ->with('domains', $domains)
            //->with('usercount', $usercount['current_user'])
            ->with('msglogs', $msglogs);
    }
}