<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    // 編集：本人のみ
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    // 削除：本人または管理者
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->role === 'admin';
    }
}
