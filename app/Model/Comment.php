<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // traits

class Comment extends Model
{
    //
    use SoftDeletes;
    protected $table = 'comments';
    protected $fillable = [
        'id', 'comments', 'posts_id', 'created_at', 'updated_at', 'deleted_at'
    ];

}
