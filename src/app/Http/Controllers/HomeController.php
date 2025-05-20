<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index()
   {
      if (auth()->check()) {
         // ログイン済みならマイページへリダイレクト
         return redirect()->route('mypage');
      }
      // 未ログイン時は通常のトップページビュー
      return view('toppage');
   }

   public function toppage()
   {
      return view('toppage');
   }

   public function mypage()
   {
      return view('mypage');
   }
}
