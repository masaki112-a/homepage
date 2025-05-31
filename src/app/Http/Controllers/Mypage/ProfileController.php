<?php

namespace App\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        //コメント
        $myCommentCount = $user->comments()->count();
        $otherCommentCount = $user->role === 'admin'
            ? \App\Models\Comment::where('user_id', '!=', $user->id)->count()
            : null;

        // タグごとの投稿数取得
        $favoriteCount = $user->taggedPosts('favorite')->count();
        $readLaterCount = $user->taggedPosts('read_later')->count();

        return view('mypage.mypage', compact(
            'myCommentCount', 'otherCommentCount',
            'favoriteCount', 'readLaterCount'
        ));
    }

    public function edit()
    {
        return view('mypage.profile-update'); 
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:1024'], // 1MB max
        ]);

        if ($request->hasFile('avatar')) {
            // 古いアバター画像を削除
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            // 新しいアバター画像を保存
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function comments()
    {
        $user = auth()->user();
        // コメントと、そのコメントが属する投稿も一緒に取得
        $comments = $user->comments()->with('post')->latest()->paginate(10);
        return view('mypage.comments', compact('comments'));
    }

    public function favorites()
    {
        $user = auth()->user();
        $posts = $user->taggedPosts('favorite')->latest()->paginate(10);
        return view('mypage.fav', compact('posts'));
    }

    public function watchLater()
    {
        $user = auth()->user();
        $posts = $user->taggedPosts('read_later')->latest()->paginate(10);
        return view('mypage.watch-later', compact('posts'));
    }
}