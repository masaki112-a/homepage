@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
<link rel="stylesheet" href="reset.css">
@endsection

@section('content')
<div class="login-form">
  <h2 class="login-form__heading-content__heading">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form__form" action="/login" method="post">
            @csrf
            <div class="login-form__group">
                <input class="login-form__input" type="email" name="email" id="email" placeholder="メールアドレス">
                <p class="register-form__error-message">
                @error('email')
                {{ $message }}
                @enderror
                </p>
            </div>
            <div class="login-form__group">
                <input class="login-form__input" type="password" name="password" id="password" placeholder="パスワード">
                <p>
                @error('password')
                {{ $message }}
                @enderror
                </p>
            </div>
            <div class="login-form__submit">
                <input class="login-form__btn-btn" type="submit" value="ログイン">
            </div>
            
        </form>

    </div>
        <div class="login-form_register">
            <div>アカウントをお持ちでない方はこちらから</div>
            <a class="login-form_register_link" href="/register">会員登録</a>
        </div>
        <div class="login-form_register">
            <a class="login-form_register_link" href="/forgot-password">パスワードを忘れてしまったら</a>
        </div>
</div>
@endsection


