<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Atte</title>
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  @yield('css')
</head>

<body>

<div class="wrapper">
  <header class="header">
    <div class="header__container">
      <h1 class="header__heading">
        <a class="header__logo" href="{{ route('toppage') }}">Atte</a>
      </h1>
      <nav class="header__nav">
        <ul class="header-nav">
          @if (Auth::check())
            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('mypage') }}">マイページ</a></li>
            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('posts.index') }}">ブログ一覧</a></li>
            <li class="header-nav__item">
              <form action="/logout" method="post" style="display:inline;">
                @csrf
                <button type="submit" class="header-nav__button">ログアウト</button>
              </form>
            </li>
          @else
            <li class="header-nav__item"><a class="header-nav__link" href="/login">ログイン</a></li>
          @endif
        </ul>
      </nav>
    </div>
  </header>

  <main>
  <div class="content">
    @yield('content')
  </div>
  </main>

  <footer class="footer">
          <div class="footer__text">Atte,inc.</div>
  </footer>
</div>

</body>


</html>