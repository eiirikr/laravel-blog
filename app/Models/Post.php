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



}
