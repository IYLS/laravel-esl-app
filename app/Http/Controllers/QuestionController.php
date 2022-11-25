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

        $last_position = Question::select('position')->where('exercise_id', $exercise->id)->get()->count();
        $question->position = $last_position+1;
        
        try {
            $question->audio_name = $this->getAudioFrom($request);
            $question->image_name = $this->getImageFrom($request);
        } catch(Exception $e) {
            return redirect()->route('exercises.show', [$exercise_id])->with('error', 'Image or Audio files are not valid or corrupted.');
        }

        $question->statement = $request->statement;
        $question->answer = $request->answer;
        $question->exercise_id = $exercise_id;
        $question->heading_title = $request->heading;

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
        $question->heading_title = $request->heading;

        if($this->getAudioFrom($request) != null) $question->audio_name = $this->getAudioFrom($request);
        if($this->getImageFrom($request) != null) $question->image_name = $this->getImageFrom($request);
        
        if($request->has('statement') and $request->statement != '' and $request->statement != $question->statement) $question->statement = $request->statement;
        
        if($exercise_type->underscore_name == "form") {
            if($request->has('answer') and $request->answer != $question->answer) $question->answer = $request->answer;
        } else {
            if($request->has('answer') and $request->answer != '' and $request->answer != $question->answer) $question->answer = $request->answer;
        }

        if($exercise_type->underscore_name == "form")
        {
            Alternative::where('question_id', $question->id)->delete();
            if($request->has('title') and $request->title != null and $request->title != $question->correct_answer) {
                $question->correct_answer = $request->title;
            }
        }

        if($request->has('alternatives') and $exercise_type->underscore_name == "multiple_choice")
        {
            Alternative::where('question_id', $question->id)->delete();
            
            foreach($request->alternatives as $key=>$alt)
            {
                $alternative = new Alternative;
                $alternative->title = $alt;
                $alternative->question_id = $question->id;

                if($request->has('correct_answer') and $key == $request->correct_answer) 
                {   
                    $alternative->correct_alt = true;
                    $question->correct_answer = $alt;
                    $question->save();
                } else {
                    $alternative->correct_alt = false;
                }

                $alternative->save();
            }

        } else if($request->has('alternatives') and $request->alternatives != null and $exercise_type->underscore_name == "form") {
            foreach($request->alternatives as $alt)
            {
                $alternative = new Alternative;
                $alternative->title = trim($alt);
                $alternative->question_id = $question->id;
                $alternative->correct_alt = false;
                $alternative->save();
            }
        } else if($request->has('boxes_number') and $request->boxes_number != '' and $request->boxes_number != null and $exercise_type->underscore_name == "open_ended" && $exercise->subtype == "991") {
            $question->image_name = $request->boxes_number;
            if($request->title != null) $question->correct_answer = $request->title;
        } else if($request->has('title') and $request->title != '' and $request->title != null and $exercise_type->underscore_name == "open_ended" && $exercise->subtype == "991") {
            $question->correct_answer = $request->title;
        } else {
            if($exercise_type->underscore_name != "form") $question->correct_answer = $request->correct_answer;
        }

        if ($request->has('exclusive_responses') and $request->exclusive_responses != null) {
            if ($request->exclusive_responses == "true") $question->exclusive_responses = true;
            if ($request->exclusive_responses != "true") $question->exclusive_responses = false;
        }

        if($request->has('personal_response') and $request->personal_response != null) $question->personal_response = true;

        if ($question->isDirty()) {
            $question->save();
            return redirect()->route('exercises.show', $question->exercise_id)->with('success', 'Question updated successfully');
        }
            
        return redirect()->route('exercises.show', $question->exercise_id)->with('success', 'Done!');
    }

    public function destroy($exercise_id, $question_id)
    {
        $question = Question::find($question_id);
        $question->delete();

        return redirect()->route('exercises.show', $question->exercise_id);
    }

    public function setPositions(Request $request)
    {
        $exercise_id = 0;
        foreach($request->positions as $id=>$position) {
            $question = Question::find($id);
            $question->position = $position;
            $question->save();

            $exercise_id = $question->exercise->id;
        }

        return redirect()->route('exercises.show', $exercise_id)->with('success', 'Questions positions defined successfully!');
    }


    //  HELPER FUNCTIONS
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
            foreach($request->alternatives as $key=>$alt) {
                $alternative = new Alternative;
                $alternative->title = $alt;
                $alternative->question_id = $question->id;

                if(isset($request->correct_answer) and $key == $request->correct_answer and !$request->has('personal_response')) 
                {
                    $alternative->correct_alt = true;
                    $question->correct_answer = $alt;
                    $question->save();
                } else {
                    $alternative->correct_alt = false;
                }

                $alternative->save();
            }
        } elseif(isset($request->answer)) {
            $question->correct_answer = $request->answer;
            $question->save();
        }
    }

    private function handleForm($question, $request)
    {
        if($request->has('alternatives')) 
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
    }

    private function handleOpenEndedTable($question, $request)
    {
        $question->correct_answer = $request->title;
        $question->image_name = $request->boxes_number;
        $question->save();
    }
}
