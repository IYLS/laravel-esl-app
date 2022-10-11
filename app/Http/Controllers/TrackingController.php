<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\UserResponse;
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
        $tracking = new Tracking;
        $tracking->intent_number = $request->intent_number;
        $tracking->time_spent_in_minutes = $request->time;
        $tracking->correct_answers = $request->correct;
        $tracking->wrong_answers = $request->wrong;
        $tracking->exercise_id = $exercise_id;
        $tracking->user_id = $user_id;
        $tracking->save();

        foreach($request->responses as $id=>$response)
        {
            $user_response = new UserResponse;
            $user_response->response = $response;
            $user_response->question_id = $id;
            $user_response->tracking_id = $tracking->id;
            $user_response->save();
        }

        return redirect()->back()->with('success', 'Your answers have been saved.');
    }

    public function show($id) 
    {
        $tracking = Tracking::find($id);

        return view('tracking.show', compact('tracking'));
    }
}