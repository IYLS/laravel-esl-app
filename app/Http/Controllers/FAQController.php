<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FAQController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function student()
    {
        // Verificar que el usuario sea estudiante
        if (Auth::user()->role != 'student') {
            return redirect()->route('auth.index');
        }

        return view('faq.student');
    }

    public function teacher()
    {
        // Verificar que el usuario sea profesor
        if (Auth::user()->role != 'teacher') {
            return redirect()->route('auth.index');
        }

        return view('faq.teacher');
    }
}
