<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Tenstreetconfig extends Eloquent
{
    protected $table = 'tenstreet_configs'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['domain', 'queue_name', 'origination_did', 'ani_did', 'status'];
    //public $timestamps = false;
}