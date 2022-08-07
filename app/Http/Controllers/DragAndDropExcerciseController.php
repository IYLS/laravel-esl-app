<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DragAndDropExcercise;
use App\Models\DragAndDropQuestion;
use App\Models\Section;

class DragAndDropExcerciseController extends Controller
{
    public function index()
    {
        //
    }

    public function create($unit_id, $section_id, $excercise_id)
    {
        $questions = DragAndDropQuestion::all();
        $excercise = DragAndDropExcercise::where('id', $excercise_id)->get()->first();

        return view('excercises.drag_and_drop.create', compact(['unit_id', 'section_id', 'questions', 'excercise']));
    }

    public function store(Request $request, $unit_id, $section_name)
    {
        $section = Section::where('name', $section_name)->where('unit_id', $unit_id)->get()->first();

        $new_excercise = new DragAndDropExcercise;
        $new_excercise->title = $request->title;
        $new_excercise->description = $request->description;
        $new_excercise->section_id = $section->id;
        $new_excercise->type = 'drag_and_drop';
        $new_excercise->save();

        $excercise_id = $new_excercise->id;

        return redirect()->route('excercises.drag_and_drop.create', [$unit_id, $section_id, $excercise_id]);
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

    public function destroy($unit_id, $section_id, $excercise_id)
    {
        $excercise = DragAndDropExcercise::find($excercise_id);
        $excercise->delete();

        return redirect()->route('excercises.index', [$unit_id]);
    }
}
