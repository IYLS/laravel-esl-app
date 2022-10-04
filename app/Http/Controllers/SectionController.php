<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Section;
use App\Models\Unit;

class SectionController extends Controller
{
    public function index($unit_id) {
        $sections = Unit::find($unit_id)->sections;

        return view('sections.index', compact('sections', 'unit_id'));
    }

    public function store(Request $request, $unit_id) {
        $section = new Section;
        $section->name = $request->name;
        $section->instructions = $request->instructions;
        $section->unit_id = $unit_id;
        $section->underscore_name = $this->toSnakeCase($request->name);

        $section->save();

        return redirect()->route('sections.index', $unit_id);
    }

    public function update(Section $section) {

    }

    public function destroy(Section $section) {
        $unit_id = $section->unit_id;
        $section->delete();

        return redirect()->route('sections.index', $unit_id);
    }

    private function toSnakeCase($text) 
    {
        $new_text = str_replace(" ", "_", $text);

        return strtolower($new_text);
    }
}
