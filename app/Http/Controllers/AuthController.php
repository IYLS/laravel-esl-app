<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function index() {
        if (Auth::user() != null) {
            $user = Auth::user();
            return view('auth.index', compact('user'));
        }

        return redirect()->route('auth.login');
    }

    public function login(Request $request) 
    {
        if (Auth::user() == null) {
            return view('auth.login');
        } else {
            return redirect()->route('auth.index');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == "student") {
                return redirect()->route('student.level_selection');
            }

            return redirect()->route('auth.index')->with('success', 'You logged in successfully!');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
