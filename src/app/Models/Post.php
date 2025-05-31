<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'body',
        'user_id',
        'published_at', // ← これも忘れずに
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ここから追加
    public function tagUsers($tag)
    {
        // $tag: 'favorite' or 'read_later'
        return $this->belongsToMany(User::class, 'post_user_tags')
            ->wherePivot('tag', $tag)
            ->withTimestamps();
    }

    // この投稿が指定タグでこのユーザーにタグ付けされているか
    public function isTaggedBy($user, $tag)
    {
        if (!$user) return false;
        return $this->tagUsers($tag)->where('user_id', $user->id)->exists();
    }
}