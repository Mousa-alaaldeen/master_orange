<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * A user has many posts.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id'); // Assuming 'user_id' is the foreign key in the posts table
    }

    /**
     * A user has many comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id'); // Assuming 'customer_id' is the foreign key in the comments table
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

}
