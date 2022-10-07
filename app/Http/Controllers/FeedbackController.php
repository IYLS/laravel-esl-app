<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Feedback;
use App\Models\FeedbackType;
use App\Models\Question;

class FeedbackController extends Controller
{
    public function __construct(){
        $this->middleware('teacher');
    }
    
    public function create(Request $request, $exercise_id)
    {   
        $feedback_types = FeedbackType::findMany($request->types);
        $exercise = Exercise::find($exercise_id);

        return view('feedback.create', compact('feedback_types', 'exercise'));
    }

    public function store(Request $request, $exercise_id)
    {   
        $exercise = Exercise::find($exercise_id);
        $data = $request->data;

        if(array_key_exists("question", $data))
        {
            foreach($data["question"] as $feedback_type_id=>$question_data)
            {   
                foreach($question_data as $key=>$q) {
                    $question = Question::find($key);
                    
                    foreach($q as $key=>$item)
                    {   
                        switch($key)
                        {
                            case'message':
                                $feedback = new Feedback;
                                $feedback->feedback_type_id = $feedback_type_id;
                                $feedback->message = $item;
                                $feedback->question_id = $question->id;
                                $feedback->exercise_id = $exercise->id;
                                $feedback->save();
                                break;
                            case('audio'):
                                $feedback = new Feedback;
                                $feedback->feedback_type_id = $feedback_type_id;
                                $feedback->audio_name = $item;
                                $feedback->question_id = $question->id;
                                $feedback->exercise_id = $exercise->id;
                                $feedback->save();
                                break;
                            default:
                                $feedback = new Feedback;
                                $feedback->feedback_type_id = $feedback_type_id;
                                $feedback->message = $item["message"];
                                $feedback->question_id = $question->id;
                                $feedback->exercise_id = $exercise->id;        
                                $feedback->save();
                                break;
                        }
                    }
                }
            }
        }

        if(array_key_exists("exercise", $data))
        {
            foreach($data["exercise"] as $feedback_type_id=>$exercise_data)
            {
                foreach($exercise_data as $key=>$e)
                {
                    if($key == 'message')
                    {
                        $feedback = new Feedback;
                        $feedback->feedback_type_id = $feedback_type_id;
                        $feedback->message = $e;
                        $feedback->exercise_id = $exercise->id;        
                        $feedback->save();
                        break;
                    }
                }
            }
        }

        return redirect()->route('exercises.show', $exercise_id)->with("success", "Feedback saved successfully.");
    }

    public function destroy($exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        foreach($exercise->feedbacks as $fb) $fb->delete();

        return redirect()->route('exercises.show', $exercise_id)->with("success", "Feedback settings deleted successfully.");
    }
}