<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Netsapiens_domain extends Model
{
    use HasFactory;
    protected $table = 'netsapiens_domains'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
}
