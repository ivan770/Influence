<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Issue;
use App\Http\Controllers\Controller;

class IssuesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CreateNewIssue(Request $request){
        $request->validate([
            "name" => "required|max:255",
            "description" => "required|max:5000",
            "project_id" => "required|numeric",
            "level" => "required|in:0,1,2,3"
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Issue::create([
                'name' => $request->input("name"),
                'description' => $request->input("description"),
                'level' => $request->input("level"),
                'user_id' => Auth::id(),
                'status' => 0
            ]);
            $project = Project::findOrFail($request->input("project_id"));

            $project->issues()->save($new);
        }

        return back();
    }

    public function CloseIssue(Request $request){
        $request->validate([
            "issue_id" => "required|numeric",
            "project_id" => "required|numeric",
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Issue::where(['id' => $request->input('issue_id'), 'project_id' => $request->input('project_id')])
                    ->update(['status' => 1]);
            return back();
        } else {
            abort(404);
        }
    }

    public function DeleteIssue(Request $request){
        $request->validate([
            "issue_id" => "required|numeric",
            "project_id" => "required|numeric"
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Issue::where(['id' => $request->input('issue_id'), 'project_id' => $request->input('project_id')])
                    ->whereIn('user_id', [Auth::id(), 0])
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
            $issues = Issue::where(['project_id' => $id])->with("user")->orderByDesc("created_at")->simplePaginate(15);
            return view('issues', ['issues' => $issues, 'project_id' => $id]);
        } else {
            abort(404);
        }
    }
}