<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class MiscController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function LogoutOther(Request $request)
    {
        $request->validate([
            "password" => "required"
        ]);

        if (Hash::check($request->input("password"), User::findOrFail(Auth::id())->getAuthPassword())) {
            Auth::logoutOtherDevices($request->input("password"));
            $request->session()->flash('status', 'Logged out successfully!');
        } else {
            $request->session()->flash('status', 'Incorrect password!');
        }

        return redirect()->route('home');
    }
}
