<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Project;
use App\Release;
use App\Issue;
use Validator;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    public function CreateNewReleaseAPI(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required|max:255",
            "description" => "required|max:5000",
            "id" => "required|numeric",
            "url" => "required|url",
            "type" => "required|in:0,1,2",
            "api" => "required|max:30"
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => 0]);
        }

        $correct = Project::where(['id' => $request->input("id"), 'api' => $request->input("api")])->first();

        if(!empty($correct)){
            $new = Release::create([
                'name' => $request->input("name"),
                'description' => $request->input("description"),
                'type' => $request->input("type"),
                'user_id' => 0,
                'url' => $request->input("url")
            ]);
            $project = Project::findOrFail($request->input("id"));
            $project->releases()->save($new);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 1]);
        }
    }

    public function CreateNewIssueAPI(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required|max:255",
            "description" => "required|max:5000",
            "id" => "required|numeric",
            "level" => "required|in:0,1,2,3",
            "api" => "required|max:30"
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => 0]);
        }

        $correct = Project::where(['id' => $request->input("id"), 'api' => $request->input("api")])->first();

        if(!empty($correct)){
            $new = Issue::create([
                'name' => $request->input("name"),
                'description' => $request->input("description"),
                'level' => $request->input("level"),
                'user_id' => 0,
                'status' => 0
            ]);
            $project = Project::findOrFail($request->input("id"));
            $project->issues()->save($new);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 1]);
        }
    }
}