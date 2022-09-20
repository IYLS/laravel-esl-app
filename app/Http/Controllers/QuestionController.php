<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Alternative;

class QuestionController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $exercise_id, $section_id, $exercise_type_id)
    {
        $excercise_type = ExerciseType::find($exercise_type_id);

        $question = new Question;

        if($request->hasFile('audio')) 
        {
            $audio_file_name = $request->file('audio')->getClientOriginalName();
            $audio_file_path = $request->file('audio')->storeAs('public/files', $audio_file_name);

            $question->audio_name = $audio_file_name;
        }

        if($request->hasFile('image')) 
        {
            $image_file_name = $request->file('image')->getClientOriginalName();
            $image_file_path = $request->file('image')->storeAs('public/files', $image_file_name);

            $question->image_name = $image_file_name;
        }

        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->exercise_id = $exercise_id;
        
        $question->save();

        if($excercise_type->underscore_name == "multiple_choice") 
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
                        dd($a);

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
        else 
        {
            $question->correct_answer = $request->correct_alt;
            $question->save();
        }


        return redirect()->route('exercises.show', [$exercise_id]);
    }

    public function show(Question $question)
    {
        //
    }

    public function edit(Question $question)
    {
        //
    }

    public function update(Request $request, Question $question)
    {
        //
    }

    public function destroy($exercise_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('exercises.show', $question->exercise_id);
    }
}
