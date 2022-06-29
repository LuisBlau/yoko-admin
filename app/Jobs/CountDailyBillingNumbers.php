<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Accountingdailybillingcount;
use App\Models\Netsapiens_domain;
use App\Models\Netsapiensdomainextension;
use App\Models\Messagelog;
use App\Models\Accountsystemtopbxclient;
use Illuminate\Support\Facades\Log;

class CountDailyBillingNumbers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 500;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$domains = Netsapiens_domain::all();

        set_time_limit(0);
        $total_counts = DB::select("SELECT d.id, d.domain, smsFrom.fromSms, smsTo.toSms, mmsFrom.fromMms , mmsTo.toMms
                                                FROM
                                                    `netsapiens_domains` d
                                                Left JOIN
                                                    (SELECT COUNT(ml.id) as fromSms, m.domain FROM `message_logs` ml
                                                    INNER JOIN
                                                    `netsapiens_domain_extentions_with_sms` m
                                                    ON m.number = SUBSTRING(ml.from, 2, 11)

                                                    WHERE date(ml.created_on) = CURDATE() AND ml.mediaUrl = ''
                                                    GROUP BY m.domain) smsFrom
                                                on smsFrom.domain = d.domain
                                                Left JOIN
                                                    (SELECT COUNT(ml.id) as toSms, m.domain FROM `message_logs` ml
                                                    INNER JOIN
                                                    `netsapiens_domain_extentions_with_sms` m
                                                    ON m.number = SUBSTRING(ml.recipients, 2, 11)

                                                    WHERE date(ml.created_on) = CURDATE() AND ml.mediaUrl = ''
                                                    GROUP BY m.domain) smsTo
                                                on smsTo.domain = d.domain
                                                Left JOIN
                                                    (SELECT COUNT(ml.id) as fromMms, m.domain FROM `message_logs` ml
                                                    INNER JOIN
                                                    `netsapiens_domain_extentions_with_sms` m
                                                    ON m.number = SUBSTRING(ml.from, 2, 11)

                                                    WHERE date(ml.created_on) = CURDATE() AND ml.mediaUrl <>''
                                                    GROUP BY m.domain) mmsFrom
                                                on mmsFrom.domain = d.domain
                                                Left JOIN
                                                    (SELECT COUNT(ml.id) as toMms, m.domain FROM `message_logs` ml
                                                    INNER JOIN
                                                    `netsapiens_domain_extentions_with_sms` m
                                                    ON m.number = SUBSTRING(ml.recipients, 2, 11)

                                                    WHERE date(ml.created_on) = CURDATE() AND ml.mediaUrl <> ''
                                                    GROUP BY m.domain) mmsTo
                                                on mmsTo.domain = d.domain");
        foreach($total_counts as $iterator) {
            $row = new Accountingdailybillingcount();
            $row->netsapiens_domain_id = $iterator->id;
            $row->num_of_extensions = Netsapiensdomainextension::where('domain_owner', $iterator->domain)->count();
            $row->date_of_count = date('Y-m-d');
            $row->num_of_sms_messages_in = $iterator->fromSms?? 0;
            $row->num_of_mms_messages_in = $iterator->fromMms?? 0;
            $row->num_of_sms_messages_out = $iterator->toSms?? 0;
            $row->num_of_mms_messages_out = $iterator->toMms?? 0;
            $row->save();
        }
    }
}
