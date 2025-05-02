<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    // Defines the relationship between a 'PostComment' and a 'User'
    // It indicates that a 'PostComment' belongs to a 'User'
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    // Defines the relationship between a 'PostComment' and a 'Post'
    // It indicates that a 'PostComment' belongs to a 'Post'
    public function post() {
        return $this->belongsTo('App\Models\Post');
    }
}
