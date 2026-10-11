<?php

namespace App\Exports;

use App\Models\Comment;
use App\Models\Exercise;
use App\Models\Question;
use App\Models\Section;
use App\Models\Tracking;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Carga una sola vez todos los datos que necesitan las pestañas del export de
 * tracking y concentra las reglas de rotulado de columnas (unidades, stages,
 * ejercicios y preguntas), de modo que todas las pestañas usen los mismos
 * nombres para la misma cosa.
 */
class TrackingExportContext
{
    public const CATEGORY_COMPREHENSION = 'comprehension';
    public const CATEGORY_METACOGNITION = 'metacognition';
    public const CATEGORY_ENGAGEMENT = 'engagement';

    /** Categorías de ejercicio, en el orden en que se muestran las columnas. */
    public const CATEGORIES = [
        self::CATEGORY_COMPREHENSION => 'Comprehension',
        self::CATEGORY_METACOGNITION => 'Metacognition',
        self::CATEGORY_ENGAGEMENT => 'Engagement',
    ];

    /** Tipos de ejercicio que se corrigen automáticamente (drag and drop, multiple choice, fill in the gaps). */
    public const GRADABLE_TYPE_IDS = [1, 2, 3];

    /** Voice recognition no cuenta para el avance del estudiante. */
    public const VOICE_RECOGNITION_TYPE_ID = 5;

    /** help_type guardado en tracking_help_usage => nombre usado en las cabeceras. */
    public const HELP_TYPES = [
        'Transcript' => 'Transcript',
        'Listening tips' => 'Tips',
        'Culture notes' => 'Cultural Notes',
        'Glossary' => 'Glossary',
        'Translation' => 'Translation',
        'Dictionary' => 'Dictionary',
    ];

    /** feedback_type guardado en tracking_feedback_usage => nombre usado en las cabeceras. */
    public const FEEDBACK_TYPES = [
        'Elaborative' => 'Elaborative',
        'Explanatory' => 'Explanatory',
        'Directive' => 'Directive',
        'Knowledge of Correct Response' => 'Knowledge of correct response',
    ];

    /** @var int[] */
    protected array $userIds;

    protected ?Collection $users = null;
    protected ?Collection $units = null;
    protected ?Collection $exerciseRows = null;
    protected ?Collection $comments = null;

    /** @var array<int,int> unit_id => número de unidad */
    protected array $unitNumbers = [];

    /** @var array<int,string> exercise_id => título (con sufijo numérico si se repite en el stage) */
    protected array $exerciseTitles = [];

    /** @var array<int,array<int,Tracking[]>> user_id => exercise_id => intentos */
    protected ?array $trackingIndex = null;

    /** @var array<int,int> user_id => segundos acumulados en toda la plataforma */
    protected ?array $platformSeconds = null;

    public function __construct(array $userIds)
    {
        $this->userIds = array_values(array_unique(array_map('intval', $userIds)));
    }

    /**
     * Estudiantes exportados, ordenados por nombre.
     */
    public function users(): Collection
    {
        if ($this->users === null) {
            $this->users = User::with('group')
                ->whereIn('id', $this->userIds)
                ->get()
                ->sortBy(fn (User $user) => mb_strtolower((string) $user->name))
                ->values();
        }

        return $this->users;
    }

    /**
     * Unidades asignadas a los grupos de los estudiantes exportados, con sus
     * stages, ejercicios y preguntas ya cargados y ordenados por posición.
     */
    public function units(): Collection
    {
        if ($this->units !== null) {
            return $this->units;
        }

        $groupIds = $this->users()->pluck('group_id')->filter()->unique()->values();

        $unitIds = $groupIds->isEmpty()
            ? Unit::pluck('id')
            : Unit::whereHas('groups', fn ($query) => $query->whereIn('groups.id', $groupIds))->pluck('id');

        $this->units = Unit::with([
            'sections' => fn ($query) => $query->orderBy('position')->orderBy('id'),
            'sections.exercises' => fn ($query) => $query->orderBy('position')->orderBy('id'),
            'sections.exercises.exerciseType',
            'sections.exercises.questions' => fn ($query) => $query->orderBy('position')->orderBy('id'),
        ])
            ->whereIn('id', $unitIds)
            ->get()
            ->sortBy([
                fn (Unit $a, Unit $b) => ($a->position ?? PHP_INT_MAX) <=> ($b->position ?? PHP_INT_MAX),
                fn (Unit $a, Unit $b) => strnatcasecmp((string) $a->title, (string) $b->title),
            ])
            ->values();

        foreach ($this->units as $index => $unit) {
            // Los títulos vienen como "U1: Beats move us"; si no, se numera por orden.
            $this->unitNumbers[$unit->id] = preg_match('/^\s*U\s*(\d+)/i', (string) $unit->title, $matches)
                ? (int) $matches[1]
                : $index + 1;
        }

        return $this->units;
    }

