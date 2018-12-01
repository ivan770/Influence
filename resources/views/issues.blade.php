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
                <a class="nav-link active" href="{{ route('issues', ['id' => $project_id]) }}">
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
            <h1 class="h2">Issues</h1>
          </div>
          <div class="card">
                <div class="card-header">Issues</div>
                <div class="card-body">
                    <form action="{{ route('new_issue') }}" method="POST">
                        @csrf
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" id="name" name="name" placeholder="Name" class="form-control" required>
                        <br />
                        <input type="text" id="description" name="description" placeholder="Description" class="form-control" required>
                        <br />
                        <div class="custom-control custom-radio">
                          <input type="radio" id="level_0" name="level" class="custom-control-input" value="0" checked>
                          <label class="custom-control-label" for="level_0">Low severity</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="level_1" name="level" class="custom-control-input" value="1">
                          <label class="custom-control-label" for="level_1">Medium severity</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="level_2" name="level" class="custom-control-input" value="2">
                          <label class="custom-control-label" for="level_2">High severity</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="level_3" name="level" class="custom-control-input" value="3">
                          <label class="custom-control-label" for="level_3">Critical severity</label>
                        </div>
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                        <br />
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                    </form>
                </div>
          </div>
          <br />
          <div class="list-group">
            @foreach($issues as $issue)
                <a class="list-group-item list-group-item-action flex-column align-items-start @if($issue->status == '0') active text-white @endif">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $issue->name }}</h5>
                    <small>{{ $issue->created_at }}</small>
                    </div>
                    <p class="mb-1">{{ $issue->description }}</p>
                    <small>Severity: @if($issue->level=='0') Low @elseif($issue->level=='1') Medium @elseif($issue->level=='2') High @else Critical @endif | @if($issue->user->id=='0') API @else {{ $issue->user->name }} @endif</small>
                    <br />
                    @if($issue->status == '0')
                    <button class="btn btn-success" onclick="document.getElementById('close{{ $issue->id }}').submit()">Close issue</button>
                    @endif
                    <button class="btn btn-light" title="@if($issue->user->id=='0') This issue was created using API, so anyone can delete it @else Only issue creator can delete it @endif" onclick="document.getElementById('delete{{ $issue->id }}').submit()">Delete</button>
                    <form id="close{{ $issue->id }}" action="{{ route('close_issue') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                        <input type="hidden" name="status" value="2">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                    <form id="delete{{ $issue->id }}" action="{{ route('delete_issue') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="issue_id" value="{{ $issue->id }}">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                </a>
            @endforeach
            </div>
            {{ $issues->links() }}
            <br />
        </main>
      </div>
    </div>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
      feather.replace()
    </script>
@endsection