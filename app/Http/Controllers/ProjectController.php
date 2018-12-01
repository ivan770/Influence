<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function CreateNewProject(Request $request)
    {
        $request->validate([
            "name" => "required|max:255"
        ]);

        $user = User::find(Auth::id());

        $new = Project::firstOrCreate(
            ['name' => $request->input("name")], ['api' => str_random(30), 'admin' => Auth::id(), 'invite' => str_random(32)]
        );

        if ($new->wasRecentlyCreated) {
            $user->project()->syncWithoutDetaching([$new['id']]);
            return redirect()->route('home');
        } else {
            abort(404);
        }
    }

    public function JoinProject(Request $request)
    {
        $request->validate([
            "invite" => "required|max:32"
        ]);

        $user = User::find(Auth::id());

        $find = Project::where('invite', $request->input('invite'))->first();

        if (!empty($find)) {
            $user->project()->syncWithoutDetaching([$find['id']]);
            return redirect()->route('home');
        } else {
            abort(404);
        }
    }

    public static function GetProjectList()
    {
        $user = User::find(Auth::id());
        return $user->project()->orderBy("name")->simplePaginate(15);
    }
}