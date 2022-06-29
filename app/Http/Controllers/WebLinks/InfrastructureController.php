<?php

namespace App\Http\Controllers\WebLinks;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Messagelog;

class InfrastructureController extends Controller
{
    public function switchstatus_old()
    {
        $total = array();
        $total['in_carrier'] = Messagelog::select(DB::raw('carrier, count(*) as total'))->where('inbound',1)->groupBy('carrier')->get();
        $total['out_carrier'] = Messagelog::select(DB::raw('carrier, count(*) as total'))->where('inbound',0)->groupBy('carrier')->get();
        $total['in_clients'] = Messagelog::select(DB::raw('`from`, count(*) as total'))->groupBy('from')->get();
        $total['out_clients'] = Messagelog::select(DB::raw('recipients, count(*) as total'))->groupBy('recipients')->get();
        return view('infrastructure.switchstatus')
            ->with('total', $total);
    }
    public function switchstatus()
    { 
        $total = array();
        $servername = "sipdb1.yoko.us";
        $username = "vsmonitor";
        $password = "Dakine";
        $dbname = "voipswitch";

/*
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
*/
        $sql = "SELECT * FROM cc_total_in_calls WHERE in_name LIKE '*%';" ;
        $result = DB::connection('mysql2')->select($sql);
        $temp = array();
        if (count($result) > 0) {
            foreach($result as $row) {
                $temp[] = array('carrier'=>$row->in_name, 'total'=>$row->total_in_calls);
            }
        }
        $total['in_carrier'] = $temp;

        $sql = "SELECT * FROM cc_total_out_calls WHERE out_name LIKE '*%';" ;
        $result = DB::connection('mysql2')->select($sql);
        $temp = array();
        if (count($result) > 0) {
            foreach($result as $row) {
                $temp[] = array('carrier'=>$row->out_name, 'total'=>$row->total_out_calls);
            }
        }
        $total['out_carrier'] = $temp;

        $sql = "SELECT * FROM cc_total_out_calls WHERE out_name NOT LIKE '*%';" ;
        $result = DB::connection('mysql2')->select($sql);
        $temp = array();
        if (count($result) > 0) {
            foreach($result as $row) {
                $temp[] = array('from'=>$row->out_name, 'total'=>$row->total_out_calls);
            }
        }
        $total['in_clients'] = $temp;

        $sql = "SELECT * FROM cc_total_in_calls WHERE in_name NOT LIKE '*%';" ;
        $result = DB::connection('mysql2')->select($sql);
        $temp = array();
        if (count($result) > 0) {
            foreach($result as $row) {
                $temp[] = array('recipients'=>$row->in_name, 'total'=>$row->total_in_calls);
            }
        }
        $total['out_clients'] = $temp;

        return view('infrastructure.switchstatus')
            ->with('total', $total);
    }
}