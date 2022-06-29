<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agentinqueue extends Model
{
    use HasFactory;
    protected $table = 'agents_in_queue'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
}
