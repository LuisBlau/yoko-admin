<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Accountingdailybillingcount extends Eloquent
{
    protected $table = 'accounting_daily_billing_counts'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['netsapiens_domain_id', 'num_of_extensions', 'date_of_count', 'num_of_sms_messages_in', 'num_of_mms_messages_in', 'num_of_sms_messages_out', 'num_of_mms_messages_out'];
    //public $timestamps = false;
}