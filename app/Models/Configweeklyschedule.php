<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Configweeklyschedule extends Eloquent
{
    protected $table = 'config_weekly_schedule'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['weeklyschedule'];
    //public $timestamps = false;
}