    /**
     * Un registro por ejercicio, con su unidad y stage, en orden de currículum.
     *
     * @return Collection<int,array{unit:Unit,section:Section,exercise:Exercise}>
     */
    public function exerciseRows(): Collection
    {
        if ($this->exerciseRows !== null) {
            return $this->exerciseRows;
        }

        $rows = collect();

        foreach ($this->units() as $unit) {
            foreach ($unit->sections as $section) {
                $exercises = $section->exercises;

                // Los títulos se repiten dentro de un mismo stage ("Resources",
                // "Teacher support"), así que los repetidos se numeran.
                $totals = [];
                foreach ($exercises as $exercise) {
                    $title = $this->baseTitle($exercise);
                    $totals[$title] = ($totals[$title] ?? 0) + 1;
                }

                $seen = [];
                foreach ($exercises as $exercise) {
                    $title = $this->baseTitle($exercise);

                    if (($totals[$title] ?? 0) > 1) {
                        $seen[$title] = ($seen[$title] ?? 0) + 1;
                        $this->exerciseTitles[$exercise->id] = $title . ' ' . $seen[$title];
                    } else {
                        $this->exerciseTitles[$exercise->id] = $title;
                    }

                    $rows->push([
                        'unit' => $unit,
                        'section' => $section,
                        'exercise' => $exercise,
                    ]);
                }
            }
        }

        return $this->exerciseRows = $rows;
    }

    /**
     * Comentarios del foro escritos por los estudiantes exportados.
     */
    public function comments(): Collection
    {
        if ($this->comments === null) {
            $this->comments = Comment::whereIn('user_id', $this->userIds)
                ->orderBy('created_at')
                ->orderBy('id')
                ->get();
        }

        return $this->comments;
    }

    // -----------------------------------------------------------------
    // Rotulado de columnas
    // -----------------------------------------------------------------

    /** "U1" */
    public function unitShortLabel(Unit $unit): string
    {
        $this->units();

        return 'U' . ($this->unitNumbers[$unit->id] ?? $unit->id);
    }

    /** "Unit 1" */
    public function unitLongLabel(Unit $unit): string
    {
        $this->units();

        return 'Unit ' . ($this->unitNumbers[$unit->id] ?? $unit->id);
    }

