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
use App\Models\Apicollection;
use App\Models\Tenstreetcollection;

class ApicollectionController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    public function setCurrentTimeZone(Request $request) { //To set the current timezone offset in session
        $current_time_zone = $request->curent_zone;
        session()->put('current_time_zone',  $current_time_zone);
        return $current_time_zone;
    }
    public function apireviewdata(Request $request)
    {
        dd($request->all());
        $data = Apicollection::orderBy('apiDate','desc')->skip($request->start)->take($request->length)->get();
        for($i=0;$i<count($data);$i++) {
            $data[$i]['headers'] = strlen($data[$i]['headers']) > 50 ? substr($data[$i]['headers'],0,50)."..." : $data[$i]['headers'];
            $data[$i]['body'] = strlen($data[$i]['body']) > 50 ? substr($data[$i]['body'],0,50)."..." : $data[$i]['body'];
        }
        $result = array();
        $result['draw'] = 1;
        $result['recordsTotal'] = count($data);
        $result['recordsFiltered'] = count($data);
        $result['data'] = $data;
        return response()->json($result);
    }
    public function ajaxapireviewdata(Request $request)
    {
        $columns = ['headers','body','apiDate'];
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;

        $content = '<a style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(id);">';
        $sql = "SELECT message_id, headers, body, apiDate FROM apicollections";
        $count_sql = "SELECT COUNT(*) as cnt FROM apicollections";
        if($search['value']) {
            $sql .= " WHERE CONCAT(headers, '', body, '', apiDate) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE CONCAT(headers, '', body, '', apiDate) LIKE '%".$search['value']."%'";
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
        $recordsTotal = DB::table('apicollections')->count();
        $dt = array();
        foreach($data as $d) {
            //str_replace('loaddetails(this,id)', 'loaddetails(this,0)', $d['content'])
            $d->headers = strlen($d->headers) > 50 ? substr($d->headers,0,50)."..." : $d->headers;
            $d->body = strlen($d->body) > 50 ? substr($d->body,0,50)."..." : $d->body;

            $d = (array)$d;
            //unset($d['message_id']);
            $dt[] = $d;
        }
        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $dt;
        return response()->json($result);
    }
    public function ajaxtenstreetreviewdata(Request $request)
    {
        $columns = ['headers','body','apiDate'];
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;

        $content = '<a style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(id);">';
        $sql = "SELECT id, headers, body, apiDate FROM tenstreet_collections";
        $count_sql = "SELECT COUNT(*) as cnt FROM tenstreet_collections";
        if($search['value']) {
            $sql .= " WHERE CONCAT(headers, '', body, '', apiDate) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE CONCAT(headers, '', body, '', apiDate) LIKE '%".$search['value']."%'";
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
        $recordsTotal = DB::table('tenstreet_collections')->count();
        $dt = array();
        foreach($data as $d) {
            //str_replace('loaddetails(this,id)', 'loaddetails(this,0)', $d['content'])
            $d->headers = strlen($d->headers) > 50 ? substr($d->headers,0,50)."..." : $d->headers;
            $d->body = strlen($d->body) > 50 ? substr($d->body,0,50)."..." : $d->body;
            $d->body = htmlentities($d->body);
            $d = (array)$d;
            //unset($d['message_id']);
            $dt[] = $d;
        }
        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $dt;
        return response()->json($result);
    }
    public function getapicollection(Request $request)
    {
        $url = $request->url;
        $headers = get_headers($url);
        $requestBody = file_get_contents('php://input');
        $responseBody = file_get_contents($url);

        $result = array();
        $result['headers'] = $headers;
        $result['requestbody'] = $requestBody;
        $result['responsebody'] = $responseBody;
        
        return response()->json($result);
    }
    public function loaddetails(Request $request)
    {
        $idx = $request->idx;
        $data = Apicollection::where('id', $idx)->get();
        return response()->json($data[0]);
    }
    public function loadtenstreetdetails(Request $request)
    {
        $idx = $request->idx;
        $data = Tenstreetcollection::where('id', $idx)->get();
        return response()->json($data[0]);
    }
}