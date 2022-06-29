<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Tenstreetlog extends Eloquent
{
    protected $table = 'tenstreet_log'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['subjectid', 'domain', 'firstname', 'lastname', 'pphone', 'sphone', 'autocall', 'source', 'status', 'call_date'];
    public $timestamps = true;
}