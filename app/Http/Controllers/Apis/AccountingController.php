<?php

namespace App\Http\Controllers\Apis;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use App\Models\Accountingdailybillingcount;
use App\Models\Netsapiens_domain;
use App\Models\Netsapiensdomainextension;
use App\Models\Messagelog;
use App\Models\Accountsystemtopbxclient;
use Illuminate\Support\Facades\Log;
use App\Jobs\CountDailyBillingNumbers;

class AccountingController
{
    public function countdailybillingnumbers()
    {
        CountDailyBillingNumbers::dispatchAfterResponse();
        // $domains = Netsapiens_domain::all();

        // $cnt_sms_in = DB::select("SELECT COUNT(*) AS cnt FROM message_logs WHERE date(created_on) = CURDATE() AND recipients IN (SELECT CONCAT('+', SUBSTRING(matchrule, 5, 11)) AS phone FROM netsapiens_domain_extensions WHERE domain_owner = :domain) AND inbound='1' AND mediaUrl=''", ['domain' => 'zoomtransco']);

        // foreach($domains as $domain) {
        //     $row = new Accountingdailybillingcount();
        //     $row->netsapiens_domain_id = $domain->id;
        //     $row->num_of_extensions = Netsapiensdomainextension::where('domain_owner', $domain->domain)->count();
        //     $row->date_of_count = date('Y-m-d');

        //     $cnt_sms_in = DB::select("SELECT COUNT(*) AS cnt FROM message_logs WHERE date(created_on) = CURDATE() AND recipients IN (SELECT CONCAT('+', SUBSTRING(matchrule, 5, 11)) AS phone FROM netsapiens_domain_extensions WHERE domain_owner = :domain) AND inbound='1' AND mediaUrl=''", ['domain' => $domain->domain]);
        //     $cnt_mms_in = DB::select("SELECT COUNT(*) AS cnt FROM message_logs WHERE date(created_on) = CURDATE() AND recipients IN (SELECT CONCAT('+', SUBSTRING(matchrule, 5, 11)) AS phone FROM netsapiens_domain_extensions WHERE domain_owner = :domain) AND inbound='1' AND mediaUrl<>''", ['domain' => $domain->domain]);
        //     $cnt_sms_out = DB::select("SELECT COUNT(*) AS cnt FROM message_logs WHERE date(created_on) = CURDATE() AND recipients IN (SELECT CONCAT('+', SUBSTRING(matchrule, 5, 11)) AS phone FROM netsapiens_domain_extensions WHERE domain_owner = :domain) AND inbound='0' AND mediaUrl=''", ['domain' => $domain->domain]);
        //     $cnt_mms_out = DB::select("SELECT COUNT(*) AS cnt FROM message_logs WHERE date(created_on) = CURDATE() AND recipients IN (SELECT CONCAT('+', SUBSTRING(matchrule, 5, 11)) AS phone FROM netsapiens_domain_extensions WHERE domain_owner = :domain) AND inbound='0' AND mediaUrl<>''", ['domain' => $domain->domain]);

        //     //$cnt = Messagelog::where('inbound', 1)->where('mediaUrl', '')->whereIn('recipients', DB::raw("SELECT CONCAT('+', SUBSTRING(matchrule, 5, 11)) AS phone FROM netsapiens_domain_extensions WHERE domain_owner = '".$domain->domain."'"))->count();
        //     $row->num_of_sms_messages_in = $cnt_sms_in[0]->cnt;
        //     $row->num_of_mms_messages_in = $cnt_mms_in[0]->cnt;
        //     $row->num_of_sms_messages_out = $cnt_sms_out[0]->cnt;
        //     $row->num_of_mms_messages_out = $cnt_mms_out[0]->cnt;
        //     $row->save();
        // }
        // return;
    }
    public function getstats(Request $request)
    {
        $year_month = $request->year_month;
        $client_id = $request->client_id;
        $domain_ids = Accountsystemtopbxclient::join('netsapiens_domains','netsapiens_domains.domain','=','account_system_to_pbx_clients.domain')->where('account_id', $client_id)->pluck('netsapiens_domains.id')->toArray();

        $sql = "SELECT AVG(num_of_extensions) as avg_num_ext, MAX(num_of_extensions) as max_num_ext, SUM(num_of_sms_messages_in) as total_sms_in, SUM(num_of_mms_messages_in) as total_mms_in, SUM(num_of_sms_messages_out) as total_sms_out, SUM(num_of_mms_messages_out) as total_mms_out FROM accounting_daily_billing_counts";

        $tempsql = " WHERE date_of_count REGEXP '$year_month'";
        if(count($domain_ids)>0) {
            $tempsql .= " AND netsapiens_domain_id IN (".implode(',', $domain_ids).") ";
        } else {
            $tempsql .= " AND netsapiens_domain_id = '0' ";
        }
        $sql .= $tempsql;

        $data = DB::select( DB::raw($sql) );
        $data = $data[0];
        foreach($data as $k=>$v) {
            $data->$k = floatval($v);
        }
        $data->grand_total_in = $data->total_sms_in + $data->total_mms_in;
        $data->grand_total_out = $data->total_sms_out + $data->total_mms_out;
        return response()->json($data);
    }
    public function getmonthlydata(Request $request)
    {
        //$data = Accountsystemtopbxclient::select('account_system_to_pbx_clients.*','accounting_clients.client')->join('accounting_clients','accounting_clients.id','=','account_system_to_pbx_clients.account_id')->get();
        $columns = ['netsapiens_domain_id','num_of_extensions','date_of_count','num_of_sms_messages_in','num_of_mms_messages_in','num_of_sms_messages_out','num_of_mms_messages_out'];
        $draw = $request->draw;
        $order = $request->order;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search;
        $year_month = $request->year_month;
        $client_id = $request->client_id;

        $domain_ids = Accountsystemtopbxclient::join('netsapiens_domains','netsapiens_domains.domain','=','account_system_to_pbx_clients.domain')->where('account_id', $client_id)->pluck('netsapiens_domains.id')->toArray();

        $sql = "SELECT a.*, n.domain FROM accounting_daily_billing_counts AS a LEFT JOIN netsapiens_domains AS n ON a.netsapiens_domain_id = n.id";
        $count_sql = "SELECT COUNT(*) as cnt FROM accounting_daily_billing_counts";
        if($search['value']) {
            $tempsql = " WHERE date_of_count REGEXP '$year_month' AND CONCAT(domain, '', num_of_extensions, '', date_of_count, '', num_of_sms_messages_in, '', num_of_mms_messages_in, '', num_of_sms_messages_out, '', num_of_mms_messages_out) LIKE '%".$search['value']."%'";
            if(count($domain_ids)>0) {
                $tempsql .= " AND netsapiens_domain_id IN (".implode(',', $domain_ids).") ";
            } else {
                $tempsql .= " AND netsapiens_domain_id = '0' ";
            }
            $sql .= $tempsql;
            $count_sql .= $tempsql;
        } else {
            $tempsql = " WHERE date_of_count REGEXP '$year_month'";
            if(count($domain_ids)>0) {
                $tempsql .= " AND netsapiens_domain_id IN (".implode(',', $domain_ids).") ";
            } else {
                $tempsql .= " AND netsapiens_domain_id = '0' ";
            }
            $sql .= $tempsql;
            $count_sql .= $tempsql;
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
        $recordsTotal = DB::table('accounting_daily_billing_counts')->count();
        $dt = array();
        foreach($data as $d) {
            $d = (array)$d;
            //$d['date_of_count'] = niceShort($d['date_of_count']);
            $dt[] = array_values($d);
        }
        $result = array();
        $result['draw'] = intval($draw);
        $result['recordsTotal'] = $recordsTotal;
        $result['recordsFiltered'] = $recordsFiltered;
        $result['data'] = $data;

        return response()->json($result);
    }
}
