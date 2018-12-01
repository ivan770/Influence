<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Release;
use App\Http\Controllers\Controller;

class ReleaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CreateNewRelease(Request $request){
        $request->validate([
            "name" => "required|max:255",
            "description" => "required|max:5000",
            "project_id" => "required|numeric",
            "url" => "required|url",
            "type" => "required|in:0,1,2"
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Release::create([
                'name' => $request->input("name"),
                'description' => $request->input("description"),
                'type' => $request->input("type"),
                'user_id' => Auth::id(),
                'url' => $request->input("url")
            ]);
            $project = Project::findOrFail($request->input("project_id"));

            $project->releases()->save($new);
        }

        return back();
    }

    public function DeleteRelease(Request $request){
        $request->validate([
            "release_id" => "required|numeric",
            "project_id" => "required|numeric"
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Release::where(['id' => $request->input('release_id'), 'project_id' => $request->input('project_id')])
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
            $releases = Release::where(['project_id' => $id])->with("user")->orderByDesc("created_at")->simplePaginate(15);
            return view('releases', ['releases' => $releases, 'project_id' => $id]);
        } else {
            abort(404);
        }
    }
}