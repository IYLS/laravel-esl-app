<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Keyword;
use App\Models\Section;
use App\Models\GlossedWord;
use App\Http\Requests\StoreUnitRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function __construct() { $this->middleware('teacher'); }
    public function create() { return view('units.create'); }
    
    public function index()
    {
        $units = Unit::all()->sortBy('position');
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

        if($request->has('title') and $request->title != '') $unit->title = $request->title;
        if($request->has('author') and $request->author != '') $unit->author = $request->author;
        if($request->has('description') and $request->description != '') $unit->description = $request->description;
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
            $video_file_url = $request->file('video')->storeAs('files', $video_file_name, 'public');
    
            $unit->video_name = $video_file_name;
        }

        if($unit->isDirty()) {
            $unit->save();
        }

        return redirect()->route('units.show', $unit->id)->with('success', "$unit->title Unit updated successfully");
    }

    public function setPositions(Request $request)
    {
        foreach($request->positions as $id => $position) {
            $unit = Unit::find($id);
            $unit->position = $position;
            $unit->save();
        }

        return redirect()->route('units.index')->with('success', 'Units positions defined successfully!');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        
        // Validar que no haya tracking activo (opcional pero recomendado)
        // Esto previene pérdida de datos históricos importantes
        $hasActiveTracking = \App\Models\Tracking::whereHas('exercise.section', function($query) use ($unit) {
            $query->where('unit_id', $unit->id);
        })->exists();
        
        if ($hasActiveTracking) {
            return redirect()->route('units.index')
                ->with('error', 'Cannot delete unit with active tracking data. Please contact administrator.');
        }
        
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully!');
    }

    public function duplicate($id)
    {
        $originalUnit = Unit::with([
            'sections.exercises.questions.alternatives.feedback',
            'sections.exercises.questions.feedbacks',
            'sections.exercises.feedbacks',
            'keywords',
            'glossedWords',
        ])->findOrFail($id);

        return DB::transaction(function () use ($originalUnit) {
            $newUnit = $this->replicateWithoutId($originalUnit);
            $newUnit->title = $originalUnit->title.' (Copy)';
            $newUnit->save();

            foreach ($originalUnit->keywords as $keyword) {
                $newKeyword = $this->replicateWithoutId($keyword);
                $newKeyword->unit_id = $newUnit->id;
                $newKeyword->save();
            }

            foreach ($originalUnit->glossedWords as $glossedWord) {
                $newGlossedWord = $this->replicateWithoutId($glossedWord);
                $newGlossedWord->unit_id = $newUnit->id;
                $newGlossedWord->save();
            }

            foreach ($originalUnit->sections->sortBy('position')->values() as $section) {
                $newSection = $this->replicateWithoutId($section);
                $newSection->unit_id = $newUnit->id;
                $newSection->save();

                foreach ($section->exercises->sortBy('position')->values() as $exercise) {
                    $newExercise = $this->replicateWithoutId($exercise);
                    $newExercise->section_id = $newSection->id;
                    $newExercise->save();

                    // Solo feedback verdaderamente a nivel ejercicio (sin pregunta ni alternativa).
                    // Los registros de feedback por pregunta también tienen exercise_id; no deben pasar por aquí.
                    foreach (
                        $exercise->feedbacks
                            ->whereNull('question_id')
                            ->whereNull('alternative_id')
                            ->values() as $feedback
                    ) {
                        $newFeedback = $this->replicateWithoutId($feedback);
                        $newFeedback->exercise_id = $newExercise->id;
                        $newFeedback->question_id = null;
                        $newFeedback->alternative_id = null;
                        $newFeedback->save();
                    }

                    foreach ($exercise->questions->sortBy('position')->values() as $question) {
                        $newQuestion = $this->replicateWithoutId($question);
                        $newQuestion->exercise_id = $newExercise->id;
                        $newQuestion->save();

                        foreach ($question->alternatives->sortBy('id')->values() as $alternative) {
                            $newAlternative = $this->replicateWithoutId($alternative);
                            $newAlternative->question_id = $newQuestion->id;
                            $newAlternative->save();

                            if ($alternative->feedback) {
                                $newAltFeedback = $this->replicateWithoutId($alternative->feedback);
                                $newAltFeedback->exercise_id = $newExercise->id;
                                $newAltFeedback->question_id = $newQuestion->id;
                                $newAltFeedback->alternative_id = $newAlternative->id;
                                $newAltFeedback->save();
                            }
                        }

                        // Feedback ligado a la pregunta sin alternativa (p. ej. Directive, Elaborative).
                        // Los explanatory con alternative_id se copiaron arriba; evitar duplicar.
                        foreach ($question->feedbacks->whereNull('alternative_id')->values() as $feedback) {
                            $newFeedback = $this->replicateWithoutId($feedback);
                            $newFeedback->exercise_id = $newExercise->id;
                            $newFeedback->question_id = $newQuestion->id;
                            $newFeedback->alternative_id = null;
                            $newFeedback->save();
                        }
                    }
                }
            }

            return redirect()->route('units.index')->with('success', 'Unit duplicated successfully!');
        });
    }

    /**
     * Replica sin incluir la PK en los atributos del INSERT.
     * En PostgreSQL, insertar "id" = NULL viola NOT NULL; hay que omitir la columna y usar la secuencia.
     *
     * @template T of Model
     * @param  T  $model
     * @return T
     */
    private function replicateWithoutId(Model $model): Model
    {
        $copy = $model->replicate();
        $key = $model->getKeyName();
        if ($key !== null && $key !== '') {
            $copy->setRawAttributes(Arr::except($copy->getAttributes(), [$key]), true);
        }
        $copy->exists = false;

        return $copy;
    }

    private function getVideoFrom(Request $request)
    {
        if($request->hasFile('video') and $request->file('video')->isValid()) 
        {
            $video_file_name = $request->file('video')->getClientOriginalName();
            $video_file_path = $request->file('video')->storeAs('files', $video_file_name, 'public');

            return $video_file_name;
        } else {
            return "";
        }
    }
}