    /** "Planning stage" => "PS" */
    public function stageShortLabel(Section $section): string
    {
        $words = preg_split('/[^A-Za-z0-9]+/', (string) $section->name, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $initials = '';
        foreach ($words as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }

        return $initials !== '' ? $initials : 'S' . $section->id;
    }

    /** "Planning stage" => "Planning" */
    public function stageShortName(Section $section): string
    {
        $name = trim((string) $section->name);
        $stripped = trim(preg_replace('/\s*stage\s*$/i', '', $name) ?? '');

        return $stripped !== '' ? $stripped : $name;
    }

    /** "Planning stage" */
    public function stageFullName(Section $section): string
    {
        $name = trim((string) $section->name);

        return $name !== '' ? $name : 'Stage ' . $section->id;
    }

    /** Título del ejercicio, numerado si se repite dentro de su stage. */
    public function exerciseTitle(Exercise $exercise): string
    {
        $this->exerciseRows();

        return $this->exerciseTitles[$exercise->id] ?? $this->baseTitle($exercise);
    }

    /** " (M)" para metacognition, " (E)" para engagement, nada para comprehension. */
    public function categorySuffix(Exercise $exercise): string
    {
        switch (mb_strtolower((string) $exercise->category)) {
            case self::CATEGORY_METACOGNITION:
                return ' (M)';
            case self::CATEGORY_ENGAGEMENT:
                return ' (E)';
            default:
                return '';
        }
    }

    /** "U1 - VS - Evaluating statements - Q2" */
    public function questionLabel(array $row, Question $question): string
    {
        $questions = $row['exercise']->questions->values();
        $position = $questions->search(fn (Question $candidate) => $candidate->id === $question->id);

        return sprintf(
            '%s - %s - %s - Q%d',
            $this->unitShortLabel($row['unit']),
            $this->stageShortLabel($row['section']),
            $this->exerciseTitle($row['exercise']),
            $position === false ? $question->id : $position + 1
        );
    }

    // -----------------------------------------------------------------
    // Clasificación de ejercicios
    // -----------------------------------------------------------------

    /**
     * Ejercicios de comprehension que el sistema corrige solo: son los únicos
     * de los que se puede derivar correctas/incorrectas por pregunta.
     */
    public function isGradableComprehension(Exercise $exercise): bool
    {
        return mb_strtolower((string) $exercise->category) === self::CATEGORY_COMPREHENSION
            && in_array((int) $exercise->exercise_type_id, self::GRADABLE_TYPE_IDS, true);
    }

    /**
     * Si una pregunta concreta se puede corregir: necesita una respuesta
     * esperada y no puede ser de respuesta personal (esas no tienen correcta).
     */
    public function isGradableQuestion(Exercise $exercise, Question $question): bool
    {
        if (! $this->isGradableComprehension($exercise)) {
            return false;
        }

        if ((bool) $question->personal_response) {
            return false;
        }

        switch ((int) $exercise->exercise_type_id) {
            case 1: // Drag and drop
                return trim((string) $question->statement) !== '';
            case 2: // Multiple choice
                return trim((string) $question->correct_answer) !== '';
            case 3: // Fill in the gaps
                return trim((string) $question->answer) !== '';
            default:
                return false;
        }
    }

    /** Preguntas corregibles de un ejercicio, en orden. */
    public function gradableQuestions(Exercise $exercise): Collection
    {
        return $exercise->questions
            ->filter(fn (Question $question) => $this->isGradableQuestion($exercise, $question))
            ->values();
    }

    /** Ejercicios de respuesta libre: el complemento de los corregibles. */
    public function isOpenAnswer(Exercise $exercise): bool
    {
        return ! $this->isGradableComprehension($exercise);
    }

    public function isReflectionStage(Section $section): bool
    {
        return str_contains(mb_strtolower((string) $section->name), 'reflection');
    }

    /** Voice recognition no se considera para el avance ni para los completados. */
    public function countsTowardsCompletion(Exercise $exercise): bool
    {
        return (int) $exercise->exercise_type_id !== self::VOICE_RECOGNITION_TYPE_ID;
    }

    // -----------------------------------------------------------------
    // Tracking
    // -----------------------------------------------------------------

    /**
     * Intentos de un estudiante en un ejercicio, del más antiguo al más reciente.
     *
     * @return Tracking[]
     */
    public function attempts(int $userId, int $exerciseId): array
    {
        return $this->trackingIndex()[$userId][$exerciseId] ?? [];
    }

    public function latestAttempt(int $userId, int $exerciseId): ?Tracking
    {
        $attempts = $this->attempts($userId, $exerciseId);

        return empty($attempts) ? null : end($attempts);
    }

    public function hasCompleted(int $userId, int $exerciseId): bool
    {
        return ! empty($this->attempts($userId, $exerciseId));
    }

    /**
     * Todos los intentos de un estudiante en un conjunto de ejercicios.
     *
     * @param  iterable<int>  $exerciseIds
     * @return Tracking[]
     */
    public function attemptsForExercises(int $userId, iterable $exerciseIds): array
    {
        $attempts = [];

        foreach ($exerciseIds as $exerciseId) {
            foreach ($this->attempts($userId, (int) $exerciseId) as $attempt) {
                $attempts[] = $attempt;
            }
        }

        return $attempts;
    }

    /**
     * @param  iterable<int>  $exerciseIds
     */
    public function secondsForExercises(int $userId, iterable $exerciseIds): int
    {
        $seconds = 0;

        foreach ($this->attemptsForExercises($userId, $exerciseIds) as $attempt) {
            $seconds += (int) $attempt->time_spent_in_seconds;
        }

        return $seconds;
    }

    /**
     * Interacciones y tiempo por opción de ayuda.
     *
     * @param  iterable<int>  $exerciseIds
     * @return array<string,array{count:int,seconds:int}>
     */
    public function helpUsageTotals(int $userId, iterable $exerciseIds): array
    {
        $totals = [];
        foreach (array_keys(self::HELP_TYPES) as $helpType) {
            $totals[$helpType] = ['count' => 0, 'seconds' => 0];
        }

        foreach ($this->attemptsForExercises($userId, $exerciseIds) as $attempt) {
            foreach ($attempt->helpUsage as $usage) {
                if (! isset($totals[$usage->help_type])) {
                    continue;
                }

                $totals[$usage->help_type]['count'] += (int) $usage->open_count;
                $totals[$usage->help_type]['seconds'] += (int) $usage->time_spent_seconds;
            }
        }

        return $totals;
    }

    /**
     * Veces que se abrió cada tipo de feedback.
     *
     * @param  iterable<int>  $exerciseIds
     * @return array<string,int>
     */
    public function feedbackTotals(int $userId, iterable $exerciseIds): array
    {
        $totals = array_fill_keys(array_keys(self::FEEDBACK_TYPES), 0);

        foreach ($this->attemptsForExercises($userId, $exerciseIds) as $attempt) {
            foreach ($attempt->feedbackUsage as $usage) {
                if (! isset($totals[$usage->feedback_type])) {
                    continue;
                }

                $totals[$usage->feedback_type] += (int) $usage->open_count;
            }
        }

        return $totals;
    }

    /**
     * Segundos acumulados por el estudiante en toda la plataforma, incluyendo
     * ejercicios de unidades que ya no están asignadas a su grupo.
     */
    public function platformSeconds(int $userId): int
    {
        if ($this->platformSeconds === null) {
            $this->platformSeconds = Tracking::whereIn('user_id', $this->userIds)
                ->selectRaw('user_id, SUM(time_spent_in_seconds) AS total_seconds')
                ->groupBy('user_id')
                ->pluck('total_seconds', 'user_id')
                ->map(fn ($seconds) => (int) $seconds)
                ->all();
        }

        return $this->platformSeconds[$userId] ?? 0;
    }

    /**
     * Una unidad está completa cuando todos los ejercicios de todos sus stages
     * (salvo voice recognition) tienen al menos un intento.
     */
    public function hasCompletedUnit(int $userId, Unit $unit): bool
    {
        if ($unit->sections->isEmpty()) {
            return false;
        }

        foreach ($unit->sections as $section) {
            $exercises = $section->exercises->filter(fn (Exercise $exercise) => $this->countsTowardsCompletion($exercise));

            if ($exercises->isEmpty()) {
                return false;
            }

            foreach ($exercises as $exercise) {
                if (! $this->hasCompleted($userId, $exercise->id)) {
                    return false;
                }
            }
        }

        return true;
    }

    // -----------------------------------------------------------------
    // Respuestas
    // -----------------------------------------------------------------

    /**
     * Respuestas del último intento de un ejercicio, listas para una celda.
     * Si el ejercicio tiene más de una pregunta, cada una se rotula "Q1:", "Q2:".
     */
    public function answersFor(int $userId, Exercise $exercise): string
    {
        $attempt = $this->latestAttempt($userId, $exercise->id);

        if ($attempt === null) {
            return '';
        }

        $byQuestion = $attempt->userResponses->groupBy('question_id');
        $questions = $exercise->questions->values();
        $multiple = $questions->count() > 1;
        $parts = [];

        foreach ($questions as $index => $question) {
            $responses = $byQuestion->get($question->id, collect())
                ->map(fn ($response) => trim((string) $response->response))
                ->filter(fn (string $response) => $response !== '')
                ->implode('; ');

            if ($responses === '') {
                continue;
            }

            $parts[] = $multiple ? sprintf('Q%d: %s', $index + 1, $responses) : $responses;
        }

        return implode(' | ', $parts);
    }

    /**
     * Respuestas de un intento concreto, para la pestaña de datos completos.
     */
    public function answersForAttempt(Tracking $attempt, Exercise $exercise): string
    {
        $questions = $exercise->questions->values();
        $byQuestion = $attempt->userResponses->groupBy('question_id');
        $multiple = $questions->count() > 1;
        $parts = [];

        foreach ($questions as $index => $question) {
            $responses = $byQuestion->get($question->id, collect())
                ->map(fn ($response) => trim((string) $response->response))
                ->filter(fn (string $response) => $response !== '')
                ->implode('; ');

            if ($responses === '') {
                continue;
            }

            $parts[] = $multiple ? sprintf('Q%d: %s', $index + 1, $responses) : $responses;
        }

        return implode(' | ', $parts);
    }

    /**
     * Intentos en los que la pregunta no quedó correcta. Una pregunta enviada
     * sin responder cuenta como incorrecta, igual que en la corrección que hace
     * la plataforma al estudiante (wrong = total - correctas).
     */
    public function incorrectAttemptsForQuestion(int $userId, Exercise $exercise, Question $question): int
    {
        $incorrect = 0;

        foreach ($this->attempts($userId, $exercise->id) as $attempt) {
            $responses = $attempt->userResponses->where('question_id', $question->id);

            $answeredCorrectly = $responses->contains(
                fn ($response) => $this->isResponseCorrect($exercise, $question, (string) $response->response)
            );

            if (! $answeredCorrectly) {
                $incorrect++;
            }
        }

        return $incorrect;
    }

    /**
     * Replica la corrección que hace el front-end (resources/js/modules/exerciseTypes.js),
     * ya que sólo se guarda el texto de la respuesta y no si estuvo correcta.
     */
    public function isResponseCorrect(Exercise $exercise, Question $question, string $response): bool
    {
        switch ((int) $exercise->exercise_type_id) {
            case 1: // Drag and drop: en el hueco de esta pregunta debe quedar su statement.
                return $this->normalize($response) === $this->normalize((string) $question->statement);

            case 2: // Multiple choice: al acertar se guarda el propio correct_answer.
                return $this->normalize($response) === $this->normalize((string) $question->correct_answer);

            case 3: // Fill in the gaps: las respuestas unidas por coma deben coincidir exactamente.
                return trim($response) === trim((string) $question->answer);

            default:
                return false;
        }
    }

    /**
     * Correctas de un ejercicio según su último intento.
     */
    public function correctAnswersFor(int $userId, Exercise $exercise): ?int
    {
        $attempt = $this->latestAttempt($userId, $exercise->id);

        return $attempt === null ? null : (int) $attempt->correct_answers;
    }

    // -----------------------------------------------------------------
    // Utilidades
    // -----------------------------------------------------------------

    /**
     * Formatea segundos como "HH:MM:SS", o "MM:SS" cuando no llega a una hora.
     */
    public function formatSeconds($seconds): string
    {
        $seconds = (int) $seconds;

        if ($seconds <= 0) {
            return '00:00';
        }

        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $rest = $seconds % 60;

        return $hours > 0
            ? sprintf('%02d:%02d:%02d', $hours, $minutes, $rest)
            : sprintf('%02d:%02d', $minutes, $rest);
    }

    /**
     * Equivalente a Utils.normalizeString del front-end: quita marcado,
     * decodifica entidades y colapsa los espacios.
     */
    protected function normalize(string $value): string
    {
        $decoded = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $decoded) ?? '');
    }

    protected function baseTitle(Exercise $exercise): string
    {
        $title = trim((string) ($exercise->title ?: $exercise->heading_title ?: ''));

        if ($title !== '') {
            return $title;
        }

        $type = optional($exercise->exerciseType)->name ?: 'Exercise';

        return $type . ' #' . $exercise->id;
    }

    /**
     * @return array<int,array<int,Tracking[]>>
     */
    protected function trackingIndex(): array
    {
        if ($this->trackingIndex !== null) {
            return $this->trackingIndex;
        }

        $exerciseIds = $this->exerciseRows()->map(fn (array $row) => $row['exercise']->id)->all();

        $index = [];

        if (! empty($exerciseIds) && ! empty($this->userIds)) {
            Tracking::with(['helpUsage', 'feedbackUsage', 'userResponses'])
                ->whereIn('user_id', $this->userIds)
                ->whereIn('exercise_id', $exerciseIds)
                ->orderBy('created_at')
                ->orderBy('id')
                ->chunk(500, function ($trackings) use (&$index) {
                    foreach ($trackings as $tracking) {
                        $index[(int) $tracking->user_id][(int) $tracking->exercise_id][] = $tracking;
                    }
                });
        }

        return $this->trackingIndex = $index;
    }
}
