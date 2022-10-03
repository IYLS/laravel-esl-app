<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Alternative;

class QuestionController extends Controller
{
    public function __construct(){
        $this->middleware('teacher');
    }
    
    public function store(Request $request, $exercise_id, $section_id, $exercise_type_id)
    {
        $exercise_type = ExerciseType::find($exercise_type_id);

        $question = new Question;

        $question->audio_name = $this->getAudioFrom($request);
        $question->image_name = $this->getImageFrom($request);

        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->exercise_id = $exercise_id;
        
        $question->save();

        if($exercise_type->underscore_name == "multiple_choice") 
        {
            $this->handleMultipleChoice($question, $request);
        }
        else if($exercise_type->underscore_name == "form")
        {
            $this->handleForm($question, $request);
        }
        else
        {
            $question->correct_answer = $request->correct_alt;
            $question->save();
        }

        return redirect()->route('exercises.show', [$exercise_id]);
    }

    public function destroy($exercise_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('exercises.show', $question->exercise_id);
    }

    private function getAudioFrom(Request $request)
    {
        if($request->hasFile('audio')) 
        {
            $audio_file_name = $request->file('audio')->getClientOriginalName();
            $audio_file_path = $request->file('audio')->storeAs('public/files', $audio_file_name);
            
            return $audio_file_name;
        } else {
            return null;
        }
    }

    private function getImageFrom(Request $request)
    {
        if($request->hasFile('image')) 
        {
            $image_file_name = $request->file('image')->getClientOriginalName();
            $image_file_path = $request->file('image')->storeAs('public/files', $image_file_name);

            return $image_file_name;
        } else {
            return null;
        }
    }

    private function handleMultipleChoice($question, $request) 
    {
        if(isset($request->alternatives))
        {
            $alternatives = str_replace(array("\r", "\n"), '', $request->alternatives);
            $alts = explode(";", $alternatives);

            foreach($alts as $a)
            {
                $alt = new Alternative;

                $alt->title = trim($a);
                $alt->question_id = $question->id;

                if(strtolower(trim($a)) == strtolower(trim($request->correct_alt)))
                {
                    $alt->correct_alt = true;
                    $question->correct_answer = $a;
                    $question->save();
                }

                $alt->save();
            }
        }
        elseif(isset($request->answer))
        {
            $question->correct_answer = $request->answer;
            $question->save();
        }
    }

    private function handleForm($question, $request)
    {
        foreach($request->alternatives as $alt)
        {
            $alternative = new Alternative;

            $alternative->title = trim($alt);
            $alternative->question_id = $question->id;

            $alternative->correct_alt = false;

            $alternative->save();

        }
    }
}
