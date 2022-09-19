<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Feedback;
use App\Models\FeedbackType;

class FeedbackController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request, $exercise_id)
    {   
        $feedback_type = FeedbackType::find($request->type);

        return view('feedback.create', compact('feedback_type', 'exercise_id'));
    }

    public function store(Request $request, $exercise_id)
    {
        $feedback = new Feedback;
        $feedback->message = $request->message;
        $feedback->audio_name = $request->audio;
        $feedback->feedback_type_id = $request->feedback_type_id;
        $feedback->exercise_id = $exercise_id;
        $feedback->question_id = $request->question_id;

        $feedback->save();

        return redirect()->route('feedback.create', $feedback_id);
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
