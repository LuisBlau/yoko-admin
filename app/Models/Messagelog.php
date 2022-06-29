<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Messagelog extends Eloquent
{
    protected $table = 'message_logs'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['inbound', 'from', 'recipients', 'ccRecipients', 'text', 'mediaURL', 'carrier', 'responseText','created_on'];
    public $timestamps = false;
}