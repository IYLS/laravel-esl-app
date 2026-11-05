<?php

namespace Tests\Feature;

use App\Exports\InteractionTimelineExport;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Group;
use App\Models\Question;
use App\Models\Section;
use App\Models\Tracking;
use App\Models\TrackingFeedbackUsage;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\Concerns\BuildsTrackingSchema;
use Tests\TestCase;

class InteractionTimelineExportTest extends TestCase
{
    use BuildsTrackingSchema;

    /** Ancho de cada bloque de ejercicio: 6 columnas de intento + 3 de feedback. */
    private const BLOCK = 9;

    private Group $group;
    private User $student;
    private Unit $unit;
    private Exercise $checking;
    private Exercise $cloze;
    private Question $checkingQ1;
    private Question $checkingQ2;
    private Question $clozeQ1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useInMemorySqlite();
        $this->buildTrackingSchema();
        $this->seedCurriculum();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_only_includes_checking_understanding_and_dictation_cloze_blocks()
    {
        [$titles, $headings] = $this->headerRows();

        $this->assertSame(['ESTUDIANTE', 'ID'], array_slice($headings, 0, 2));
        $this->assertCount(2 + 2 * self::BLOCK, $headings);
        $this->assertSame(
            ['EJERCICIO', 'INTERACCION', 'BUENAS', 'MALAS', 'TIEMPO', 'FECHA/HORA', 'INTERACCION FEEDBACK', 'DETALLE FEEDBACK', 'TOTAL APERTURAS'],
            array_slice($headings, 2, self::BLOCK)
        );

        // Orden de currículum: el dictation cloze (While-listening) va antes que el Verification stage.
        $this->assertSame('U1 · Dictation cloze (While-listening stage)', $titles[2]);
        $this->assertSame('U1 · Checking understanding (Verification stage)', $titles[2 + self::BLOCK]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_writes_one_row_per_student_and_attempt()
    {
        $rows = $this->dataRows();

        $this->assertSame(['ESTEBAN GIL INTENTO 1', 'ESTEBAN GIL INTENTO 2'], array_column($rows, 0));

        $checking = array_slice($rows[0], 2 + self::BLOCK, 6);
        $this->assertSame(['U1 CHECK_UND', 'USUARIO RESPONDE', 0, 2, '05:10', '01-06-2026 10:35'], $checking);

        $second = array_slice($rows[1], 2 + self::BLOCK, 6);
        $this->assertSame(['U1 CHECK_UND', 'USUARIO RESPONDE', 1, 1, '00:45', '01-06-2026 11:35'], $second);

        // El dictation cloze sólo tiene un intento: la fila 2 queda vacía en ese bloque.
        $this->assertSame('U1 DICT_CLOZE', $rows[0][2]);
        $this->assertSame(array_fill(0, self::BLOCK, null), array_slice($rows[1], 2, self::BLOCK));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function feedback_saved_with_the_next_attempt_is_shown_after_the_previous_one()
    {
        $rows = $this->dataRows();
        $feedbackOffset = 2 + self::BLOCK + 6;

        // Lo guardado en el intento 2 se abrió tras ver el resultado del intento 1.
        $this->assertSame(
            ['USUARIO ABRE FEEDBACK', 'Directive x1 (P1); Explanatory x3 (P2)', 4],
            array_slice($rows[0], $feedbackOffset, 3)
        );

        // Tras el último intento no hay envío posterior que lo registre.
        $this->assertSame([null, null, null], array_slice($rows[1], $feedbackOffset, 3));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function feedback_registered_with_the_first_attempt_is_flagged()
    {
        TrackingFeedbackUsage::create([
            'tracking_id' => Tracking::where('exercise_id', $this->cloze->id)->value('id'),
            'question_id' => $this->clozeQ1->id,
            'feedback_type' => 'Knowledge of Correct Response',
            'open_count' => 2,
        ]);

        $rows = $this->dataRows();

        $this->assertSame(
            ['USUARIO ABRE FEEDBACK', 'Knowledge of correct response x2 (P1) (antes del 1er envío)', 2],
            array_slice($rows[0], 2 + 6, 3)
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function missing_counters_are_recomputed_from_the_responses()
    {
        // El dictation cloze se guardó sin contadores: 2 de 3 espacios correctos.
        $row = $this->dataRows()[0];

        $this->assertSame([2, 1], array_slice($row, 2 + 2, 2));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function students_without_attempts_are_still_listed()
    {
        $other = $this->makeStudent('STU-2', 'Ana Rojas');

        $rows = $this->dataRows([$this->student->id, $other->id]);

        $this->assertSame('ANA ROJAS', $rows[0][0]);
        $this->assertSame('STU-2', $rows[0][1]);
        $this->assertSame('ESTEBAN GIL INTENTO 1', $rows[1][0]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function the_controller_downloads_the_group_file()
    {
        $response = $this->post(route('tracking.export_timeline'), [
            'group' => $this->group->id,
            'download_token' => 'abc123',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Interacciones', $response->headers->get('content-disposition'));
        $cookie = collect($response->headers->getCookies())
            ->first(fn ($cookie) => $cookie->getName() === 'export_download_token');
        $this->assertSame('abc123', optional($cookie)->getValue());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function a_group_without_students_redirects_with_an_error()
    {
        $empty = Group::create(['name' => 'Vacío']);

        $this->post(route('tracking.export_timeline'), ['group' => $empty->id])
            ->assertRedirect(route('tracking.index'))
            ->assertSessionHas('error');
    }

    // -----------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------

    /**
     * @return array<int,array<int,array<int,mixed>>> [nombre de pestaña => filas]
     */
    private function exportedSheets(?array $userIds = null): array
    {
        $file = tempnam(sys_get_temp_dir(), 'timeline') . '.xlsx';
        (new InteractionTimelineExport($userIds ?? [$this->student->id]))->store($file);

        $spreadsheet = IOFactory::createReader('Xlsx')->load($file);
        $sheets = [];
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $sheets[$sheet->getTitle()] = array_values($sheet->toArray(null, true, false, false));
        }

        unlink($file);

        return $sheets;
    }

    private function headerRows(): array
    {
        $rows = $this->exportedSheets()['Interacciones'];

        return [$rows[0], $rows[1]];
    }

    private function dataRows(?array $userIds = null): array
    {
        return array_slice($this->exportedSheets($userIds)['Interacciones'], 2);
    }

    private function seedCurriculum(): void
    {
        foreach ([1 => 'Drag and Drop', 2 => 'Multiple choice', 3 => 'Fill in the gaps', 4 => 'Open ended', 6 => 'Form'] as $id => $name) {
            ExerciseType::create(['id' => $id, 'name' => $name, 'underscore_name' => strtolower(str_replace(' ', '_', $name))]);
        }

        $this->group = Group::create(['name' => 'Osorno']);
        $this->student = $this->makeStudent('STU-1', 'Esteban Gil');

        $this->unit = Unit::create(['title' => 'U1: Beats move us', 'position' => 1]);
        $this->group->units()->attach($this->unit->id);

        $whileListening = $this->makeSection('While-listening stage', 1);
        $verification = $this->makeSection('Verification stage', 2);

        $this->cloze = $this->makeExercise($whileListening, 'Dictation cloze', 3, '1', 1);
        // Vocabulary practice (fill in the gaps subtipo 2) no se exporta.
        $vocabulary = $this->makeExercise($whileListening, 'Practice your vocabulary', 3, '2', 2);
        $this->checking = $this->makeExercise($verification, 'Checking understanding', 2, '3', 1);
        // Otro multiple choice del Verification stage que no es Evaluating statements.
        $predicting = $this->makeExercise($verification, 'Predicting', 2, '1', 2);

        $this->clozeQ1 = $this->makeQuestion($this->cloze, 1, null, 'music,dance,beat');
        $this->checkingQ1 = $this->makeQuestion($this->checking, 1, 'True');
        $this->checkingQ2 = $this->makeQuestion($this->checking, 2, 'False');

        // Dictation cloze sin contadores guardados: se recalculan (2 de 3).
        $cloze = $this->makeTracking($this->cloze, '2026-06-01 10:20:00', 200, 0, 0);
        $this->makeResponse($cloze, $this->clozeQ1, 'music,dance,xyz');

        $first = $this->makeTracking($this->checking, '2026-06-01 10:35:00', 310, 0, 2);
        $this->makeResponse($first, $this->checkingQ1, 'False');
        $this->makeResponse($first, $this->checkingQ2, 'True');

        $second = $this->makeTracking($this->checking, '2026-06-01 11:35:00', 45, 1, 1);
        $this->makeResponse($second, $this->checkingQ1, 'True');
        $this->makeResponse($second, $this->checkingQ2, 'True');
        TrackingFeedbackUsage::create(['tracking_id' => $second->id, 'question_id' => $this->checkingQ2->id, 'feedback_type' => 'Explanatory', 'open_count' => 3]);
        TrackingFeedbackUsage::create(['tracking_id' => $second->id, 'question_id' => $this->checkingQ1->id, 'feedback_type' => 'Directive', 'open_count' => 1]);

        // Intentos en ejercicios que no se exportan.
        $this->makeTracking($vocabulary, '2026-06-01 10:25:00', 30, 1, 0);
        $this->makeTracking($predicting, '2026-06-01 10:40:00', 30, 1, 0);
        $this->makeTracking($predicting, '2026-06-01 10:41:00', 30, 1, 0);
        $this->makeTracking($predicting, '2026-06-01 10:42:00', 30, 1, 0);
    }

    private function makeStudent(string $userId, string $name): User
    {
        $student = User::create(['user_id' => $userId, 'name' => $name, 'password' => bcrypt('secret'), 'role' => 'student']);
        $student->group_id = $this->group->id;
        $student->save();

        return $student->fresh();
    }

    private function makeSection(string $name, int $position): Section
    {
        $section = new Section([
            'name' => $name,
            'underscore_name' => strtolower(str_replace([' ', '-'], '_', $name)),
            'position' => $position,
        ]);
        $section->unit_id = $this->unit->id;
        $section->save();

        return $section;
    }

    private function makeExercise(Section $section, string $title, int $typeId, string $subtype, int $position): Exercise
    {
        $exercise = new Exercise(['title' => $title, 'position' => $position, 'category' => 'comprehension']);
        $exercise->subtype = $subtype;
        $exercise->section_id = $section->id;
        $exercise->exercise_type_id = $typeId;
        $exercise->save();

        return $exercise;
    }

    private function makeQuestion(Exercise $exercise, int $position, ?string $correct = null, ?string $answer = null): Question
    {
        $question = new Question(['statement' => 'Q' . $position, 'position' => $position, 'correct_answer' => $correct]);
        $question->answer = $answer;
        $question->exercise_id = $exercise->id;
        $question->save();

        return $question;
    }

    private function makeTracking(Exercise $exercise, string $at, int $seconds, int $correct, int $wrong): Tracking
    {
        $tracking = new Tracking;
        $tracking->intent_number = (string) (Tracking::where('exercise_id', $exercise->id)->where('user_id', $this->student->id)->count() + 1);
        $tracking->time_spent_in_seconds = $seconds;
        $tracking->correct_answers = (string) $correct;
        $tracking->wrong_answers = (string) $wrong;
        $tracking->exercise_id = $exercise->id;
        $tracking->user_id = $this->student->id;
        $tracking->created_at = $at;
        $tracking->updated_at = $at;
        $tracking->save();

        return $tracking;
    }

    private function makeResponse(Tracking $tracking, Question $question, string $response): void
    {
        $userResponse = new UserResponse(['response' => $response]);
        $userResponse->question_id = $question->id;
        $userResponse->tracking_id = $tracking->id;
        $userResponse->save();
    }
}
