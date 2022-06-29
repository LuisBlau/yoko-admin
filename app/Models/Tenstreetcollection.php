<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenstreetcollection extends Model
{
    use HasFactory;
    protected $table = 'tenstreet_collections'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
}