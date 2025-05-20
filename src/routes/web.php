<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/home', [HomeController::class, 'index']);
Route::get('/toppage', [HomeController::class, 'toppage'])->name('toppage');
Route::get('/mypage', [HomeController::class, 'mypage'])->name('mypage');

// 認証必須のブログ機能
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)->only(['index', 'store', 'show', 'update']);
});