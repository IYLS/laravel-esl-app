<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\UserResponse;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Unit;
use App\Models\Group;
use App\Models\TrackingHelpUsage;
use App\Models\TrackingFeedbackUsage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTracking;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::all();
        $students = User::where('role', 'student')->get();
        
        // Obtener parámetros de query string
        $group_id = $request->query('group');
        $user_id = $request->query('student');
        
        // Aplicar filtros si existen (una sola query para evitar memory exhausted)
        $limit = 500;
        if ($user_id != null && $user_id != "any") {
            $tracking = Tracking::with(['user.group', 'exercise.section.unit', 'exercise.exerciseType'])
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } else if ($group_id != "any" && $group_id != null) {
            $userIds = User::where('group_id', $group_id)->pluck('id');
            $tracking = Tracking::with(['user.group', 'exercise.section.unit', 'exercise.exerciseType'])
                ->whereIn('user_id', $userIds)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } else {
            $tracking = Tracking::with(['user.group', 'exercise.section.unit', 'exercise.exerciseType'])
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        }

        // Pasar filtros actuales a la vista
        $currentGroup = $group_id ?? 'any';
        $currentStudent = $user_id ?? 'any';

        return view('tracking.index', compact('tracking', 'groups', 'students', 'currentGroup', 'currentStudent'));
    }

    public function executeFilter(Request $request)
    {
        $group_id = $request->group;
        $month_number = $request->month;
        $user_id = $request->student;

        // Redirigir con query strings para preservar los filtros
        $queryParams = [];
        if ($group_id && $group_id != "any") {
            $queryParams['group'] = $group_id;
        }
        if ($user_id && $user_id != "any") {
            $queryParams['student'] = $user_id;
        }

        return redirect()->route('tracking.index', $queryParams);
    }

    public function store(Request $request, $exercise_id, $user_id)
    {
        $exercise = Exercise::find($exercise_id);

        if($exercise->exercise_type_id != 5) {
            $tracking = new Tracking;

            $intent_number = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
            $intent_number += 1;
    
            $tracking->intent_number = "$intent_number";
    
            if($request->time == null) {
                $tracking->time_spent_in_seconds = 0;
            } else {
                // Convertir formato "HH:MM:SS" o "MM:SS" a segundos
                $time = $request->time;
                $parts = explode(':', $time);
                
                if (count($parts) == 3) {
                    // Formato HH:MM:SS
                    $tracking->time_spent_in_seconds = (int)$parts[0] * 3600 + (int)$parts[1] * 60 + (int)$parts[2];
                } elseif (count($parts) == 2) {
                    // Formato MM:SS
                    $tracking->time_spent_in_seconds = (int)$parts[0] * 60 + (int)$parts[1];
                } else {
                    // Si no es formato válido, asumir que ya viene en segundos
                    $tracking->time_spent_in_seconds = (int)$time;
                }
            }
    
            if($request->correct == null) {
                $tracking->correct_answers = "0";
            } else {
                $tracking->correct_answers = $request->correct;
            }
    
            if($request->wrong == null) {
                $tracking->wrong_answers = "0";
            } else {
                $tracking->wrong_answers = $request->wrong;
            }
    
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
                foreach($exercise->questions as $question)
                {
                    // EXCLUSIVE RESPONSES IS FALSE
                    if (!$question->exclusive_responses)
                    {
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
                    // FIXME: EXCLUSIVE RESPONSES IS TRUE
                    } else {
                        if ($request->answers != null)
                        {
                            foreach($request->answers as $id=>$answer)
                            {
                                $question_id = $id;
                                foreach($answer as $response)
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
            }
    
            // Contadores de feedback por pregunta y tipo
            foreach ($exercise->questions as $question) {
                $qid = $question->id;
                $perQuestionCounts = [
                    'Directive' => isset($request->directive["$qid"]) ? (int) $request->directive["$qid"] : 0,
                    'Explanatory' => isset($request->explanatory["$qid"]) ? (int) $request->explanatory["$qid"] : 0,
                    'Elaborative' => isset($request->elaborative["$qid"]) ? (int) $request->elaborative["$qid"] : 0,
                    'Knowledge of Correct Response' => isset($request->knowledge["$qid"]) ? (int) $request->knowledge["$qid"] : 0,
                ];

                foreach ($perQuestionCounts as $feedback_type => $count) {
                    if ($count > 0) {
                        TrackingFeedbackUsage::create([
                            'tracking_id' => $tracking->id,
                            'question_id' => $qid,
                            'feedback_type' => $feedback_type,
                            'open_count' => $count,
                        ]);
                    }
                }
            }

    
            // Guardar help options en la nueva tabla
            $help_options = [
                'Transcript' => ['count' => $request->transcript_count ?? 0, 'time' => $request->transcript_total_time ?? 0],
                'Listening tips' => ['count' => $request->listening_tips_count ?? 0, 'time' => $request->listening_tips_total_time ?? 0],
                'Culture notes' => ['count' => $request->cultural_notes_count ?? 0, 'time' => $request->cultural_notes_total_time ?? 0],
                'Glossary' => ['count' => $request->glossary_count ?? 0, 'time' => $request->glossary_total_time ?? 0],
                'Translation' => ['count' => $request->translation_count ?? 0, 'time' => $request->translation_total_time ?? 0],
                'Dictionary' => ['count' => $request->dictionary_count ?? 0, 'time' => $request->dictionary_total_time ?? 0]
            ];
    
            foreach($help_options as $help_type => $data) {
                if ($data['count'] > 0 || $data['time'] > 0) {
                    TrackingHelpUsage::create([
                        'tracking_id' => $tracking->id,
                        'help_type' => $help_type,
                        'open_count' => (int)$data['count'],
                        'time_spent_seconds' => (int)$data['time']
                    ]);
                }
            }
    
            $tracking->save();
        }

        $message = '🎉 Submission completed successfully! 🎉';
        if($exercise->feedbacks->where('feedback_type_id', 1)->first() != null) {
            $message = $exercise->feedbacks->where('feedback_type_id', 1)->first()->message;
        }

        $status = $this->exerciseStatus($exercise, $user_id);
        
        // Obtener número de intentos actual (después de guardar)
        $attempts_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
        
        // Calcular progreso actualizado de la unidad
        $unit = $exercise->section->unit;
        $total_exercises = 0;
        $completed_count = 0;
        
        foreach($unit->sections as $section) {
            $section_exercises = $section->exercises->where('exercise_type_id', '!=', 5);
            $total_exercises += $section_exercises->count();
            
            foreach($section_exercises as $ex) {
                $tracking_count = Tracking::where('exercise_id', $ex->id)->where('user_id', $user_id)->count();
                if($tracking_count >= 1) {
                    $completed_count++;
                }
            }
        }
        
        $unit_progress = $total_exercises > 0 ? round(($completed_count / $total_exercises) * 100) : 0;

        return response()->json([
            'result' => 'success',
            'feedback_message' => "$message",
            'status_message' => $status['message'],
            'navigation_url' => $status['url'],
            'navigation_type' => $status['type'],
            'attempts_count' => $attempts_count,
            'unit_progress' => $unit_progress,
            'completed_count' => $completed_count,
            'total_exercises' => $total_exercises,
        ]);
    }

    public function show(Request $request, $id)
    {
        $tracking = Tracking::with(['helpUsage', 'feedbackUsage', 'userResponses.question'])->find($id);

        $sortedResponses = $tracking->userResponses
            ->sortBy(function (UserResponse $response) {
                $position = optional($response->question)->position;

                return [(int) ($position ?? 1_000_000), (int) $response->question_id];
            })
            ->values();
        $tracking->setRelation('userResponses', $sortedResponses);

        // Obtener parámetros de filtro de la query string para pasarlos a la vista
        $group_id = $request->query('group');
        $user_id = $request->query('student');
        
        return view('tracking.show', compact('tracking', 'group_id', 'user_id'));
    }

    public function exportData(Request $request)
    {
        $groupId = $request->group;
        $userId = $request->student;
        $currentDate = Carbon::now()->format('d-m-Y H:i');
        
        // Si se seleccionó un estudiante específico, exportar solo ese estudiante
        if ($userId && $userId != "") {
            $user = User::findOrFail($userId);
            $fileName = "{$user->name} - {$currentDate}.xlsx";
            return Excel::download(new ExportTracking($userId, 'student'), $fileName);
        }
        
        // Si se seleccionó un grupo (sin estudiante específico), exportar todo el grupo
        if ($groupId && $groupId != "") {
            $group = Group::findOrFail($groupId);
            $users = User::where('group_id', $groupId)->where('role', 'student')->get();
            
            if ($users->isEmpty()) {
                return redirect()->route('tracking.index')
                    ->with('error', 'El grupo seleccionado no tiene estudiantes.');
            }
            
            $userIds = $users->pluck('id')->toArray();
            $fileName = "{$group->name} - {$currentDate}.xlsx";
            return Excel::download(new ExportTracking($userIds, 'group'), $fileName);
        }
        
        // Si no se seleccionó ni grupo ni estudiante, retornar error
        return redirect()->route('tracking.index')
            ->with('error', 'Por favor seleccione un grupo o un estudiante para exportar.');
    }

    private function sectionStatus($exercise, $user_id) {
        $section = $exercise->section;
        $exercises = $section->exercises->where('exercise_type_id', '!=', 5);
        $section_completed = false;
        $completed_exercises = array();

        foreach($exercises as $exercise) {
            $tracking_count = Tracking::where('user_id', $user_id)->where('exercise_id', $exercise->id)->count();
            if($tracking_count >= 1) array_push($completed_exercises, $exercise->id);
        }
        if(count($exercises) == count($completed_exercises))
            return true;
        else {
            return false;
        }
    }

    private function unitStatus($exercise, $user_id) {
        $unit = $exercise->section->unit;
        $section_completed = false;
        $sections_completed = array();

        foreach($unit->sections as $section) {
            $exercises = $section->exercises->where('exercise_type_id', '!=', 5);

            $completed_exercises = array();
            foreach($exercises as $exercise) {
                $tracking_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
                if($tracking_count >= 1) array_push($completed_exercises, $exercise->id);
            }

            if (count($completed_exercises) == count($exercises)) array_push($sections_completed, $section->id);
        }

        if(count($unit->sections) == count($sections_completed))
            return true;
        else {
            return false;
        }
    }

    private function getNextExercise($exercise, $user_id) {
        // Buscar siguiente ejercicio sin completar después del ejercicio actual, ordenado por posición
        
        $section = $exercise->section;
        // Ordenar ejercicios por posición y filtrar tipo Voice Recognition
        $exercises = $section->exercises->where('exercise_type_id', '!=', 5)->sortBy('position');
        $next_exercise = null;
        $found_current = false;

        foreach($exercises as $ex) {
            // Primero encontrar el ejercicio actual
            if ($ex->id == $exercise->id) {
                $found_current = true;
                continue; // Continuar al siguiente después del actual
            }
            
            // Si ya encontramos el ejercicio actual, buscar el siguiente sin completar
            if ($found_current) {
                $exercise_tracking_count = Tracking::where('exercise_id', $ex->id)->where('user_id', $user_id)->count();
                if($exercise_tracking_count == 0) {
                    $next_exercise = $ex;
                    break;
                }
            }
        }

        // Si no hay siguiente ejercicio en la sección actual, retornar null
        if ($next_exercise == null) {
            return null;
        }

        $url = $next_exercise->exerciseType->underscore_name . $next_exercise->id;
        return $url;
    }

    private function getNextSection($exercise, $user_id) {
        // Buscar siguiente sección con ejercicios sin completar, ordenada por posición
        
        $current_section = $exercise->section;
        $unit = $current_section->unit;
        // Ordenar secciones por posición
        $sections = $unit->sections->sortBy('position');
        $next_section = null;
        $found_current_section = false;

        foreach($sections as $section) {
            // Primero encontrar la sección actual
            if ($section->id == $current_section->id) {
                $found_current_section = true;
                continue; // Continuar a la siguiente sección
            }
            
            // Si ya encontramos la sección actual, buscar la siguiente con ejercicios sin completar
            if ($found_current_section) {
                $exercises = $section->exercises->where('exercise_type_id', '!=', 5)->sortBy('position');
                $has_incomplete = false;
                
                foreach($exercises as $ex) {
                    $exercise_tracking_count = Tracking::where('exercise_id', $ex->id)->where('user_id', $user_id)->count();
                    if($exercise_tracking_count == 0) {
                        $has_incomplete = true;
                        break;
                    }
                }
                
                if ($has_incomplete) {
                    $next_section = $section;
                    break;
                }
            }
        }

        if($next_section != null) {
            $url = $next_section->underscore_name;
        } else {
            $url = null;
        }

        return $url;
    }

    private function getNextUnit($exercise, $user_id) {
        $section = $exercise->section;
        $unit = $section->unit;
        $user = User::find($user_id);
        $group = Group::find($user->group_id);
        $units = $group->units;
        $completed_sections = [];

        $next_unit;

        foreach($units as $unit) {
            foreach($unit->sections as $section) {
                $exercises = $section->exercises->where('exercise_type_id', '!=', 5);
                $completed_exercises = [];
                foreach($exercises as $exercise)
                {
                    $exercise_tracking_count = Tracking::where('exercise_id', $exercise->id)->where('user_id', $user_id)->count();
                    if($exercise_tracking_count >= 1) array_push($completed_exercises, $exercise->id);
                }
                if(count($exercises) == count($completed_exercises)) array_push($completed_sections, $section->id);
            }
            if(count($unit->sections) == count($completed_sections)) {
                $u = Unit::where('position', $unit->position + 1)->get()->first();
                $next_unit = route('student.show', "$u->id");
                break;
            }
        }

        if ($next_unit != null and isset($next_unit)) {
            return $next_unit;
        } else {
            return "";
        }

    }

    private function exerciseStatus($exercise, $user_id) {
        // Primero verificar si hay siguiente ejercicio en la sección actual
        $next_exercise_url = $this->getNextExercise($exercise, $user_id);
        
        if ($next_exercise_url != null) {
            return ["message" => "You completed this exercise, now you can continue with the next one", "url" => "$next_exercise_url", 'type' => 'exercise'];
        }
        
        // Si no hay siguiente ejercicio, verificar si hay siguiente sección
        $next_section_url = $this->getNextSection($exercise, $user_id);
        
        if ($next_section_url != null) {
            return ["message" => "You completed this stage, now you can continue with the next one", "url" => "$next_section_url", 'type' => 'section'];
        }
        
        // Si no hay siguiente sección, verificar si hay siguiente unidad
        $unit_completed = $this->unitStatus($exercise, $user_id);
        
        if ($unit_completed) {
            $next_unit_url = $this->getNextUnit($exercise, $user_id);
            if ($next_unit_url != null && $next_unit_url != "") {
                return ["message" => "You completed this unit, now you can move to the next unit", "url" => "$next_unit_url", 'type' => 'unit'];
            }
        }
        
        // Si no hay nada más, retornar mensaje indicando que está completo
        return ["message" => "You have completed all exercises", "url" => "", 'type' => 'exercise'];
    }
}