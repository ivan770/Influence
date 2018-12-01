<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Message;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CreateNewMessage(Request $request){
        $request->validate([
            "message" => "required|max:255",
            "project_id" => "required|numeric"
        ]);

        $exists = DB::table('project_user')
                    ->where(['project_id' => $request->input("project_id"), 'user_id' => Auth::id()])
                    ->count() > 0;

        if(!empty($exists)){
            $new = Message::create([
                'message' => $request->input("message"),
                'user_id' => Auth::id()
            ]);
            $project = Project::findOrFail($request->input("project_id"));

            $project->messages()->save($new);
        }

        return back();
    }

    public function index($id){
        $exists = DB::table('project_user')
                    ->where(['project_id' => $id, 'user_id' => Auth::id()])
                    ->count() > 0;
        if(!empty($exists)){
            $project = Project::findOrFail($id);
            $messages = Message::where(['project_id' => $id])->with("user")->orderByDesc("created_at")->simplePaginate(50);
            return view('messages', ['messages' => $messages, 'project_id' => $id]);
        } else {
            abort(404);
        }
    }
}