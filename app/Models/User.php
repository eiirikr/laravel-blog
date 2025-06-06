<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //DEFINE A ONE TO MANY RELATIONSHIP between the User Model and the Post Model

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    //A User can have many PostLikes
    public function likes()
    {
        return $this->hasMany('App\Models\PostLike');
    }

    // Defines the relationship between a 'User' and 'PostComment'
    // It indicates that a 'User' can have many 'PostComment'
    public function comments() {
        return $this->hasMany('App\Models\PostComment');
    }

}
