<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    public $timestamps = false;
}
