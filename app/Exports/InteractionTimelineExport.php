<?php

namespace App\Exports;

use App\Models\Exercise;
use App\Models\Question;
use App\Models\Tracking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

/**
 * Export "línea de tiempo de interacciones": una fila por estudiante e intento
 * (NOMBRE INTENTO n) y, por cada ejercicio Checking understanding / Dictation
 * cloze del grupo, un bloque con la respuesta del intento (buenas, malas,
 * tiempo, hora) seguido de un bloque con el feedback que abrió después.
 *
 * Todo se calcula al momento de exportar a partir de tracking, user_responses
 * y tracking_feedback_usage; no se usa ninguna tabla intermedia.
 *
 * Sobre el feedback: los contadores se acumulan en el formulario del ejercicio
 * y se guardan con el envío SIGUIENTE, así que lo registrado en el intento n+1
 * corresponde al feedback abierto tras ver el resultado del intento n. Lo que
 * se abre después del último envío nunca llega a guardarse. La tabla no guarda
 * la hora de cada apertura, sólo cuántas veces se abrió cada tipo por pregunta.
 */
class InteractionTimelineExport
{
    /** Checking understanding: multiple choice "Evaluating statements" del Verification stage. */
    public const CHECKING_UNDERSTANDING_TYPE_ID = 2;
    public const CHECKING_UNDERSTANDING_SUBTYPE = '3';
    public const VERIFICATION_STAGE = 'verification_stage';

    /** Dictation cloze: fill in the gaps con subtipo 1. */
    public const DICTATION_CLOZE_TYPE_ID = 3;
    public const DICTATION_CLOZE_SUBTYPE = '1';

    public const LABEL_CHECKING_UNDERSTANDING = 'CHECK_UND';
    public const LABEL_DICTATION_CLOZE = 'DICT_CLOZE';

    public const INTERACTION_RESPONSE = 'USUARIO RESPONDE';
    public const INTERACTION_FEEDBACK = 'USUARIO ABRE FEEDBACK';

    /** Columnas de cada bloque, en orden. */
    public const ATTEMPT_COLUMNS = ['EJERCICIO', 'INTERACCION', 'BUENAS', 'MALAS', 'TIEMPO', 'FECHA/HORA'];
    public const FEEDBACK_COLUMNS = ['INTERACCION FEEDBACK', 'DETALLE FEEDBACK', 'TOTAL APERTURAS'];

    /** Colores de cabecera alternados por ejercicio, como en el ejemplo. */
    private const BLOCK_COLORS = ['4A86E8', 'FFE599'];

    private const MAX_CELL_LENGTH = 32767;

    /** @var int[] */
    protected array $userIds;

    protected TrackingExportContext $context;

    /** @var array<int,array{exercise:Exercise,label:string,title:string,questionLabels:array<int,string>}>|null */
    protected ?array $targets = null;

    /**
     * user_id => exercise_id => intentos en orden cronológico.
     *
     * @var array<int,array<int,array<int,array{createdAt:?Carbon,seconds:int,correct:int,wrong:int,feedback:array<int,array<string,int>>}>>>|null
     */
    protected ?array $attempts = null;

    public function __construct(array $userIds)
    {
        $this->userIds = array_values(array_unique(array_map('intval', $userIds)));
        $this->context = new TrackingExportContext($this->userIds);
    }

    // -----------------------------------------------------------------
    // Escritura del archivo
    // -----------------------------------------------------------------

    /**
     * Genera el archivo en una ruta temporal y lo devuelve como descarga; el
     * archivo se borra después de enviarlo.
     */
    public function download(string $fileName): BinaryFileResponse
    {
        $path = tempnam(sys_get_temp_dir(), 'timeline-export-');

        try {
            $this->store($path);
        } catch (Throwable $e) {
            @unlink($path);

            throw $e;
        }

        return response()->download($path, $fileName)->deleteFileAfterSend();
    }

    public function store(string $path): void
    {
        $writer = new Writer();
        $writer->openToFile($path);

        try {
            $writer->getCurrentSheet()->setName('Interacciones');
            $this->writeTimelineSheet($writer);

            $writer->addNewSheetAndMakeItCurrent()->setName('Notas');
            $bold = (new Style())->setFontBold();
            $writer->addRow(Row::fromValues(['Notas sobre los datos'], $bold));
            foreach ($this->notes() as $note) {
                $writer->addRow(Row::fromValues([$note]));
            }
        } finally {
            $writer->close();
        }
    }

