<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
 
        // Logging para comparar contraseñas
        $user = User::where('email', $credentials['email'])
            ->where('role', $credentials['role'])
            ->first();
        
        if ($user) {
            $passwordEntered = $credentials['password'];
            $passwordStored = $user->password;
            $passwordMatch = Hash::check($passwordEntered, $passwordStored);
            
            Log::info('Login attempt - Password comparison', [
                'email' => $credentials['email'],
                'role' => $credentials['role'],
                'password_entered_length' => strlen($passwordEntered),
                'password_stored_hash' => substr($passwordStored, 0, 20) . '...', // Solo primeros 20 caracteres del hash
                'password_match' => $passwordMatch,
                'user_id' => $user->id,
                'user_exists' => true
            ]);
        } else {
            Log::warning('Login attempt - User not found', [
                'email' => $credentials['email'],
                'role' => $credentials['role'],
                'user_exists' => false
            ]);
        }
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == "student") {
                return redirect()->route('student.welcome');
            }

            return redirect()->route('auth.index')->with('success', 'You logged in successfully!');
        }
 
        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
