<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Netsapiensdomainextentionswithsms extends Model
{
    use HasFactory;
    protected $table = 'netsapiens_domain_extentions_with_sms'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['number', 'application', 'domain', 'dest', 'carrier', 'mmsCapable', 'groupMMSCapable'];
}
