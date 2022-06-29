<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Aaborelay extends Eloquent
{
    protected $table = 'aabo_relay'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['extension_id', 'destination_url'];
    //public $timestamps = false;
}