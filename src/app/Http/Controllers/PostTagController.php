<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostTagController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $request->validate([
            'tag' => 'required|in:favorite,read_later'
        ]);
        $tag = $request->input('tag');
        $user = auth()->user();

        $exists = $post->isTaggedBy($user, $tag);
        if ($exists) {
            // 解除
            $post->tagUsers($tag)->detach($user->id);
        } else {
            // 追加
            $post->tagUsers($tag)->attach($user->id, ['tag' => $tag]);
        }
        return back();
    }
}