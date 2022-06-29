<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Confignonworkingday extends Eloquent
{
    protected $table = 'config_nonworking_days'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['dt'];
    //public $timestamps = false;
}