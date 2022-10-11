<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\UserResponse;
use App\Models\Exercise;
use App\Http\Requests\StoreMultipleChoiceRequest;
use App\Http\Requests\StoreDragAndDropRequest;
use App\Http\Requests\StoreOpenEndedRequest;
use App\Http\Requests\StoreFillInTheGapsRequest;
use App\Http\Requests\StoreVoiceRecognitionRequest;

class TrackingController extends Controller
{
    public function index()
    {
        $tracking = Tracking::all();
        if ($tracking != null)  {
            return view('tracking.index', compact('tracking'));
        } else if($tracking == null) {
            $tracking = array();
            return view('tracking.index', compact('tracking'));
        }
    }

    public function store(Request $request, $exercise_id, $user_id) 
    {

        $exercise = Exercise::find($exercise_id);

        $tracking = new Tracking;
        $tracking->intent_number = $request->intent_number == null ? "0" : $request->intent_number;
        $tracking->time_spent_in_minutes = $request->time == null ? "00:00" : $request->time;
        $tracking->correct_answers = $request->correct == null ? "0" : $request->correct;
        $tracking->wrong_answers = $request->wrong == null ? "0" : $request->wrong;
        $tracking->exercise_id = $exercise_id;
        $tracking->user_id = $user_id;
        $tracking->save();
    
        if($exercise != null and $exercise->exerciseType->underscore_name != 'form')
        {
            if ($request->responses != null) 
            {
                foreach($request->responses as $id=>$response)
                {
                    $user_response = new UserResponse;
                    if($response == null) $response = "";
                    $user_response->response = $response;
                    $user_response->question_id = $id;
                    $user_response->tracking_id = $tracking->id;
                    $user_response->save();
                }        
            }
        } else {
            if ($request->answers != null) 
            {
                foreach($request->answers as $id=>$answer)
                {
                    $question_id = $id;
                    foreach($answer as $a) 
                    {
                        foreach($a as $response)
                        {
                            $user_response = new UserResponse;
                            $user_response->response = $response;
                            $user_response->question_id = $question_id;
                            $user_response->tracking_id = $tracking->id;
                            $user_response->save();
                        }
                    }
                }
            }
        }


        return redirect()->back()->with('success', 'Your answers have been saved.');
    }

    public function show($id) 
    {
        $tracking = Tracking::find($id);

        return view('tracking.show', compact('tracking'));
    }
}