    protected function writeTimelineSheet(Writer $writer): void
    {
        $targets = $this->targets();

        // Fila 1: nombre del ejercicio al inicio de cada bloque.
        $titleCells = [Cell::fromValue('', $this->headerStyle(null)), Cell::fromValue('', $this->headerStyle(null))];
        // Fila 2: nombres de columna.
        $headingCells = [Cell::fromValue('ESTUDIANTE', $this->headerStyle(null)), Cell::fromValue('ID', $this->headerStyle(null))];

        foreach (array_values($targets) as $index => $target) {
            $style = $this->headerStyle(self::BLOCK_COLORS[$index % 2]);
            $columns = array_merge(self::ATTEMPT_COLUMNS, self::FEEDBACK_COLUMNS);

            foreach ($columns as $position => $heading) {
                $titleCells[] = Cell::fromValue($position === 0 ? $target['title'] : '', $style);
                $headingCells[] = Cell::fromValue($heading, $style);
            }
        }

        $writer->addRow(new Row($titleCells));
        $writer->addRow(new Row($headingCells));

        foreach ($this->rows() as $values) {
            $writer->addRow(Row::fromValues(array_map([$this, 'cellValue'], $values)));
        }
    }

    /**
     * Filas de datos (sin cabeceras): una por estudiante e intento.
     *
     * @return \Generator<int,array<int,mixed>>
     */
    public function rows(): \Generator
    {
        $targets = $this->targets();
        $attempts = $this->attempts();
        $blockWidth = count(self::ATTEMPT_COLUMNS) + count(self::FEEDBACK_COLUMNS);

        foreach ($this->context->users() as $user) {
            $userAttempts = $attempts[$user->id] ?? [];
            $maxAttempts = 0;
            foreach ($targets as $exerciseId => $target) {
                $maxAttempts = max($maxAttempts, count($userAttempts[$exerciseId] ?? []));
            }

            // Los estudiantes sin intentos igual aparecen en la lista.
            if ($maxAttempts === 0) {
                yield array_merge(
                    [$this->studentName($user), $user->user_id],
                    array_fill(0, $blockWidth * count($targets), '')
                );
                continue;
            }

            for ($n = 1; $n <= $maxAttempts; $n++) {
                $row = [$this->studentName($user) . ' INTENTO ' . $n, $user->user_id];

                foreach ($targets as $exerciseId => $target) {
                    $row = array_merge($row, $this->block($target, $userAttempts[$exerciseId] ?? [], $n));
                }

                yield $row;
            }
        }
    }

    /**
     * Celdas de un ejercicio para el intento n: bloque de respuesta + bloque de feedback.
     *
     * @param  array<int,array<string,mixed>>  $attempts
     * @return array<int,mixed>
     */
    protected function block(array $target, array $attempts, int $n): array
    {
        $attempt = $attempts[$n - 1] ?? null;

        if ($attempt === null) {
            return array_fill(0, count(self::ATTEMPT_COLUMNS) + count(self::FEEDBACK_COLUMNS), '');
        }

        $cells = [
            $target['label'],
            self::INTERACTION_RESPONSE,
            $attempt['correct'],
            $attempt['wrong'],
            $this->context->formatSeconds($attempt['seconds']),
            $attempt['createdAt'] ? $attempt['createdAt']->format('d-m-Y H:i') : '',
        ];

        // Feedback abierto después de este intento = lo registrado con el intento siguiente.
        $parts = [];
        $total = 0;

        if ($n === 1) {
            [$detail, $count] = $this->describeFeedback($target, $attempt['feedback']);
            if ($count > 0) {
                $parts[] = $detail . ' (antes del 1er envío)';
                $total += $count;
            }
        }

        $next = $attempts[$n] ?? null;
        if ($next !== null) {
            [$detail, $count] = $this->describeFeedback($target, $next['feedback']);
            if ($count > 0) {
                $parts[] = $detail;
                $total += $count;
            }
        }

        $cells[] = $total > 0 ? self::INTERACTION_FEEDBACK : '';
        $cells[] = implode('; ', $parts);
        $cells[] = $total > 0 ? $total : ($next !== null ? 0 : '');

        return $cells;
    }

    /**
     * "Directive x2 (P3); Explanatory x1 (P5)" y el total de aperturas.
     *
     * @param  array<int,array<string,int>>  $feedback  question_id => feedback_type => veces
     * @return array{0:string,1:int}
     */
    protected function describeFeedback(array $target, array $feedback): array
    {
        $parts = [];
        $total = 0;

        // Orden de las preguntas dentro del ejercicio y luego por tipo de feedback.
        $order = array_flip(array_keys($target['questionLabels']));
        uksort($feedback, fn ($a, $b) => ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX) ?: $a <=> $b);

