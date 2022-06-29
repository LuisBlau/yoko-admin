<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerdomains extends Model
{
    use HasFactory;
    protected $table = 'customer_domains'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here
    protected $fillable = ['user_id', 'domain'];
}
