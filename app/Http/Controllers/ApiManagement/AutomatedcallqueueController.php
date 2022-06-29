<?php

namespace App\Http\Controllers\ApiManagement;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Configweeklyschedule;
use App\Models\Confignonworkingday;

class AutomatedcallqueueController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    public function tenstreetcallrequests(Request $request)
    {
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $columns = ['subjectid', 'firstname', 'lastname', 'pphone', 'sphone', 'autocall', 'source', 'created_at'];

        $action = '<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#edit_modal" onclick="send_to_queue(this);">Send To Queue</button>  <button class="btn btn-default btn-xs" onclick="archive_call_request(this);">Archive</button>';
        $sql = "SELECT *, '$action' as `action` FROM tenstreet_log";
        $count_sql = "SELECT COUNT(*) as cnt FROM tenstreet_log";
        if($search['value']) {
            $sql .= " WHERE `status` IS NULL AND call_date IS NULL AND CONCAT(`subjectid`, '', firstname, '', `lastname`, '', pphone, '', sphone, '', autocall, '', source) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE `status` IS NULL AND call_date IS NULL AND CONCAT(`subjectid`, '', firstname, '', `lastname`, '', pphone, '', sphone, '', autocall, '', source) LIKE '%".$search['value']."%'";
        } else {
            $sql .= " WHERE `status` IS NULL AND call_date IS NULL";
            $count_sql .= " WHERE `status` IS NULL AND call_date IS NULL";
        }
        foreach($order as $o) {
            $sql.=" ORDER BY ";
            $sql.= $columns[$o['column']];
            $sql.=' ';
            $sql.=$o['dir'];
        }
        $sql .= " LIMIT $start, $length";
        //exit($sql);
        $data = DB::select( DB::raw($sql) );
        $recordsFiltered = DB::select( DB::raw($count_sql) );
        $recordsFiltered = $recordsFiltered[0]->cnt;
        $recordsTotal = DB::table('tenstreet_log')->count();

        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $data;
        return response()->json($result);
    }
    public function tenstreetarchivedcallrequests(Request $request)
    {
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $columns = ['subjectid', 'firstname', 'lastname', 'pphone', 'sphone', 'autocall', 'source', 'created_at'];

        $action = '<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#edit_modal" onclick="send_to_queue(this);">Send To Queue</button>';
        $sql = "SELECT *, '$action' as `action` FROM tenstreet_log";
        $count_sql = "SELECT COUNT(*) as cnt FROM tenstreet_log";
        if($search['value']) {
            $sql .= " WHERE status ='Archived' AND call_date IS NULL AND CONCAT(`subjectid`, '', firstname, '', `lastname`, '', pphone, '', sphone, '', autocall, '', source) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE status ='Archived' AND call_date IS NULL AND CONCAT(`subjectid`, '', firstname, '', `lastname`, '', pphone, '', sphone, '', autocall, '', source) LIKE '%".$search['value']."%'";
        } else {
            $sql .= " WHERE status ='Archived' AND call_date IS NULL";
            $count_sql .= " WHERE status ='Archived' AND call_date IS NULL";
        }
        foreach($order as $o) {
            $sql.=" ORDER BY ";
            $sql.= $columns[$o['column']];
            $sql.=' ';
            $sql.=$o['dir'];
        }
        $sql .= " LIMIT $start, $length";
        //exit($sql);
        $data = DB::select( DB::raw($sql) );
        $recordsFiltered = DB::select( DB::raw($count_sql) );
        $recordsFiltered = $recordsFiltered[0]->cnt;
        $recordsTotal = DB::table('tenstreet_log')->count();

        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $data;
        return response()->json($result);
    }
    public function tenstreetrequestscalled(Request $request)
    {
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $columns = ['subjectid', 'firstname', 'lastname', 'pphone', 'sphone', 'autocall', 'source', 'call_date'];

        $sql = "SELECT * FROM tenstreet_log";
        $count_sql = "SELECT COUNT(*) as cnt FROM tenstreet_log";
        if($search['value']) {
            $sql .= " WHERE status = 'Called' AND CONCAT(`subjectid`, '', firstname, '', `lastname`, '', pphone, '', sphone, '', autocall, '', source) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE status = 'Called' AND CONCAT(`subjectid`, '', firstname, '', `lastname`, '', pphone, '', sphone, '', autocall, '', source) LIKE '%".$search['value']."%'";
        } else {
            $sql .= " WHERE status = 'Called' OR call_date IS NOT NULL";
            $count_sql .= " WHERE status = 'Called' OR call_date IS NOT NULL";
        }
        foreach($order as $o) {
            $sql.=" ORDER BY ";
            $sql.= $columns[$o['column']];
            $sql.=' ';
            $sql.=$o['dir'];
        }
        $sql .= " LIMIT $start, $length";
        //exit($sql);
        $data = DB::select( DB::raw($sql) );
        $recordsFiltered = DB::select( DB::raw($count_sql) );
        $recordsFiltered = $recordsFiltered[0]->cnt;
        $recordsTotal = DB::table('tenstreet_log')->count();

        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $data;
        return response()->json($result);
    }

    public function saveweeklyschedule(Request $request) {
        parse_str($request->data, $get_array);
        $json = json_encode($get_array);

        $conf = Configweeklyschedule::find(1);
        if($conf) {
            $conf->update(
                [
                    'weeklyschedule' => $json
                ]
            );
        } else {
            Configweeklyschedule::create(
                [
                    'weeklyschedule' => $json
                ]
            );
        }
        return $json;
    }

    public function addnonworkingday(Request $request) {
        Confignonworkingday::create(
            [
                'dt' => $request->nonworkingday
            ]
        );
        return true;
    }

    public function deletenonworkingday(Request $request) {
        $dt = Confignonworkingday::where('dt', $request->nonworkingday)->first();
        $dt->delete();
        return true;
    }
}