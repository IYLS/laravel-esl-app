<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Feedback;
use App\Models\FeedbackType;

class FeedbackController extends Controller
{
    public function create(Request $request, $exercise_id)
    {   
        $feedback_type = FeedbackType::find($request->type);
        $exercise = Exercise::find($exercise_id);

        return view('feedback.create', compact('feedback_type', 'exercise'));
    }

    public function store(Request $request, $exercise_id, $feedback_type_id)
    {
        $feedback_type = FeedbackType::find($feedback_type_id);
        $text_based = $feedback_type->text_based;
        $level = $feedback_type->level;

        switch ($level)
        {
            case 'exercise':
                if($text_based)
                {
                    foreach($request->messages as $question_id=>$message)
                    {
                        $feedback = new Feedback;
                        $feedback->message = $message["message"];
                        $feedback->feedback_type_id = $feedback_type_id;
                        $feedback->exercise_id = $exercise_id;
                        $feedback->question_id = $question_id;
                        $feedback->save();
                    }
                } else {
                    foreach($request->audios as $question_id=>$audio)
                    {
                        $audio_file_name = $audio["audio"]->getClientOriginalName();
                        $audio["audio"]->storeAs('public/files', $audio_file_name);
        
                        $feedback = new Feedback;
                        $feedback->audio_name = $audio_file_name;
                        $feedback->feedback_type_id = $feedback_type_id;
                        $feedback->exercise_id = $exercise_id;
                        $feedback->question_id = $question_id;
                        $feedback->save();
                    }
                }
                break;
            case 'question':
                if($text_based)
                {
                    foreach($request->messages as $question_id=>$message)
                    {
                        $feedback = new Feedback;
                        $feedback->message = $message["message"];
                        $feedback->feedback_type_id = $feedback_type_id;
                        $feedback->question_id = $question_id;
                        $feedback->save();
                    }
                } else {
                    foreach($request->audios as $question_id=>$audio)
                    {
                        $audio_file_name = $audio["audio"]->getClientOriginalName();
                        $audio["audio"]->storeAs('public/files', $audio_file_name);
        
                        $feedback = new Feedback;
                        $feedback->audio_name = $audio_file_name;
                        $feedback->feedback_type_id = $feedback_type_id;
                        $feedback->question_id = $question_id;
                        $feedback->save();
                    }
                }

                $feedback = new Feedback;
                $feedback->feedback_type_id = $feedback_type_id;
                $feedback->exercise_id = $exercise_id;
                $feedback->save();                

                break;
        }

        return redirect()->route('exercises.show', $exercise_id);
    }

    public function destroy($id)
    {
        Feedback::find($id)->delete();
        return redirect()->back();
    }
}
