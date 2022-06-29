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
use App\Models\Messagelog;
use App\Models\Netsapiensdomainextension;

class MessagelogController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    public function smshistory(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $history = DB::select( DB::raw("SELECT * FROM message_logs WHERE (`from` LIKE '$from' AND recipients LIKE '$to')  OR (`from` LIKE '$to' AND recipients LIKE '$from') ") );
        return response()->json(array($history));
    }
    function unformatphonenumber($number) {
        $justNums = preg_replace("/[^0-9]/", '', $number);
        //eliminate leading 1 if its there
        if (strlen($justNums) > 10) $justNums = preg_replace("/^1/", '',$justNums);
        //if we have 10 digits left, it's probably valid.
        if (strlen($justNums) != 10) {
            return '';
        }
        $justNums = '+1'.$justNums;
        return $justNums;
    }
    public function ajaxsmsmmshistory(Request $request)
    {
        //print_r($this->unformatphonenumber($request->search));exit;
        $columns = ['inbound','`from`','recipients','text','text, mediaURL','carrier','responseText','created_on'];
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $btn = '<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#history_modal" onclick="setpn(this);"><i class="pe-7s-chat"></i></button>';
        $content = '<a style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(this,id);">';
        $sql = "SELECT inbound,`from`,recipients,IF(`text`>'', 'SMS', 'MMS') as `type`,CONCAT('$content','',`text`,'',mediaURL,'','</a>') as content,carrier,responseText,created_on, '".$btn."' FROM message_logs";
        $count_sql = "SELECT COUNT(*) as cnt FROM message_logs";
        if($search['value']) {
            $sql .= " WHERE CONCAT(IF(`inbound`=1, 'Inbound', 'Outbound'), '', `from`, '', recipients, '', IF(`text`>'', 'SMS', 'MMS'), '', `text`, '', mediaURL, '', carrier, '', responseText, '', created_on) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE CONCAT(IF(`inbound`=1, 'Inbound', 'Outbound'), '', `from`, '', recipients, '', IF(`text`>'', 'SMS', 'MMS'), '', `text`, '', mediaURL, '', carrier, '', responseText, '', created_on) LIKE '%".$search['value']."%'";
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
        $recordsTotal = DB::table('message_logs')->count();
        $dt = array();
        foreach($data as $d) {
            $d = (array)$d;
            $d['content'] = $d['type']=='SMS'?str_replace('loaddetails(this,id)', 'loaddetails(this,0)', $d['content']):str_replace('loaddetails(this,id)', 'loaddetails(this,1)', $d['content']);
            $d['inbound'] = $d['inbound']==1?'Inbound':'Outbound';
            $d['from'] = formatphonenumber($d['from']);
            $d['recipients'] = formatphonenumber($d['recipients']);
            $d['created_on'] = niceShort($d['created_on']);
            $dt[] = array_values($d);
        }
        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $dt;
        return response()->json($result);
    }
    public function domainoverview(Request $request)
    {
        $domain = $request->domain;
        //exit($domain);
        $matchrule = Netsapiensdomainextension::select('matchrule')->where('domain_owner', $domain)->get();
        $phones = '0';
        foreach($matchrule as $mr) {
            $mr['matchrule'] = str_replace("sip:","+",$mr['matchrule']);
            $mr['matchrule'] = str_replace("@*","",$mr['matchrule']);
            $phones = $phones.','.$mr['matchrule'];
        }
    
        //print_r($this->unformatphonenumber($request->search));exit;
        $columns = ['inbound','`from`','recipients','text','text, mediaURL','carrier','responseText','created_on'];
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $btn = '<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#history_modal" onclick="setpn(this);"><i class="pe-7s-chat"></i></button>';
        $content = '<a style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(this,id);">';
        $sql = "SELECT inbound,`from`,recipients,IF(`text`>'', 'SMS', 'MMS') as `type`,CONCAT('$content','',`text`,'',mediaURL,'','</a>') as content,carrier,responseText,created_on, '".$btn."' FROM message_logs";
        $count_sql = "SELECT COUNT(*) as cnt FROM message_logs";
        if($search['value']) {
            $sql .= " WHERE (`from` IN (".$phones.") OR recipients IN (".$phones.")) AND CONCAT(IF(`inbound`=1, 'Inbound', 'Outbound'), '', `from`, '', recipients, '', IF(`text`>'', 'SMS', 'MMS'), '', `text`, '', mediaURL, '', carrier, '', responseText, '', created_on) LIKE '%".$search['value']."%'";
            $count_sql .= " WHERE (`from` IN (".$phones.") OR recipients IN (".$phones.")) AND CONCAT(IF(`inbound`=1, 'Inbound', 'Outbound'), '', `from`, '', recipients, '', IF(`text`>'', 'SMS', 'MMS'), '', `text`, '', mediaURL, '', carrier, '', responseText, '', created_on) LIKE '%".$search['value']."%'";
        } else {
            $sql .= " WHERE `from` IN (".$phones.") OR recipients IN (".$phones.")";
            $count_sql .= " WHERE `from` IN (".$phones.") OR recipients IN (".$phones.")";
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
        $recordsTotal = DB::table('message_logs')->count();
        $dt = array();
        foreach($data as $d) {
            $d = (array)$d;
            $d['content'] = $d['type']=='SMS'?str_replace('loaddetails(this,id)', 'loaddetails(this,0)', $d['content']):str_replace('loaddetails(this,id)', 'loaddetails(this,1)', $d['content']);
            $d['inbound'] = $d['inbound']==1?'Inbound':'Outbound';
            $d['from'] = formatphonenumber($d['from']);
            $d['recipients'] = formatphonenumber($d['recipients']);
            $d['created_on'] = niceShort($d['created_on']);
            $dt[] = array_values($d);
        }
        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $dt;
        return response()->json($result);
    }
    public function failedsmsmmshistory(Request $request)
    {
        //print_r($this->unformatphonenumber($request->search));exit;
        $columns = ['inbound','`from`','recipients','text','text, mediaURL','carrier','responseText','created_on'];
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $starttime = str_replace('T',' ', $request->starttime);
        $starttime = $starttime.':00';
        $endtime = str_replace('T',' ', $request->endtime);
        $endtime = $endtime.':59';

        $content = '<a style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(this,id);">';
        $sql = "SELECT inbound,`from`,recipients,IF(`text`>'', 'SMS', 'MMS') as `type`,CONCAT('$content','',`text`,'',mediaURL,'','</a>') as content,carrier,responseText,created_on FROM message_logs";
        $count_sql = "SELECT COUNT(*) as cnt FROM message_logs";
        if($search['value']) {
            $temp_sql = " WHERE responseText='Failed' AND CONCAT(IF(`inbound`=1, 'Inbound', 'Outbound'), '', `from`, '', recipients, '', IF(`text`>'', 'SMS', 'MMS'), '', `text`, '', mediaURL, '', carrier, '', responseText, '', created_on) LIKE '%".$search['value']."%'";
            $temp_sql .= " AND created_on>'$starttime' AND created_on<'$endtime'";
            $sql .= $temp_sql;
            $count_sql .= $temp_sql;
        } else {
            $temp_sql = " WHERE responseText='Failed'";
            $temp_sql .= " AND created_on>'$starttime' AND created_on<'$endtime'";
            $sql .= $temp_sql;
            $count_sql .= $temp_sql;
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
        $recordsTotal = DB::table('message_logs')->count();
        $dt = array();
        foreach($data as $d) {
            $d = (array)$d;
            $d['content'] = $d['type']=='SMS'?str_replace('loaddetails(this,id)', 'loaddetails(this,0)', $d['content']):str_replace('loaddetails(this,id)', 'loaddetails(this,1)', $d['content']);
            $d['inbound'] = $d['inbound']==1?'Inbound':'Outbound';
            $d['from'] = formatphonenumber($d['from']);
            $d['recipients'] = formatphonenumber($d['recipients']);
            //$d['created_on'] = niceShort($d['created_on']);
            $d['created_on'] = $d['created_on'];
            $dt[] = array_values($d);
        }
        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $dt;
        return response()->json($result);
    }
}