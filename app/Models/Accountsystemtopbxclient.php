<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Accountsystemtopbxclient extends Eloquent
{
    protected $table = 'account_system_to_pbx_clients'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['account_id', 'domain'];
    //public $timestamps = false;
}