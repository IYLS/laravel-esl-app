<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DragAndDropExcercise;
use App\Models\DragAndDropQuestion;

class DragAndDropExcerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section, $excercise_id)
    {
        $questions = DragAndDropQuestion::all();
        $excercise = DragAndDropExcercise::where('id', $excercise_id)->get()->first();

        return view('excercises.drag_and_drop.create', compact(['unit_id', 'section', 'questions', 'excercise']));
    }

    public function store(Request $request, $unit_id, $section)
    {
        $new_excercise = new DragAndDropExcercise;
        $new_excercise->title = $request->title;
        $new_excercise->description = $request->description;
        $new_excercise->section = $section;
        $new_excercise->type = 'drag_and_drop';
        $new_excercise->unit_id = $unit_id;
        $new_excercise->save();

        $excercise_id = $new_excercise->id;

        return redirect()->route('excercises.drag_and_drop.create', [$unit_id, $section, $excercise_id]);
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
