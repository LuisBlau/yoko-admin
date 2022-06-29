<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Failedjob extends Eloquent
{
    protected $table = 'failed_jobs'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['message_id', 'payload', 'exception','failed_at'];
    public $timestamps = false;
}