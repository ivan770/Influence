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
                <a class="nav-link active" href="{{ route('releases', ['id' => $project_id]) }}">
                  <span data-feather="box"></span>
                  Releases
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('messages', ['id' => $project_id]) }}">
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
            <h1 class="h2">Releases</h1>
          </div>
          <div class="card">
                <div class="card-header">Releases</div>
                <div class="card-body">
                    <form action="{{ route('new_release') }}" method="POST">
                        @csrf
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" id="name" name="name" placeholder="Name" class="form-control" required>
                        <br />
                        <input type="text" id="description" name="description" placeholder="Description" class="form-control" required>
                        <br />
                        <input type="url" id="url" name="url" placeholder="URL" class="form-control" required>
                        <br />
                        <div class="custom-control custom-radio">
                            <input type="radio" id="release_0" name="type" class="custom-control-input" value="0" checked>
                            <label class="custom-control-label" for="release_0">Standard build</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="release_1" name="type" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="release_1">Testing build</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="release_2" name="type" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="release_2">Pre-release</label>
                        </div>
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                        <br />
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                    </form>
                </div>
          </div>
          <br />
          <div class="list-group">
            @foreach($releases as $release)
                <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $release->name }}</h5>
                    <small>{{ $release->created_at }}</small>
                    </div>
                    <p class="mb-1">{{ $release->description }}</p>
                    <small>@if($release->type=='0') Standard build @elseif($release->type=='1') Testing build @else Pre-release @endif | @if($release->user->id=='0') API @else {{ $release->user->name }} @endif</small>
                    <br />
                    <button class="btn btn-success" onclick="document.getElementById('url{{ $release->id }}').submit()">Link</button>
                    <button class="btn btn-danger" title="@if($release->user->id=='0') This release was created using API, so anyone can delete it @else Only release creator can delete it @endif" onclick="document.getElementById('delete{{ $release->id }}').submit()">Delete</button>
                    <form id="url{{ $release->id }}" action="{{ $release->url }}" method="GET" style="display: none;"></form>
                    <form id="delete{{ $release->id }}" action="{{ route('delete_release') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="release_id" value="{{ $release->id }}">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                </a>
            @endforeach
            </div>
            {{ $releases->links() }}
            <br />
        </main>
      </div>
    </div>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
      feather.replace()
    </script>
@endsection