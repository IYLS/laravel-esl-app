<?php

namespace App\Http\Controllers;

use App\Models\MeetCharacterExcercise;
use Illuminate\Http\Request;

class MeetCharacterExcerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('excercises.meet_characters.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
