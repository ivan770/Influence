@extends('layouts.app')
@section('content')
    <div class="modal fade" id="joinForm" tabindex="-1" role="dialog" aria-labelledby="joinFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="joinFormLabel">Join project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="join-project-form" action="{{ route('join_project') }}" method="POST">
            <div class="modal-body">
                @csrf
                <input type="text" id="invite" name="invite" placeholder="Invite code" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Join</button>
            </div>
            </form>
        </div>
        </div>
    </div>

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
                <a class="nav-link" data-toggle="modal" href="#joinForm">
                  <span data-feather="link"></span>
                  Join project
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
            <h1 class="h2">Projects</h1>
          </div>
          <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-dark" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('new_project') }}" method="POST">
                        @csrf
                        <label for="name" class="sr-only">Project name</label>
                        <input type="text" id="name" name="name" placeholder="Project name" class="form-control" required>
                        <br />
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                    </form>
                </div>
            </div>
            @foreach($projects as $project)
                <br />
                <div class="card">
                    <div class="card-header">{{ $project->name }}</div>
                    <div class="card-body">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary" onclick="document.getElementById('tasks{{ $project->id }}').submit()">Tasks</button>
                                <button class="btn btn-danger" onclick="document.getElementById('issues{{ $project->id }}').submit()">Issues</button>
                                <button class="btn btn-secondary" onclick="document.getElementById('releases{{ $project->id }}').submit()">Releases</button>
                                <button class="btn btn-info" onclick="document.getElementById('chat{{ $project->id }}').submit()">Chat</button>
                                <form id="tasks{{ $project->id }}" action="{{ route('tasks', ['id' => $project->id]) }}" method="GET" style="display: none;"></form>
                                <form id="issues{{ $project->id }}" action="{{ route('issues', ['id' => $project->id]) }}" method="GET" style="display: none;"></form>
                                <form id="releases{{ $project->id }}" action="{{ route('releases', ['id' => $project->id]) }}" method="GET" style="display: none;"></form>
                                <form id="chat{{ $project->id }}" action="{{ route('messages', ['id' => $project->id]) }}" method="GET" style="display: none;"></form>
                            </div>
                            &nbsp;
                            <div class="btn-group" role="group">
                                <a tabindex="0" class="btn btn-secondary" role="button" data-placement="top" data-toggle="popover" data-trigger="hover click" title="Project ID: {{ $project->id }}" data-content="{{ $project->api }}">API Key</a>
                                <button class="btn btn-secondary" data-clipboard-text="{{ $project->invite }}">Copy invite code</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $projects->links() }}
            <br />
        </main>
      </div>
    </div>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
      feather.replace()
      new ClipboardJS('.btn');
      $(function () {
        $('[data-toggle="popover"]').popover()
      })
    </script>
@endsection