<?php

namespace App\Http\Controllers;
use App\Models\DragAndDropExcercise;
use App\Models\DragAndDropQuestion;

use Illuminate\Http\Request;

class DragAndDropQuestionController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $unit_id, $section_id, $excercise_id)
    {
        $new_question = new DragAndDropQuestion;
        $new_question->word = $request->word;
        $new_question->definition = $request->definition;
        $new_question->excercise_id = $excercise_id;
        $new_question->save();

        return redirect()->route('excercises.drag_and_drop.create', [$unit_id, $section_id, $excercise_id]);
    }

    public function show($id)
    {
        return route('excercises.drag_and_drop.create', [$unit_id, $excercise->section_id, $excercise_id]);    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($unit_id, $excercise_id, $question_id)
    {
        $question = DragAndDropQuestion::find($question_id);
        $question->delete();

        return redirect()->route('excercises.drag_and_drop.show', [$unit_id, $excercise_id]);
    }
}
