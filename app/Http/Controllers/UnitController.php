<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Keyword;
use App\Models\Section;
use App\Http\Requests\StoreUnitRequest;

class UnitController extends Controller
{
    public function __construct() { $this->middleware('teacher'); }
    public function create() { return view('units.create'); }
    
    public function index()
    {
        $units = Unit::all();
        return view('units.index', compact('units'));
    }

    public function store(StoreUnitRequest $request)
    {
        $new_unit = new Unit;

        $new_unit->title = $request->title;
        $new_unit->author = $request->author;
        $new_unit->description = $request-> description;
        $new_unit->video_copyright = $request->video_copyright;

        $new_unit->listening_tips = $request->listening_tips;
        if($request->listening_tips_enabled == 'true')
        {
            $new_unit->listening_tips_enabled = true;
        } else {
            $new_unit->listening_tips_enabled = false;
        }

        $new_unit->cultural_notes = $request->cultural_notes;
        if ($request->cultural_notes_enabled == 'true') {
            $new_unit->cultural_notes_enabled = true;
        } else {
            $new_unit->cultural_notes_enabled = false;
        }

        $new_unit->transcript = $request->transcript;
        if ($request->transcript_enabled == 'true') {
            $new_unit->transcript_enabled = true;
        } else {
            $new_unit->transcript_enabled = false;
        }

        $new_unit->glossary = $request->glossary;
        if ($request->glossary_enabled == 'true') {
            $new_unit->glossary_enabled = true;
        } else {
            $new_unit->glossary_enabled = false;
        }
        
        $new_unit->translation = $request->translation;
        if ($request->translation_enabled == 'true') {
            $new_unit->translation_enabled = true;
        } else {
            $new_unit->translation_enabled = false;
        }

        $new_unit->dictionary = $request->dictionary;
        if ($request->dictionary_enabled == 'true') {
            $new_unit->dictionary_enabled = true;
        } else {
            $new_unit->dictionary_enabled = false;
        }

        $new_unit->video_name = $this->getVideoFrom($request);

        $new_unit->save();

        return redirect()->route('units.index')->with('success', 'Unit created successfully!');
    }

    public function show($id)
    {
        $unit = Unit::find($id);
        return view('units.show', compact('unit'));
    }

    public function update(Request $request, $unit)
    {
        $unit = Unit::find($unit);

        if($request->has('title' and $request->title != '')) $unit->title = $request->title;
        if($request->has('author' and $request->author != '')) $unit->author = $request->author;
        if($request->has('description' and $request->description != '')) $unit->description = $request->description;
        if($request->has('video_copyright') and $request->video_copyright != '') $unit->video_copyright = $request->video_copyright;

        if($request->has('listening_tips') and $request->listening_tips != '') $unit->listening_tips = $request->listening_tips;
        if($request->listening_tips_enabled == 'true')
        {
            $unit->listening_tips_enabled = true;
        } else {
            $unit->listening_tips_enabled = false;
        }

        if($request->has('cultural_notes') and $request->cultural_notes != '') $unit->cultural_notes = $request->cultural_notes;
        if ($request->cultural_notes_enabled == 'true') {
            $unit->cultural_notes_enabled = true;
        } else {
            $unit->cultural_notes_enabled = false;
        }

        if($request->has('transcript') and $request->transcript != '') $unit->transcript = $request->transcript;
        if ($request->transcript_enabled == 'true') {
            $unit->transcript_enabled = true;
        } else {
            $unit->transcript_enabled = false;
        }

        if($request->has('glossary') and $request->glossary != '') $unit->glossary = $request->glossary;
        if ($request->glossary_enabled == 'true') {
            $unit->glossary_enabled = true;
        } else {
            $unit->glossary_enabled = false;
        }
        
        if($request->has('translation') and $request->translation != '') $unit->translation = $request->translation;
        if ($request->translation_enabled == 'true') {
            $unit->translation_enabled = true;
        } else {
            $unit->translation_enabled = false;
        }

        if($request->has('dictionary') and $request->dictionary != '') $unit->dictionary = $request->dictionary;
        if ($request->dictionary_enabled == 'true') {
            $unit->dictionary_enabled = true;
        } else {
            $unit->dictionary_enabled = false;
        }

        if($request->has('video')) {
            $video_file_name = $request->file('video')->getClientOriginalName();
            $video_file_url = $request->file('video')->storeAs('public/files', $video_file_name);
    
            $unit->video_name = $video_file_name;
        }

        if($unit->isDirty()) {
            $unit->save();
        }

        return redirect()->route('units.show', $unit->id)->with('success', "$unit->title Unit updated successfully");
    }

    public function destroy($id)
    {
        Unit::find($id)->delete();
        return redirect()->route('units.index');
    }

    private function getVideoFrom(Request $request)
    {
        if($request->hasFile('video') and $request->file('video')->isValid()) 
        {
            $video_file_name = $request->file('video')->getClientOriginalName();
            $video_file_path = $request->file('video')->storeAs('public/files', $video_file_name);

            return $video_file_name;
        } else {
            return "";
        }
    }
}
