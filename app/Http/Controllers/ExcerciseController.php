<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\models\Excercise;

class ExcerciseController extends Controller
{
    public function index()
    {
        return view('excercises.index');
    }

    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        $excersise = new Excercise;
        $excercise->name = $request->name;
        $excercise->description = $request->description;
        $excercise->type = $request->type;
        $excercise->section = $request->section;
        $excercise->save();

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
