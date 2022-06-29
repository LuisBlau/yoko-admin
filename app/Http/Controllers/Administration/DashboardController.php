<?php

namespace App\Http\Controllers\Administration;

use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Messagelog;

class DashboardController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    public function dashboardsmshourly(Request $request)
    {
        $timezone = $_COOKIE['curent_zone']/3600;
        //var_dump($timezone);exit;
        //$timezone = 0;
        $sql = "SELECT HOUR(date_add(created_on, INTERVAL +$timezone HOUR)) as 'h', COUNT(id) as 'transaction' FROM message_logs WHERE DATE(Date_add(now(), INTERVAL +$timezone HOUR)) = date(date_add(created_on, INTERVAL +$timezone HOUR)) GROUP BY HOUR(date_add(created_on, INTERVAL +$timezone HOUR)) ORDER BY HOUR(date_add(created_on, INTERVAL +$timezone HOUR))";
        $smshourly = DB::select( DB::raw($sql) );
        return response()->json($smshourly);
    }
    public function dashboardsmsdaily(Request $request)
    {
        $timezone = $_COOKIE['curent_zone']/3600;
        //var_dump($timezone);exit;
        //$timezone = 0;
        $sql = "SELECT DATE(date_add(created_on, INTERVAL $timezone HOUR)) as 'd', COUNT(id) as cnt FROM message_logs
        where (COALESCE(mediaUrl,'') ='')
        Group by DATE(date_add(created_on, INTERVAL $timezone HOUR))
        ORDER BY DATE(date_add(created_on, INTERVAL $timezone HOUR)) DESC
        limit 30;";
        $r1 = DB::select( DB::raw($sql) );

        $sql = "SELECT DATE(date_add(created_on, INTERVAL $timezone HOUR)) as 'd', COUNT(id) as cnt FROM message_logs
        where (COALESCE(mediaUrl,'') <>'')
        Group by DATE(date_add(created_on, INTERVAL $timezone HOUR))
        ORDER BY DATE(date_add(created_on, INTERVAL $timezone HOUR)) DESC
        limit 30;";
        $r2 = DB::select( DB::raw($sql) );

        $result = array();
        $res = array();
        foreach($r1 as $r) {
            $result[$r->d]['a'] = $r->cnt;
        }
        foreach($r2 as $r) {
            $result[$r->d]['b'] = $r->cnt;
        }
        foreach($result as $d=>$r) {
            $res[] = array('y'=>$d, 'a'=>isset($r['a'])?$r['a']:0, 'b'=>isset($r['b'])?$r['b']:0);
        }
        return response()->json($res);
    }
}