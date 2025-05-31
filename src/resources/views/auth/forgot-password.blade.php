@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="reset.css">
@endsection

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" required autofocus placeholder="メールアドレス">
    <button type="submit">パスワードリセットリンクを送信</button>
</form>
@endsection('content')
