@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')
<div class="register-form">
  <h2 class="register-form__heading_content__heading">会員登録</h2>
  <div class="register-form__inner">
    <form class="register-form__form" action="/register" method="post">
      @csrf
        <div class="register-form__group">
            <input class="register-form__input" type="text" name="name" id="name" placeholder="名前">
            <p class="register-form__error-message">
            @error('name')
            {{ $message }}
            @enderror
            </p>
        </div>
        <div class="register-form__group">
            <input class="register-form__input" type="mail" name="email" id="email" placeholder="メールアドレス">
            <p class="register-form__error-message">
            @error('email')
            {{ $message }}
            @enderror
            </p>
        </div>
        <div class="register-form__group">
            <input class="register-form__input" type="password" name="password" id="password" placeholder="パスワード">
            <p class="register-form__error-message">
            @error('password')
            {{ $message }}
            @enderror
            </p>
        </div>
            <div class="register-form__group">
            <input class="register-form__input" type="password" name="password_confirmation" placeholder="確認用パスワード">
            <p class="register-form__error-message">
            @error('password_confirmation')
            {{ $message }}
            @enderror
            </p>
        </div>
        <div class="register-form__submit">
        <input class="register-form__btn-btn" type="submit" value="会員登録">
        </div>
    </form>
  </div>
        <div class="register-form_login">
            <div>アカウントをお持ちでない方はこちらから</div>
            <a class="register-form_login_link" href="/login">ログイン</a>
        </div>
</div>
@endsection('content')
