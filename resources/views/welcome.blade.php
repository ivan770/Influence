<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/svg/favicon.ico">

    <title>Influence</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cover.css') }}" rel="stylesheet">
    <script src="{{ asset('js/twreplace.min.js') }}"></script>
  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

      <header class="masthead mb-auto">
        <div class="inner">
        <h3 class="masthead-brand">Influence</h3>
          <nav class="nav nav-masthead justify-content-center">
          @auth
            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
          @else
            <a class="nav-link" href="{{ route('login') }}">Login</a>
            <a class="nav-link" href="{{ route('register') }}">Register</a>
          @endauth
          </nav>
        </div>
      </header>

      <main role="main" class="inner cover">
        <h1 class="cover-heading">A perfect place for your <span data-twreplace-charspeed="75" data-twreplace-wordspeed="3000" data-twreplace='["project", "plan", "idea", "activities"]'>team</span>.</h1>
        <p class="lead">Influence helps your team manage projects, with tools to control <b>tasks</b>, <b>issues</b> and <b>releases</b>.</p>
        <p class="lead">
        @auth
          <a href="{{ route('home') }}" class="btn btn-lg btn-secondary"><img src="{{ asset('svg/logo.svg') }}" width="30" height="48" alt=""></a>
        @else
          <a href="{{ route('register') }}" class="btn btn-lg btn-secondary">Start now</a>
        @endauth
        </p>
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Influence (c) ivan770, 2018.</p>
        </div>
      </footer>
    </div>
  </body>
</html>
