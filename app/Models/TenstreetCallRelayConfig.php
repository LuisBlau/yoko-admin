<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenstreetCallRelayConfig extends Eloquent
{

    protected $table = 'tenstreet_call_relay_configs';
    protected $primaryKey = 'id';
    protected $fillable = ['netsapiens_domain_id', 'subscription_id', 'destination_url'];
    public $timestamps = false;

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Netsapiens_domain::class, 'netsapiens_domain_id');
    }
}
