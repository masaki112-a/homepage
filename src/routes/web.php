<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Mypage\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\UserController;

// トップページとホーム（全員OK）
Route::get('/home', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'toppage'])->name('toppage');

// --- 管理者専用ルート（auth, role:adminのみ。2FA不要） ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // ダッシュボード例
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // ユーザー管理
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // 投稿管理（admin用）
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// --- 一般ユーザー用ルート（auth, 2fa.verified） ---
Route::middleware(['auth'])->group(function () {
    // 投稿一覧・コメント
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts/{post}/tag', [PostTagController::class, 'toggle'])->name('posts.tag.toggle');
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('comments.store');
    Route::delete('/comments/{comment}', [PostController::class, 'destroyComment'])
        ->middleware('can:delete,comment')
        ->name('comments.destroy');
    // コメント編集・更新
    Route::get('/comments/{comment}/edit', [PostController::class, 'editComment'])
        ->middleware('can:update,comment')
        ->name('comments.edit');
    Route::put('/comments/{comment}', [PostController::class, 'updateComment'])
        ->middleware('can:update,comment')
        ->name('comments.update');
    // 投稿詳細
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show'); 

    // マイページ
    Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/mypage/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/mypage', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/mypage/comments', [ProfileController::class, 'comments'])->name('profile.comments');
    Route::get('/mypage/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/mypage/watch-later', [ProfileController::class, 'watchLater'])->name('profile.watch_later');

    // スケジュール
    Route::get('/schedule', [ScheduleController::class, 'show'])->name('schedule.show');
    Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/events/{event}', [ScheduleController::class, 'detail'])->name('schedule.detail');
    Route::get('/schedule/events/{event}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/events/{event}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/events/{event}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

    // パスワード
    Route::get('/reset-password', [PasswordController::class, 'showChangeForm'])->name('password.reset.form');
    Route::put('/reset-password', [PasswordController::class, 'update'])->name('user-password.update');
});