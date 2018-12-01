<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProjectController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = \App\Http\Controllers\ProjectController::GetProjectList();
        return view('home', ['projects' => $projects]);
    }
}
