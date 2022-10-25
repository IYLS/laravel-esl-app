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
        $exercise = Exercise::find($exercise_id);
        $exercise_type = ExerciseType::find($exercise_type_id);

        $question = new Question;
        
        try {
            $question->audio_name = $this->getAudioFrom($request);
            $question->image_name = $this->getImageFrom($request);
        } catch(Exception $e) {
            return redirect()->route('exercises.show', [$exercise_id])->with('error', 'Image or Audio files are not valid or corrupted.');
        }

        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->exercise_id = $exercise_id;

        if($request->has('personal_response') and $request->personal_response != null) $question->personal_response = true;
        
        $question->save();

        if($exercise_type->underscore_name == "multiple_choice") 
        {
            $this->handleMultipleChoice($question, $request);
        }
        else if($exercise_type->underscore_name == "form")
        {
            $this->handleForm($question, $request);
        }
        else if($exercise_type->underscore_name == "open_ended" && $exercise->subtype == "991")
        {
            $this->handleOpenEndedTable($question, $request);
        }
        else
        {
            $question->correct_answer = $request->correct_answer;
            $question->save();
        }

        return redirect()->route('exercises.show', [$exercise_id]);
    }

    public function update(Request $request, $question_id)
    {
        $question = Question::find($question_id);
        $exercise = Exercise::find($question->exercise_id);
        $exercise_type = $exercise->exerciseType;

        if($this->getAudioFrom($request) != null) {
            $question->audio_name = $this->getAudioFrom($request);
        }

        if($this->getImageFrom($request) != null) {
            $question->image_name = $this->getImageFrom($request);
        }
        
        if($request->has('statement') and $request->statement != '' and $request->statement != null and $request->statement != $question->statement) {
            $question->statement = $request->statement;
        }
        
        if($request->has('answer') and $request->answer != '' and $request->answer != null and $request->answer != $question->answer) {
            $question->answer = $request->answer;
        }

        $existing_alts_array = array();
        foreach($question->alternatives as $e_a) {
            array_push($existing_alts_array, $e_a->title);
        }
        $existing_alts_string = implode(';', $existing_alts_array);

        if($request->has('alternatives') and $request->alternatives != null and $request->alternatives != '' and $existing_alts_string != $request->alternatives and $exercise_type->underscore_name == "multiple_choice")
        {
            Alternative::where('question_id', $question->id)->delete();
            $alternatives = str_replace(array("\r", "\n", '\''), '', $request->alternatives);
            $alts = explode(";", $alternatives);

            foreach($alts as $a)
            {
                $alt = new Alternative;
                $alt->title = trim($a);
                $alt->question_id = $question->id;
                if(strtolower(trim($a)) == strtolower(trim($request->correct_answer))) $alt->correct_alt = true;
                $alt->save();
            }

            $question->correct_answer = $request->correct_answer;
            $question->save();
        }
        else if($request->has('alternatives') and $request->alternatives != null and $request->alternatives != '' and $existing_alts_string != $request->alternatives and $exercise_type->underscore_name == "form")
        {
            Alternative::where('question_id', $question->id)->delete();

            foreach($request->alternatives as $alt)
            {
                $alternative = new Alternative;
                $alternative->title = trim($alt);
                $alternative->question_id = $question->id;
                $alternative->correct_alt = false;
                $alternative->save();
            }

            $question->correct_answer = $request->title;
        }
        else if($request->has('boxes_number') and $request->boxes_number != '' and $request->boxes_number != null and $exercise_type->underscore_name == "open_ended" && $exercise->subtype == "991")
        {
            $question->image_name = $request->boxes_number;
        }
        else if($request->has('title') and $request->title != '' and $request->title != null and $exercise_type->underscore_name == "open_ended" && $exercise->subtype == "991") {
            $question->correct_answer = $request->title;
        }
        else 
        {
            $question->correct_answer = $request->correct_answer;
        }

        if ($request->has('exclusive_responses') and $request->exclusive_responses != null)
        {
            if ($request->exclusive_responses == "true") $question->exclusive_responses = true;
            if ($request->exclusive_responses != "true") $question->exclusive_responses = false;
        }

        if($request->has('personal_response') and $request->personal_response != null) $question->personal_response = true;

        if ($question->isDirty()) {
            $question->save();
            return redirect()->route('exercises.show', $question->exercise_id)->with('success', 'Question updated successfully');
        }
        
        return redirect()->route('exercises.show', $question->exercise_id)->with('success', 'No changes made');
    }

    public function destroy($exercise_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('exercises.show', $question->exercise_id);
    }

    private function getAudioFrom(Request $request)
    {
        if($request->hasFile('audio') and $request->file('audio')->isValid()) 
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
        if($request->hasFile('image') and $request->file('image')->isValid()) 
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
            $question->correct_answer = $request->correct_answer;
            $question->save();

            $alternatives = str_replace(array("\r", "\n", '\''), '', $request->alternatives);
            $alts = explode(";", $alternatives);

            foreach($alts as $a)
            {
                $alt = new Alternative;

                $alt->title = trim($a);
                $alt->question_id = $question->id;

                if(strtolower(trim($a)) == strtolower(trim($request->correct_answer)))
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

            $question->correct_answer = $request->title;
            $question->save();
        }
    }

    private function handleOpenEndedTable($question, $request)
    {
        $question->correct_answer = $request->title;
        $question->image_name = $request->boxes_number;
        $question->save();
    }
}
