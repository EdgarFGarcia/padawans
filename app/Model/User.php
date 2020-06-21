<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // traits

class User extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'id', 'first_name', 'last_name', 'email', 
        'password', 'mobile_number', 'created_at',
        'updated_at', 'deleted_at'
    ];
}
