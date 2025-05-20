<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{   
     public function index(Request $request)
     {
     $posts = Post::with('user')->latest()->get();

     if ($request->ajax() || $request->wantsJson()) {
          return response()->json($posts);
     }

     return view('posts.index', compact('posts'));
     }
 
     public function store(Request $request)
     {
     $data = $request->validate([
          'title' => 'required|max:255',
          'body' => 'required',
     ]);
     $data['user_id'] = Auth::id();
     $post = Post::create($data);

     // AjaxリクエストならJSONで返す
     if ($request->ajax() || $request->wantsJson()) {
          return response()->json([
               'status' => '投稿が完了しました',
               'post' => $post->load('user'),
          ]);
     }

     // 通常のフォーム送信はリダイレクト
     return redirect()->route('posts.index')->with('status', '投稿が完了しました');
     }
 
     public function show(Post $post)
     {
         return response()->json($post->load('user'));
     }
 
     public function update(Request $request, Post $post)
     {
         $this->authorize('update', $post);
 
         $data = $request->validate([
             'title' => 'required|max:255',
             'body' => 'required',
         ]);
         $post->update($data);
 
         return response()->json(['status' => '更新しました']);
     }
}