        foreach ($feedback as $questionId => $types) {
            $questionLabel = $target['questionLabels'][$questionId] ?? ($questionId > 0 ? 'Q#' . $questionId : 'sin pregunta');

            foreach ($this->sortFeedbackTypes($types) as $type => $count) {
                if ($count <= 0) {
                    continue;
                }

                $typeLabel = TrackingExportContext::FEEDBACK_TYPES[$type] ?? $type;
                $parts[] = "{$typeLabel} x{$count} ({$questionLabel})";
                $total += $count;
            }
        }

        return [implode('; ', $parts), $total];
    }

    /**
     * @param  array<string,int>  $types
     * @return array<string,int>
     */
    protected function sortFeedbackTypes(array $types): array
    {
        $order = array_flip(['Directive', 'Explanatory', 'Elaborative', 'Knowledge of Correct Response']);
        uksort($types, fn ($a, $b) => ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX) ?: strcmp($a, $b));

        return $types;
    }

    /**
     * @return string[]
     */
    public function notes(): array
    {
        return [
            'Cada fila corresponde a un estudiante y a su intento n en cada ejercicio (intento 1, 2, ...), ordenados por fecha de envío.',
            'Checking understanding (' . self::LABEL_CHECKING_UNDERSTANDING . '): ejercicios multiple choice "Evaluating statements" del Verification stage.',
            'Dictation cloze (' . self::LABEL_DICTATION_CLOZE . '): ejercicios fill in the gaps de subtipo Dictation cloze.',
            'BUENAS / MALAS: respuestas correctas e incorrectas registradas en el intento. En Dictation cloze se cuentan por espacio a completar.',
            'FECHA/HORA: momento en que el estudiante envió el intento. TIEMPO: tiempo dedicado al intento (MM:SS).',
            'Feedback: la plataforma guarda cuántas veces se abrió cada tipo de feedback por pregunta, pero no la hora de cada apertura.',
            'El feedback abierto tras ver el resultado del intento n se guarda junto con el envío n+1; por eso se muestra en la fila del intento n.',
            'El feedback abierto después del último envío de un ejercicio no queda registrado. TOTAL APERTURAS vacío = no hubo un envío posterior que lo registrara.',
            'Pn = número de la pregunta dentro del ejercicio.',
        ];
    }

    // -----------------------------------------------------------------
    // Datos
    // -----------------------------------------------------------------

    /**
     * Ejercicios objetivo de las unidades del grupo, en orden de currículum.
     *
     * @return array<int,array{exercise:Exercise,label:string,title:string,questionLabels:array<int,string>}>
     */
    public function targets(): array
    {
        if ($this->targets !== null) {
            return $this->targets;
        }

        $targets = [];
        $seen = [];

        foreach ($this->context->exerciseRows() as $row) {
            $exercise = $row['exercise'];
            $kind = $this->kindOf($exercise, $row['section']->underscore_name);

            if ($kind === null) {
                continue;
            }

            $unitLabel = $this->context->unitShortLabel($row['unit']);
            $key = $unitLabel . ' ' . $kind;
            $seen[$key] = ($seen[$key] ?? 0) + 1;

            $targets[$exercise->id] = [
                'exercise' => $exercise,
                'key' => $key,
                'number' => $seen[$key],
                'title' => $unitLabel . ' · ' . $this->context->exerciseTitle($exercise)
                    . ' (' . $this->context->stageFullName($row['section']) . ')',
                'questionLabels' => $this->questionLabels($exercise->questions),
            ];
        }

        // Sólo se numeran los que se repiten dentro de una misma unidad.
        foreach ($targets as $exerciseId => $target) {
            $targets[$exerciseId]['label'] = $seen[$target['key']] > 1
                ? $target['key'] . ' ' . $target['number']
                : $target['key'];
        }

        return $this->targets = $targets;
    }

    protected function kindOf(Exercise $exercise, ?string $sectionUnderscoreName): ?string
    {
        $typeId = (int) $exercise->exercise_type_id;
        $subtype = trim((string) $exercise->subtype);

        if ($typeId === self::CHECKING_UNDERSTANDING_TYPE_ID
            && $subtype === self::CHECKING_UNDERSTANDING_SUBTYPE
            && $sectionUnderscoreName === self::VERIFICATION_STAGE) {
            return self::LABEL_CHECKING_UNDERSTANDING;
        }

        if ($typeId === self::DICTATION_CLOZE_TYPE_ID && $subtype === self::DICTATION_CLOZE_SUBTYPE) {
            return self::LABEL_DICTATION_CLOZE;
        }

        return null;
    }

    /**
     * question_id => "P1", "P2"... según el orden de las preguntas en el ejercicio.
     *
     * @return array<int,string>
     */
    protected function questionLabels(Collection $questions): array
    {
        $labels = [];
        foreach ($questions->values() as $index => $question) {
            $labels[(int) $question->id] = 'P' . ($index + 1);
        }

        return $labels;
    }

    /**
     * Intentos de los estudiantes en los ejercicios objetivo, en una sola
     * consulta por bloques y guardando sólo lo necesario.
     */
    protected function attempts(): array
    {
        if ($this->attempts !== null) {
            return $this->attempts;
        }

        $targets = $this->targets();
        $index = [];

        if (! empty($targets) && ! empty($this->userIds)) {
            Tracking::select([
                'id', 'user_id', 'exercise_id', 'created_at', 'time_spent_in_seconds',
                'correct_answers', 'wrong_answers',
            ])
                ->with([
                    'feedbackUsage:id,tracking_id,question_id,feedback_type,open_count',
                    'userResponses:id,tracking_id,question_id,response',
                ])
                ->whereIn('user_id', $this->userIds)
                ->whereIn('exercise_id', array_keys($targets))
                ->orderBy('created_at')
                ->orderBy('id')
                ->chunk(500, function ($trackings) use (&$index, $targets) {
                    foreach ($trackings as $tracking) {
                        $exercise = $targets[(int) $tracking->exercise_id]['exercise'];
                        $index[(int) $tracking->user_id][(int) $tracking->exercise_id][] = $this->summarize($tracking, $exercise);
                    }
                });
        }

        return $this->attempts = $index;
    }

    /**
     * @return array{createdAt:?Carbon,seconds:int,correct:int,wrong:int,feedback:array<int,array<string,int>>}
     */
    protected function summarize(Tracking $tracking, Exercise $exercise): array
    {
        $correct = (int) $tracking->correct_answers;
        $wrong = (int) $tracking->wrong_answers;

        // Respaldo: si el envío no trajo contadores pero sí respuestas, se corrige aquí.
        if ($correct === 0 && $wrong === 0 && $tracking->userResponses->isNotEmpty()) {
            [$correct, $wrong] = $this->gradeResponses($exercise, $tracking->userResponses);
        }

        $feedback = [];
        foreach ($tracking->feedbackUsage as $usage) {
            $questionId = (int) $usage->question_id;
            $type = (string) $usage->feedback_type;
            $feedback[$questionId][$type] = ($feedback[$questionId][$type] ?? 0) + (int) $usage->open_count;
        }

        return [
            'createdAt' => $tracking->created_at,
            'seconds' => (int) $tracking->time_spent_in_seconds,
            'correct' => $correct,
            'wrong' => $wrong,
            'feedback' => $feedback,
        ];
    }

    /**
     * Replica la corrección del front-end (resources/js/modules/exerciseTypes.js).
     *
     * @return array{0:int,1:int}
     */
    protected function gradeResponses(Exercise $exercise, Collection $responses): array
    {
        $byQuestion = $responses->keyBy(fn ($response) => (int) $response->question_id);
        $correct = 0;
        $wrong = 0;

        foreach ($exercise->questions as $question) {
            /** @var Question $question */
            $response = $byQuestion->get((int) $question->id);

            if ((int) $exercise->exercise_type_id === self::DICTATION_CLOZE_TYPE_ID) {
                // Dictation cloze: cada espacio cuenta; es correcto si no está
                // vacío y aparece dentro de la respuesta esperada.
                $answer = (string) $question->answer;
                foreach (explode(',', (string) optional($response)->response) as $gap) {
                    if ($gap !== '' && str_contains($answer, $gap)) {
                        $correct++;
                    } else {
                        $wrong++;
                    }
                }
                continue;
            }

            if (! $this->context->isGradableQuestion($exercise, $question)) {
                continue;
            }

            if ($response !== null && $this->context->isResponseCorrect($exercise, $question, (string) $response->response)) {
                $correct++;
            } else {
                $wrong++;
            }
        }

        return [$correct, $wrong];
    }

    // -----------------------------------------------------------------
    // Utilidades
    // -----------------------------------------------------------------

    protected function studentName(User $user): string
    {
        return mb_strtoupper(trim((string) $user->name));
    }

    protected function headerStyle(?string $color): Style
    {
        $style = (new Style())->setFontBold();

        return $color !== null ? $style->setBackgroundColor($color) : $style;
    }

    /**
     * Mismo criterio que ExportTracking: textos numéricos como número y textos
     * largos recortados al máximo de Excel.
     */
    private function cellValue($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        if (preg_match('/^-?(0|[1-9]\d*)(\.\d+)?$/', $value) && strlen($value) <= 15) {
            return str_contains($value, '.') ? (float) $value : (int) $value;
        }

        return mb_strlen($value) > self::MAX_CELL_LENGTH
            ? mb_substr($value, 0, self::MAX_CELL_LENGTH)
            : $value;
    }
}
