<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Excercise;
use App\Models\Feedback;
use App\Models\FeedbackType;

class FeedbackController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $excercise_id)
    {
        $feedback = new Feedback;
        $feedback->message = $request->message;
        $feedback->audio_name = $request->audio;
        $feedback->feedback_type_id = $request->feedback_type_id;
        $feedback->excercise_id = $excercise_id;
        $feedback->question_id = $request->question_id;

        $feedback->save();

        redirect()->route('excercise.show', $excercise_id);
    }

    public function show($id)
    {
        
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
