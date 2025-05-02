<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //


    public function user()
    {
        //define an inverse one to many relationship between the Post model and the User model

        return $this->belongsTo('App\Models\User');
    }

    //A Post can have many PostLikes
    public function likes()
    {
        return $this->hasMany('App\Models\PostLike');
    }

    // Defines the relationship between a 'Post' and 'PostComment'
    // It indicates that a 'Post' can have many 'PostComment'
    public function comments() {
        return $this->hasMany('App\Models\PostComment');
    }



}
