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
                <a class="nav-link active" href="{{ route('tasks', ['id' => $project_id]) }}">
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
            <h1 class="h2">Tasks</h1>
          </div>
          <div class="card">
                <div class="card-header">Tasks</div>
                <div class="card-body">
                    <form action="{{ route('new_task') }}" method="POST">
                        @csrf
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" id="name" name="name" placeholder="Name" class="form-control" required>
                        <br />
                        <input type="text" id="description" name="description" placeholder="Description" class="form-control" required>
                        <br />
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                    </form>
                </div>
          </div>
          <br />
          <div class="list-group">
            @foreach($tasks as $task)
                <a class="list-group-item list-group-item-action flex-column align-items-start @if($task->status == '0') active text-white @endif">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $task->name }}</h5>
                    <small>{{ $task->created_at }}</small>
                    </div>
                    <p class="mb-1">{{ $task->description }}</p>
                    <small>Status: @if($task->status=='0') New @elseif($task->status=='1') In progress @else Completed @endif | {{ $task->user->name }}</small>
                    <br />
                    <div class="btn-group" role="group">
                      <button class="btn btn-success" onclick="document.getElementById('completed{{ $task->id }}').submit()">Completed</button>
                      <button class="btn btn-secondary" onclick="document.getElementById('progress{{ $task->id }}').submit()">In progress</button>
                      <button class="btn btn-secondary" onclick="document.getElementById('new{{ $task->id }}').submit()">New</button>
                      <button class="btn btn-danger" title="Only task creator can delete it" onclick="document.getElementById('delete{{ $task->id }}').submit()">Delete</button>
                    </div>
                    <form id="completed{{ $task->id }}" action="{{ route('status_task') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="status" value="2">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                    <form id="progress{{ $task->id }}" action="{{ route('status_task') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                    <form id="new{{ $task->id }}" action="{{ route('status_task') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                    <form id="delete{{ $task->id }}" action="{{ route('delete_task') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="project_id" value="{{ $project_id }}">
                    </form>
                </a>
            @endforeach
            </div>
            {{ $tasks->links() }}
            <br />
        </main>
      </div>
    </div>
    <script src="{{ asset('js/feather.min.js') }}"></script>
    <script>
      feather.replace()
    </script>
@endsection