<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_confirmed_at' => 'datetime',
    ];

    // post関連
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function taggedPosts($tag)
    {
        // $tag: 'favorite' or 'read_later'
        return $this->belongsToMany(Post::class, 'post_user_tags')
            ->wherePivot('tag', $tag)
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role || $this->role === 'admin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function canManagePosts()
    {
        return $this->isAdmin();
    }

    public function canManageUsers()
    {
        return $this->isAdmin();
    }

}