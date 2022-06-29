<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Netsapiensdomainsummary extends Model
{
    use HasFactory;
    protected $table = 'netsapiens_domain_summaries'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
}
