@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="reset.css">
@endsection

@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="email" name="email" required placeholder="メールアドレス" value="{{ old('email', $request->email) }}">
    <input type="password" name="password" required placeholder="新しいパスワード">
    <input type="password" name="password_confirmation" required placeholder="パスワード確認">
    <button type="submit">パスワードをリセット</button>
</form>
@endsection('content')
