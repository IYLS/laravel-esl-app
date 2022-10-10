<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;

class TrackingController extends Controller
{
    public function index()
    {
        $tracking = Tracking::all();

        return view('tracking.index', compact('tracking'));
    }

    public function store(Request $request, $exercise_type_id, $subtype)
    {
         switch($exercise_type_id)
        {
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                break;
            case 6:
                break;
            case 7:
                break;
            case 8:
                break;
            default:
        }
    }

    public function storeMultipleChoice(StoreMultipleChoiceRequest $request, Integer $subtype) {}

    public function storeDragAndDrop(StoreDragAndDropRequest $request, Integer $subtype) {}

    public function storeOpenEnded(StoreOpenEndedRequest $request, Integer $subtype) {}

    public function storeFillInTheGaps(StoreFillInTheGapsRequest $request, Integer $subtype) {}

    public function storeVoiceRecognition(StoreVoiceRecognitionRequest $request, Integer $subtype) {}
}
