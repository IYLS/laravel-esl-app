<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Unit;
use App\Models\Tracking;

class LeaderboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Profesor: requiere parámetro group o muestra selector de grupos
        if (in_array($user->role, ['teacher', 'researcher'])) {
            $groupId = $request->query('group');
            if (!$groupId) {
                $groups = Group::where('leaderboard_enabled', true)
                    ->orderBy('name')
                    ->get();
                return view('leaderboard.select_group', compact('groups'));
            }
            $group = Group::with(['units' => function($query) {
                $query->orderBy('position');
            }])->find($groupId);
            if (!$group || !$group->leaderboard_enabled) {
                return redirect()->route('leaderboard.index')
                    ->with('error', 'Grupo no encontrado o leaderboard no habilitado.');
            }
        } else {
            // Estudiante: usa su grupo asignado
            if (!$user->group_id) {
                return redirect()->route('student.level_selection')
                    ->with('error', 'No tienes un grupo asignado. Contacta a tu profesor.');
            }
            $group = Group::with(['units' => function($query) {
                $query->orderBy('position');
            }])->find($user->group_id);
            if (!$group) {
                return redirect()->route('student.level_selection')
                    ->with('error', 'Grupo no encontrado.');
            }
            if (!$group->leaderboard_enabled) {
                return redirect()->route('student.level_selection')
                    ->with('error', 'El leaderboard no está habilitado para tu grupo.');
            }
        }

        // Obtener todos los estudiantes del mismo grupo
        $students = User::where('group_id', $group->id)
            ->where('role', 'student')
            ->where('activated', true)
            ->get();

        // Obtener unidad seleccionada del filtro (si existe)
        $selectedUnitId = $request->query('unit');
        
        // Obtener unidades del grupo ordenadas por posición con sus secciones y ejercicios
        $units = $group->units->load(['sections.exercises' => function($query) {
            $query->where('exercise_type_id', '!=', 5);
        }]);

        // Calcular progreso para cada estudiante
        $leaderboard = [];
        
        foreach ($students as $student) {
            if ($selectedUnitId) {
                // Progreso por unidad específica
                $unit = Unit::find($selectedUnitId);
                if ($unit && $units->contains('id', $selectedUnitId)) {
                    $progress = $this->calculateUnitProgress($student, $unit);
                    $leaderboard[] = [
                        'student' => $student,
                        'progress' => $progress['percentage'],
                        'completed' => $progress['completed'],
                        'total' => $progress['total'],
                        'unit_id' => $unit->id,
                        'unit_title' => $unit->title
                    ];
                }
            } else {
                // Progreso global (todas las unidades del grupo)
                $progress = $this->calculateGlobalProgress($student, $units);
                $leaderboard[] = [
                    'student' => $student,
                    'progress' => $progress['percentage'],
                    'completed' => $progress['completed'],
                    'total' => $progress['total'],
                    'unit_id' => null,
                    'unit_title' => 'All Units'
                ];
            }
        }

        // Ordenar por progreso descendente, luego por nombre
        usort($leaderboard, function($a, $b) {
            if ($b['progress'] == $a['progress']) {
                return strcmp($a['student']->name, $b['student']->name);
            }
            return $b['progress'] - $a['progress'];
        });

        // Encontrar la posición del usuario actual
        $currentUserPosition = null;
        foreach ($leaderboard as $index => $entry) {
            if ($entry['student']->id === $user->id) {
                $currentUserPosition = $index + 1;
                break;
            }
        }

        $groups = null;
        if (in_array($user->role, ['teacher', 'researcher'])) {
            $groups = Group::where('leaderboard_enabled', true)->orderBy('name')->get();
        }

        return view('leaderboard.index', compact([
            'leaderboard',
            'units',
            'selectedUnitId',
            'currentUserPosition',
            'user',
            'group',
            'groups'
        ]));
    }

    /**
     * Calcula el progreso global de un estudiante en todas las unidades del grupo
     */
    private function calculateGlobalProgress($student, $units)
    {
        $totalExercises = 0;
        $completedExercises = 0;

        foreach ($units as $unit) {
            $unitProgress = $this->calculateUnitProgress($student, $unit);
            $totalExercises += $unitProgress['total'];
            $completedExercises += $unitProgress['completed'];
        }

        $percentage = $totalExercises > 0 ? round(($completedExercises / $totalExercises) * 100) : 0;

        return [
            'completed' => $completedExercises,
            'total' => $totalExercises,
            'percentage' => $percentage
        ];
    }

    /**
     * Calcula el progreso de un estudiante en una unidad específica
     */
    private function calculateUnitProgress($student, $unit)
    {
        // Cargar las relaciones si no están cargadas
        if (!$unit->relationLoaded('sections')) {
            $unit->load(['sections.exercises' => function($query) {
                $query->where('exercise_type_id', '!=', 5);
            }]);
        }

        $totalExercises = 0;
        $completedExercises = 0;

        // Obtener todos los ejercicios completados del estudiante
        $completedExerciseIds = Tracking::where('user_id', $student->id)
            ->distinct()
            ->pluck('exercise_id')
            ->toArray();

        // Calcular progreso de la unidad
        foreach ($unit->sections as $section) {
            // Excluir ejercicios tipo 5 (como se hace en StudentController)
            $sectionExercises = $section->exercises->where('exercise_type_id', '!=', 5);
            $totalExercises += $sectionExercises->count();
            
            foreach ($sectionExercises as $exercise) {
                if (in_array($exercise->id, $completedExerciseIds)) {
                    $completedExercises++;
                }
            }
        }

        $percentage = $totalExercises > 0 ? round(($completedExercises / $totalExercises) * 100) : 0;

        return [
            'completed' => $completedExercises,
            'total' => $totalExercises,
            'percentage' => $percentage
        ];
    }
}
