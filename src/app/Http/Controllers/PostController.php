<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('comments','user')->latest();

        // 管理者以外は公開済みのみ
        if (auth()->user()->role !== 'admin') {
            $query->where(function($q){
                $q->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
            });
        }
        // 検索キーワード
        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
            });
        }
        $posts = $query->paginate(10)->withQueryString();

        return view('posts.index', compact('posts'));
    }

    // 投稿詳細
    public function show(Post $post)
    {
        $post->load('comments.user'); // コメントとユーザーも取得
        return view('posts.show', compact('post'));
    }

    // 投稿作成画面
    public function create()
    {
        return view('posts.create');
    }

    // 投稿保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'nullable|date|after_or_equal:now',
        ]);

        $validated['body'] = $validated['content'];
        unset($validated['content']);

        if (!empty($validated['published_at'])) {
            $validated['published_at'] = \Carbon\Carbon::parse($validated['published_at']);
        }

        auth()->user()->posts()->create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully');
    }

    // 投稿編集画面
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // 投稿更新
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $post->update($validated);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    // 投稿削除
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }

    // コメント保存
    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment added successfully');
    }

    // コメント編集画面
    public function editComment(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    // コメント更新
    public function updateComment(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return redirect()->route('posts.show', $comment->post_id)
            ->with('success', 'コメントを更新しました');
    }

    // コメント削除
    public function destroyComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully');
    }
}