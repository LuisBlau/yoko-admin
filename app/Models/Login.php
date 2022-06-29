<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Login extends Eloquent
{
    protected $table = 'user_logins'; // Enter the table name here
    protected $primaryKey = 'id'; // Enter the primary key here

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['userid', 'ip', 'country', 'region', 'city'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
}