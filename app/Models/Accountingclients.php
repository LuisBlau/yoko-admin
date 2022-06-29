<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Accountingclients extends Eloquent
{
    protected $table = 'accounting_clients'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['client', 'client_user_name', 'client_email', 'bus_phone', 'accounting _systemid'];
    //public $timestamps = false;
}