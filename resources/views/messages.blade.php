@extends('layouts.app')
@section('content')

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                  <span data-feather="home"></span>
                  Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks', ['id' => $project_id]) }}">
                  <span data-feather="list"></span>
                  Tasks
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('issues', ['id' => $project_id]) }}">
                  <span data-feather="alert-circle"></span>
                  Issues
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('releases', ['id' => $project_id]) }}">
                  <span data-feather="box"></span>
                  Releases
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="{{ route('messages', ['id' => $project_id]) }}">
                  <span data-feather="message-square"></span>
                  Chat
                </a>
              </li>
              <li class="nav-item">
                  <div class="dropdown-divider"></div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="modal" href="#logoutModal">
                  <span data-feather="log-out"></span>
                  Logout other devices
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Chat</h1>
          </div>
          <div class="card">
            <div class="card-header">Chat</div>
            <div class="card-body">
                <form action="{{ route('new_message') }}" method="POST">
                    @csrf
                    <label for="message" class="sr-only">Name</label>
                    <input type="text" id="message" name="message" placeholder="Message" class="form-control" required>
                    <input type="hidden" name="project_id" value="{{ $project_id }}">
                    <br />
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Send</button>
                </form>
            </div>
          </div>
          <br />
          <div class="list-group">
            @foreach($messages as $message)
                <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1">{{ $message->user->name }}</p>
                    <small>{{ $message->created_at }}</small>
                    </div>
                    <h5 class="mb-1">{{ $message->message }}</h5>
                </a>
            @endforeach
            </div>
            <br />
            {{ $messages->links() }}
          <br />
        </main>
      </div>
    </div>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
      feather.replace()
    </script>
@endsection