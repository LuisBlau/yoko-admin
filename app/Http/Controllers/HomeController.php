<?php

namespace App\Http\Controllers;

use Session;
use Carbon;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Messagelog;
use App\Models\Customerdomains;
use App\Models\Netsapiens_domain;
use App\Models\Netsapiensdomainsummary;
use App\Models\Netsapiensdomainextension;
use App\Models\Netsapiensdomainextentionswithsms;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        switch(Auth::user()->role_id) {
            case 1:
                $date = new \DateTime();
                $date->modify('-24 hours');
                $formatted_date = $date->format('Y-m-d H:i:s');
        
                $total = array('in'=>0, 'out'=>0, 'sms'=>0, 'mms'=>0);
                /*$inout = Messagelog::select('inbound', DB::raw('count(*) as total'))
                ->where('created_on','>',$formatted_date)
                ->groupBy('inbound')
                ->get()->toArray();*/
        
                $sql = "SELECT `inbound`, COUNT(*) AS total FROM `message_logs` WHERE `created_on` > '$formatted_date' GROUP BY `inbound`;";
                $inout = DB::select($sql);
        
                foreach($inout as $io) {
                    $type = $io->inbound==1?"in":"out";
                    $total[$type] = $io->total;
                }
        /*
                $sms = Messagelog::select(DB::raw('count(*) as total'))
                ->where("created_on",">",Carbon::now()->subDay(1))
                ->whereRaw('mediaUrl = "" OR mediaUrl IS NULL')
                //->where('mediaUrl', '=', '')
                //->orWhereNull('mediaUrl')
                ->get()->toArray();
        
                $mms = Messagelog::select(DB::raw('count(*) as total'))
                ->where("created_on",">",Carbon::now()->subDay(1))
                ->whereRaw('mediaUrl <> "" AND mediaUrl IS NOT NULL')
                ->get()->toArray();
        */
                $sql = "SELECT COUNT(*) AS total FROM `message_logs` WHERE `created_on` > '$formatted_date' AND (`mediaUrl` = '' OR `mediaUrl` IS NULL);";
                $sms = DB::select($sql);
              
                $sql = "SELECT COUNT(*) AS total FROM `message_logs` WHERE `created_on` > '$formatted_date' AND (`mediaUrl` <> '' AND `mediaUrl` IS NOT NULL);";
                $mms = DB::select($sql);
        
                $total['sms'] = $sms[0]->total;
                $total['mms'] = $mms[0]->total;
        
                $msglogs = Messagelog::orderBy('id', 'desc')->take(10)
                ->get()->toArray();
                         
                return view('home')
                ->with('total', $total)
                ->with('msglogs', $msglogs);
                break;
            case 2:
                $domain = $request->v;
                
                //$usercount = Netsapiensdomainsummary::select('current_user')->where('domain', $domain)->first();
                $domains = Customerdomains::select('domain')->where('user_id', Auth::id())->pluck('domain');

                if(!$domain) {
                    if(count($domains)>0) {
                        $domain = ucfirst($domains[0]);
                    }
                }

                $numext = Netsapiensdomainextension::select(DB::raw('count(*) as total'))->where('domain_owner', $domain)->get();
                $numextsms = Netsapiensdomainextentionswithsms::select(DB::raw('count(*) as total'))->where('domain', $domain)->get();
                //print_r($domains);exit;

                $num = array();
                $num['numext'] = $numext[0]['total'];
                $num['numextsms'] = $numextsms[0]['total'];
/*        
                $matchrule = Netsapiensdomainextension::select('matchrule')->where('domain_owner', $domain)->get();
                $phones = array();
                foreach($matchrule as $mr) {
                    $mr['matchrule'] = str_replace("sip:","+",$mr['matchrule']);
                    $mr['matchrule'] = str_replace("@*","",$mr['matchrule']);
                    $phones[] = $mr['matchrule'];
                }
                $msglogs = Messagelog::whereIn('from', $phones)->orWhereIn('recipients', $phones)->get();
*/
                return view('dashboard.pbxdomaindetail')
                    ->with('num', $num)
                    ->with('domain', $domain)
                    ->with('domains', $domains);
                break;
            default:
                break;
        }
    }
}
