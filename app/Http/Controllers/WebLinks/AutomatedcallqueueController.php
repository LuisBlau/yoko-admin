<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Configweeklyschedule;
use App\Models\Confignonworkingday;

class AutomatedcallqueueController extends Controller
{
    public function tenstreetcallrequests()
    {
        return view('automatedcallqueue.tenstreetcallrequests')
            ->with('role', Auth::user()->role_id);
    }
    public function tenstreetrequestscalled()
    {
        return view('automatedcallqueue.tenstreetrequestscalled')
            ->with('role', Auth::user()->role_id);
    }
    public function agentavailabilityconfig()
    {
        $weeklyschedule = Configweeklyschedule::find(1);
        if($weeklyschedule) $weeklyschedule = json_decode($weeklyschedule['weeklyschedule'], true);
        else $weeklyschedule = array();

        $nonworkingdays = Confignonworkingday::where('dt','>','2021-01-01')->pluck('dt')->toArray();
        return view('automatedcallqueue.agentavailabilityconfig')
            ->with('ws', $weeklyschedule)
            ->with('nwds', $nonworkingdays)
            ->with('role', Auth::user()->role_id);
    }
}