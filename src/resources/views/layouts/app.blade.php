<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
  @vite(['resources/js/app.js']) <!-- モーダルJSも読み込む -->
</head>

<body>
  <header class="header">
    <div class="header__container">
      <h1 class="header__heading">
        <a class="header__logo" href="{{ route('toppage') }}">Atte</a>
      </h1>
      <nav class="header__nav">
        <ul class="header-nav">
          @if (Auth::check())
            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('posts.index') }}">ブログ一覧</a></li>
            <li class="header-nav__item"><a class="header-nav__link" href="{{ route('schedule.show') }}">スケジュール</a></li>
          @else
            <li class="header-nav__item"><a class="header-nav__link" href="/login">ログイン</a></li>
          @endif
        </ul>
      </nav>
      @if (Auth::check())
        <!-- モーダルトリガーボタン 最右端 -->
        <button id="modalTrigger" class="header__menu-trigger">機能</button>
      @endif
    </div>
  </header>

  <!-- モーダル本体 -->
  @if (Auth::check())
    <div id="modalOverlay" class="modal-overlay">
      <div class="modal-window" tabindex="-1" aria-modal="true" role="dialog">
        <button class="modal-close" id="modalClose" aria-label="閉じる">&times;</button>
        <ul class="modal-list">
          <li><a href="{{ route('profile.show') }}">マイページ</a></li>
          @if (Auth::user()->role === 'admin')
            <li><a href="{{ route('admin.users.index') }}">ユーザー管理</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit" style="background: none; border: none; color: #007bff; cursor: pointer;">ログアウト</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  @endif

  <main>
    <div class="content">
      @yield('content')
    </div>
  </main>

  <footer class="footer">
    <div class="footer__text">&copy; {{ date('Y') }} Atte,inc.</div>
  </footer>
</body>
</html>