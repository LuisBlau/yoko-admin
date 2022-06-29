<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class TenstreetCallRelayLog extends Eloquent
{
    protected $table = 'tenstreet_call_relay_logs';
    protected $primaryKey = 'id';
    protected $fillable = ['domain', 'headers', 'body', 'tenstreet_response'];
    public $timestamps = false;
}
