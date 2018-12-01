<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Task;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CreateNewTask(Request $request){
        $request->validate([
            "name" => "required|max:255",
            "description" => "required|max:5000",
            "project_id" => "required|numeric",
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Task::create([
                'name' => $request->input("name"),
                'description' => $request->input("description"),
                'user_id' => Auth::id()
            ]);
            $project = Project::findOrFail($request->input("project_id"));

            $project->tasks()->save($new);
        }

        return back();
    }

    public function ChangeTaskStatus(Request $request){
        $request->validate([
            "task_id" => "required|numeric",
            "status" => "required|in:0,1,2",
            "project_id" => "required|numeric",
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Task::where(['id' => $request->input('task_id'), 'project_id' => $request->input('project_id')])
                    ->update(['status' => $request->input('status')]);
            return back();
        } else {
            abort(404);
        }
    }

    public function DeleteTask(Request $request){
        $request->validate([
            "task_id" => "required|numeric",
            "project_id" => "required|numeric"
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Task::where(['id' => $request->input('task_id'), 'project_id' => $request->input('project_id'), 'user_id' => Auth::id()])
                    ->delete();
            return back();
        } else {
            abort(404);
        }
    }

    public function index($id){
        $exists = DB::table('project_user')
                    ->where(['project_id' => $id, 'user_id' => Auth::id()])
                    ->count() > 0;
        if(!empty($exists)){
            $project = Project::findOrFail($id);
            $tasks = Task::where(['project_id' => $id])->with("user")->orderByDesc("created_at")->simplePaginate(15);
            return view('tasks', ['tasks' => $tasks, 'project_id' => $id]);
        } else {
            abort(404);
        }
    }
}