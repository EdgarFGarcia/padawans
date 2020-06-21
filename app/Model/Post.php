<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; // traits

class Post extends Model
{
    //
    use SoftDeletes;
    protected $table = 'posts';
    protected $fillable = [
        'id', 'posts', 'users_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function getUser(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');
    }

    public function getComments(){
        return $this->hasMany('App\Model\Comment', 'posts_id', 'id');
    }
}
