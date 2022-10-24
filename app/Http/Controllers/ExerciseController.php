<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Section;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\ExerciseType;
use App\Models\Feedback;
use App\Models\FeedbackType;

class ExerciseController extends Controller
{
    public function __construct(){
        $this->middleware('teacher');
    }
    
    public function index($unit_id)
    {   
        $types = ExerciseType::all();
        $unit = Unit::find($unit_id);

        return view('exercises.index', compact('unit', 'types'));
     }

     public function create(Request $request, $unit_id, $exercise_type_id, $section_id)
     {
        $type = ExerciseType::find($exercise_type_id);

        $title = $request->title;
        $description = $request->description;

        return view("exercises.$type->underscore_name.create", compact(['unit_id', 'section_id', 'title', 'description']));
    }

    public function store(Request $request, $unit_id, $type_id, $section_id)
    {
        $exercise = new Exercise;
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->instructions = $request->instructions;
        $exercise->translated_instructions = $request->translated_instructions;
        $exercise->exercise_type_id = $type_id;
        $exercise->section_id = $section_id;
        $exercise->extra_info = $request->extra_info;
        
        $exercise->image_name = $this->getImageFrom($request);
        $exercise->video_name = $this->getVideoFrom($request);

        if(isset($request->subtype)) {
            $exercise->subtype = $request->subtype;
        } else {
            $exercise->subtype = '99';
        }

        $exercise->save();
        
        return redirect()->route('exercises.show', $exercise->id);
    }

    public function show($exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $feedback_types = FeedbackType::all();
        $sections = Section::where('unit_id', $exercise->section->unit->id)->get();
        $type_name = $exercise->exerciseType->underscore_name;

        return view("exercises.$type_name.show", compact('exercise', 'feedback_types', 'sections'));
    }

    public function update(Request $request, $unit_id, $type_id, $exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->instructions = $request->instructions;
        $exercise->translated_instructions = $request->translated_instructions;
        $exercise->section_id = $request->section;
        $exercise->extra_info = $request->extra_info;

        if($this->getVideoFrom($request) == null)
        {
            $exercise->image_name = $exercise->image_name;
        }
        else
        {
            $exercise->image_name = $this->getVideoFrom($request);
        }

        if($this->getImageFrom($request) == null)
        {
            $exercise->image_name = $exercise->image_name;
        }
        else
        {
            $exercise->image_name = $this->getImageFrom($request);
        }

        $exercise->save();

        return redirect()->route('exercises.show', $exercise->id);
    }

    public function destroy($unit_id, $exercise_type_id, $exercise_id)
    {
        $exercise = Exercise::find($exercise_id);
        $exercise->delete();

        return redirect()->route('exercises.index', [$exercise->section->unit_id]);
    }

    public function update_position(Request $request, $unit_id, $exercise_id) 
    {
        $exercise = Exercise::find($exercise_id);
        $section_exercises = Exercise::where('section_id', $exercise->section_id)->get();

        $wanted_position = $request->position;
        $original_position = $exercise->position;

        if($wanted_position == $original_position)
        {
            return redirect()->route('exercises.index', $unit_id)->with('success', 'No changes');

        } else if($wanted_position > $original_position) {
            foreach($section_exercises as $e)
            {
                if($e->position <= $wanted_position and $e->position > $original_position)
                {
                    $e->position -= 1;
                    $e->save();
                }
            }
        } else if($wanted_position < $original_position) {
            foreach($section_exercises as $e)
            {
                if($e->position >= $wanted_position and $e->position < $original_position)
                {
                    $e->position += 1;
                    $e->save();
                }
            }
        }

        $exercise->position = $wanted_position;
        $exercise->save();

        return redirect()->route('exercises.index', $unit_id)->with('success', 'Exercise position updated successfully');
    }

    private function getVideoFrom(Request $request)
    {
        if($request->hasFile('video') and $request->file('video')->isValid()) 
        {
            $video_file_name = $request->file('video')->getClientOriginalName();
            $video_file_path = $request->file('video')->storeAs('public/files', $video_file_name);

            return $video_file_name;
        } else {
            return null;
        }
    }

    private function getImageFrom(Request $request)
    {
        if($request->hasFile('image') and $request->file('image')->isValid()) 
        {
            $image_name = $request->file('image')->getClientOriginalName();
            $image_path = $request->file('image')->storeAs('public/files', $image_name);

            return $image_name;
        } else {
            return null;
        }
    }
}