<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="text-center">
    <style>
        html,
        body {
        height: 100%;
        }

        body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        }

        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        }
        .form-signin .checkbox {
        font-weight: 400;
        }
        .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
        }
        .form-signin .form-control:focus {
        z-index: 2;
        }
        .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        }
    </style>
    <form class="form-signin" action="{{ route('login') }}" method="POST">
      @csrf
      <h1 class="h3 mb-3 font-weight-normal">Influence ID</h1>
      <label for="email" class="sr-only">Email address</label>
      <input type="email" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" required>
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <button class="btn btn-sm btn-secondary btn-block" onclick="document.getElementById('reset').submit()">Reset password</button>
    </form>
    <form action="/password/reset" method="GET" id="reset" style="display: none"></form>
  </body>
</html>