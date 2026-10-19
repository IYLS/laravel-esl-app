<?php

namespace Tests\Feature;

use App\Exports\ExportTracking;
use App\Models\Comment;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Group;
use App\Models\Question;
use App\Models\Section;
use App\Models\Tracking;
use App\Models\TrackingFeedbackUsage;
use App\Models\TrackingHelpUsage;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserResponse;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

class ExportTrackingTest extends TestCase
{
    private Group $group;
    private User $student;
    private Unit $unit;
    private Section $planning;
    private Section $verification;
    private Section $reflection;
    private Exercise $organization;
    private Exercise $evaluatingStatements;
    private Exercise $enjoyment;

    protected function setUp(): void
    {
        parent::setUp();

        // Varias migraciones del proyecto usan DDL exclusivo de PostgreSQL, así
        // que para estas pruebas se arma en SQLite sólo el esquema que toca el
        // export en lugar de correr la cadena completa de migraciones.
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        $this->buildSchema();
        $this->seedCurriculum();
    }

    /** @test */
    public function it_builds_one_sheet_per_indicator_with_the_reference_titles()
    {
        $sheets = $this->exportedSheets();

        $this->assertSame([
            'Datos completos',
            'Units completed',
            'Platform time',
            'Unit (time)',
            'Stages (completed exercises)',
            'Completed exercises',
            'Stages (time of interaction)',
            'Type of exercises (time)',
            'Reflection',
            'Feedback',
            'Help options (interactions)',
            'Help options (time)',
            'Forum',
            'Number of tries per exercise',
            'Number of incorrect (question)',
            'Number of correct (exercise)',
            'Answers',
        ], array_keys($sheets));
    }

    /** @test */
    public function every_sheet_title_fits_the_excel_limit()
    {
        foreach (array_keys($this->exportedSheets()) as $title) {
            $this->assertLessThanOrEqual(31, mb_strlen($title), "La pestaña '{$title}' excede el límite de Excel.");
        }
    }

    /** @test */
    public function student_rows_start_with_id_and_name()
    {
        $sheets = $this->exportedSheets();

        foreach (['Units completed', 'Unit (time)', 'Reflection', 'Answers'] as $title) {
            $this->assertSame(['ID', 'Nombre'], array_slice($sheets[$title][0], 0, 2));
            $this->assertSame($this->student->user_id, $sheets[$title][1][0]);
            $this->assertSame($this->student->name, $sheets[$title][1][1]);
        }
    }

    /** @test */
    public function it_counts_completed_units_and_totals_platform_time()
    {
        $sheets = $this->exportedSheets();

        // Falta un ejercicio por completar, así que la unidad no está completa.
        $this->assertSame('Numero de unidades completadas', $sheets['Units completed'][0][2]);
        $this->assertSame(0, (int) $sheets['Units completed'][1][2]);

        // 125 + 310 + 45 + 60 = 540 segundos.
        $this->assertSame('09:00', $sheets['Platform time'][1][2]);
        $this->assertSame('09:00', $sheets['Unit (time)'][1][2]);
    }

    /** @test */
    public function it_labels_stage_columns_per_unit_and_counts_completed_exercises()
    {
        $sheets = $this->exportedSheets();
        $headings = $sheets['Stages (completed exercises)'][0];

        $this->assertSame(
            ['ID', 'Nombre', 'Unit 1: Planning', 'Unit 1: Verification', 'Unit 1: Reflection'],
            $headings
        );

        // Verification tiene 2 ejercicios y sólo "Evaluating statements" fue completado.
        $this->assertSame(1, (int) $sheets['Stages (completed exercises)'][1][2]);
        $this->assertSame(1, (int) $sheets['Stages (completed exercises)'][1][3]);
        $this->assertSame(1, (int) $sheets['Stages (completed exercises)'][1][4]);
    }

    /** @test */
    public function it_marks_each_exercise_as_completed_or_not()
    {
        $row = $this->headedRow('Completed exercises');

        $this->assertSame('Yes', $row['U1 - Planning stage - Organization']);
        $this->assertSame('No', $row['U1 - Planning stage - Resources 1']);
        $this->assertSame('No', $row['U1 - Planning stage - Resources 2']);
        $this->assertSame('Yes', $row['U1 - Verification stage - Evaluating statements']);
    }

    /** @test */
    public function it_numbers_exercises_that_share_a_title_inside_a_stage()
    {
        $headings = $this->exportedSheets()['Number of tries per exercise'][0];

        $this->assertContains('U1 - PS - Resources 1 (E)', $headings);
        $this->assertContains('U1 - PS - Resources 2 (E)', $headings);
    }

    /** @test */
    public function it_marks_the_category_of_each_exercise_in_the_tries_sheet()
    {
        $row = $this->headedRow('Number of tries per exercise');

        // Organization es metacognition y Enjoyment engagement.
        $this->assertSame(1, (int) $row['U1 - PS - Organization (M)']);
        $this->assertSame(2, (int) $row['U1 - VS - Evaluating statements']);
        $this->assertSame(1, (int) $row['U1 - RS - Enjoyment (E)']);
    }

    /** @test */
    public function it_splits_time_by_stage_and_by_exercise_category()
    {
        $stages = $this->headedRow('Stages (time of interaction)');
        $categories = $this->headedRow('Type of exercises (time)');

        $this->assertSame('02:05', $stages['Unit 1: Planning']);
        $this->assertSame('05:55', $stages['Unit 1: Verification']);
        $this->assertSame('01:00', $stages['Unit 1: Reflection']);

        $this->assertSame('05:55', $categories['U1: Comprehension']);
        $this->assertSame('02:05', $categories['U1: Metacognition']);
        $this->assertSame('01:00', $categories['U1: Engagement']);
    }

    /** @test */
    public function it_reports_help_option_interactions_and_time_per_unit()
    {
        $interactions = $this->headedRow('Help options (interactions)');
        $time = $this->headedRow('Help options (time)');

        $this->assertSame(7, (int) $interactions['U1: Transcript Interactions']);
        $this->assertSame(2, (int) $interactions['U1: Glossary Interactions']);
        // Un cero debe quedar escrito como 0 y no como celda vacía.
        $this->assertSame(0, $interactions['U1: Dictionary Interactions']);

        $this->assertSame('02:49', $time['U1: Transcript Time Spent']);
        $this->assertSame('00:44', $time['U1: Glossary Time Spent']);
        $this->assertSame('00:00', $time['U1: Dictionary Time Spent']);
    }

    /** @test */
    public function it_counts_feedback_openings_per_type()
    {
        $row = $this->headedRow('Feedback');

        $this->assertSame(3, (int) $row['U1: Feedback: Explanatory']);
        $this->assertSame(1, (int) $row['U1: Feedback: Directive']);
        $this->assertSame(0, $row['U1: Feedback: Elaborative']);
        $this->assertSame(2, (int) $row['U1: Feedback: Knowledge of correct response']);
    }

    /** @test */
    public function it_counts_incorrect_tries_per_question()
    {
        $row = $this->headedRow('Number of incorrect (question)');

        // Q1: falló el primer intento y acertó el segundo.
        $this->assertSame(1, (int) $row['U1 - VS - Evaluating statements - Q1']);
        // Q2: falló los dos intentos.
        $this->assertSame(2, (int) $row['U1 - VS - Evaluating statements - Q2']);
    }

    /** @test */
    public function it_reports_correct_answers_from_the_latest_attempt()
    {
        $row = $this->headedRow('Number of correct (exercise)');

        $this->assertSame(1, (int) $row['U1: Evaluating statements']);
    }

    /** @test */
    public function only_auto_graded_comprehension_exercises_get_correctness_columns()
    {
        $headings = $this->exportedSheets()['Number of correct (exercise)'][0];

        $this->assertContains('U1: Evaluating statements', $headings);
        $this->assertNotContains('U1: Organization', $headings);
        $this->assertNotContains('U1: Enjoyment', $headings);
    }

    /** @test */
    public function personal_response_questions_are_left_out_of_the_correctness_sheets()
    {
        $sheets = $this->exportedSheets();

        $this->assertNotContains(
            'U1 - VS - What do you think? - Q1',
            $sheets['Number of incorrect (question)'][0]
        );
        $this->assertNotContains('U1: What do you think?', $sheets['Number of correct (exercise)'][0]);

        // Pero sí aparece donde corresponde: intentos y completados.
        $this->assertContains('U1 - VS - What do you think?', $sheets['Number of tries per exercise'][0]);
    }

    /** @test */
    public function it_lists_reflection_answers_and_open_answers()
    {
        $reflection = $this->headedRow('Reflection');
        $answers = $this->headedRow('Answers');

        // Una respuesta que es sólo un número queda como celda numérica en Excel.
        $this->assertSame(6, $reflection['U1: Enjoyment']);
        $this->assertSame(6, $answers['U1 RS: Enjoyment']);
        $this->assertSame('Q1: Listen for names | Q2: Take notes', $answers['U1 PS: Organization']);

        // Los ejercicios corregibles no van en la pestaña de respuestas.
        $this->assertArrayNotHasKey('U1 VS: Evaluating statements', $answers);
    }

    /** @test */
    public function it_lists_forum_comments_with_a_real_timestamp()
    {
        $sheets = $this->exportedSheets();

        $this->assertSame(['ID', 'Nombre', 'Title', 'Comment', 'Hora'], $sheets['Forum'][0]);
        $this->assertSame('Mi opinión', $sheets['Forum'][1][2]);
        $this->assertSame('Me gustó la unidad', $sheets['Forum'][1][3]);
        $this->assertSame('02-06-2026 10:30:00', $sheets['Forum'][1][4]);
    }

    /** @test */
    public function the_raw_sheet_has_one_row_per_attempt()
    {
        $sheets = $this->exportedSheets();
        $rows = $sheets['Datos completos'];

        $this->assertSame([
            'Colegio',
            'Estudiante',
            'ID',
            'Unidad',
            'Stage',
            'Ejercicio',
            'Opciones de ayudas',
            'Tiempo',
            'Correctas',
            'Number tries',
            'Incorrectas',
            'Respuestas',
        ], $rows[0]);

        // 1 Organization + 2 Evaluating statements + 1 Enjoyment.
        $this->assertCount(4, array_slice($rows, 1));

        $organization = $rows[1];
        $this->assertSame('Osorno', $organization[0]);
        $this->assertSame('Esteban Gil', $organization[1]);
        $this->assertSame('U1', $organization[3]);
        $this->assertSame('Planning', $organization[4]);
        $this->assertSame('Organization', $organization[5]);
        $this->assertSame('Transcript, Glossary', $organization[6]);
        $this->assertSame('02:05', $organization[7]);
        $this->assertSame('Q1: Listen for names | Q2: Take notes', $organization[11]);
    }

    /** @test */
    public function it_exports_every_student_of_a_group()
    {
        $other = $this->makeStudent('STU-2', 'Ana Rojas');

        $sheets = $this->exportedSheets([$this->student->id, $other->id]);
        $rows = array_slice($sheets['Units completed'], 1);

        // Ordenados por nombre.
        $this->assertSame(['Ana Rojas', 'Esteban Gil'], array_column($rows, 1));
        $this->assertSame(0, (int) $rows[0][2]);
    }

    /** @test */
    public function a_student_without_tracking_gets_empty_values_instead_of_errors()
    {
        $other = $this->makeStudent('STU-3', 'Sin Datos');

        $sheets = $this->exportedSheets([$other->id]);

        $this->assertSame('00:00', $sheets['Platform time'][1][2]);
        $this->assertSame(0, (int) $sheets['Units completed'][1][2]);
        $this->assertCount(1, $sheets['Datos completos']); // sólo la cabecera
        $this->assertCount(1, $sheets['Forum']);
    }

    /** @test */
    public function unit_columns_follow_curriculum_position_not_insertion_order()
    {
        // Se crean desordenadas y con una sin posición definida.
        $third = Unit::create(['title' => 'U3: Passion for music', 'position' => 3]);
        $second = Unit::create(['title' => 'U2: Feel every note', 'position' => 2]);
        $noPosition = Unit::create(['title' => 'U9: Sin posicion', 'position' => null]);

        foreach ([$third, $second, $noPosition] as $unit) {
            $this->group->units()->attach($unit->id);
            $section = new Section(['name' => 'Verification stage', 'position' => 1]);
            $section->unit_id = $unit->id;
            $section->save();
            $this->makeExercise($section, 'Checking understanding', 2, 'comprehension', 1);
        }

        $headings = $this->exportedSheets()['Unit (time)'][0];

        // U1, U2, U3 por posición; la unidad sin posición queda al final.
        $this->assertSame(['ID', 'Nombre', 'U1', 'U2', 'U3', 'U9'], $headings);
    }

    /** @test */
    public function stage_columns_follow_position_within_each_unit()
    {
        $headings = $this->exportedSheets()['Stages (time of interaction)'][0];

        // Planning (1), Verification (2), Reflection (3), pese a crearse en ese orden.
        $this->assertSame(
            ['ID', 'Nombre', 'Unit 1: Planning', 'Unit 1: Verification', 'Unit 1: Reflection'],
            $headings
        );
    }

    /** @test */
    public function the_download_returns_the_form_token_so_the_loading_screen_can_close()
    {
        $response = $this->post(route('tracking.export_data'), [
            'student' => $this->student->id,
            'download_token' => 'abc123',
        ]);

        $response->assertOk();
        // Sin encriptar: el JS de la pantalla de carga la compara con el token.
        $cookie = collect($response->headers->getCookies())
            ->first(fn ($cookie) => $cookie->getName() === 'export_download_token');
        $this->assertNotNull($cookie);
        $this->assertSame('abc123', $cookie->getValue());
        $this->assertFalse($cookie->isHttpOnly());
    }

    /** @test */
    public function an_invalid_download_token_is_ignored()
    {
        $response = $this->post(route('tracking.export_data'), [
            'student' => $this->student->id,
            'download_token' => '<script>',
        ]);

        $response->assertOk();
        $response->assertCookieMissing('export_download_token');
    }

    // -----------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------

    /**
     * Genera el archivo y lo lee de vuelta como [título de pestaña => filas].
     *
     * @return array<string,array<int,array<int,mixed>>>
     */
    private function exportedSheets(?array $userIds = null): array
    {
        $file = tempnam(sys_get_temp_dir(), 'export') . '.xlsx';
        (new ExportTracking($userIds ?? [$this->student->id], 'group'))->store($file);

        $spreadsheet = IOFactory::createReader('Xlsx')->load($file);
        $sheets = [];

        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $sheets[$sheet->getTitle()] = array_values($sheet->toArray(null, true, false, false));
        }

        unlink($file);

        return $sheets;
    }

    /**
     * La fila del único estudiante de una pestaña, indexada por cabecera.
     *
     * @return array<string,mixed>
     */
    private function headedRow(string $sheetTitle): array
    {
        $sheet = $this->exportedSheets()[$sheetTitle];

        return array_combine($sheet[0], $sheet[1]);
    }

    /**
     * Esquema mínimo que necesita el export, con los mismos nombres de columna
     * que las migraciones del proyecto.
     */
    private function buildSchema(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('leaderboard_enabled')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('unit_group', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('group_id');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('password');
            $table->string('role')->nullable();
            $table->string('email')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('language')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('activated')->default(true);
            $table->integer('group_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('underscore_name')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('position')->nullable();
            $table->integer('unit_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exercise_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('underscore_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('heading_title')->nullable();
            $table->string('category')->nullable();
            $table->string('subtype')->nullable();
            $table->integer('position')->nullable();
            $table->integer('section_id');
            $table->integer('exercise_type_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('statement')->nullable();
            $table->text('answer')->nullable();
            $table->string('correct_answer')->nullable();
            $table->boolean('personal_response')->default(false);
            $table->boolean('exclusive_responses')->default(false);
            $table->integer('position')->nullable();
            $table->integer('exercise_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->string('intent_number');
            $table->integer('time_spent_in_seconds')->default(0);
            $table->string('correct_answers')->nullable();
            $table->string('wrong_answers')->nullable();
            $table->integer('exercise_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_responses', function (Blueprint $table) {
            $table->id();
            $table->text('response');
            $table->integer('question_id');
            $table->integer('tracking_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tracking_help_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('tracking_id');
            $table->string('help_type');
            $table->integer('open_count')->default(0);
            $table->integer('time_spent_seconds')->default(0);
            $table->timestamps();
        });

        Schema::create('tracking_feedback_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('tracking_id');
            $table->integer('question_id')->nullable();
            $table->string('feedback_type');
            $table->integer('open_count')->default(0);
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('content');
            $table->integer('user_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    private function seedCurriculum(): void
    {
        foreach ([
            1 => 'Drag and Drop',
            2 => 'Multiple choice',
            3 => 'Fill in the gaps',
            4 => 'Open ended',
            5 => 'Voice Recognition',
            6 => 'Form',
            7 => 'Poll',
        ] as $id => $name) {
            ExerciseType::create([
                'id' => $id,
                'name' => $name,
                'underscore_name' => strtolower(str_replace(' ', '_', $name)),
            ]);
        }

        $this->group = Group::create(['name' => 'Osorno']);

        $this->student = $this->makeStudent('STU-1', 'Esteban Gil');

        $this->unit = Unit::create(['title' => 'U1: Beats move us', 'position' => 1]);
        $this->group->units()->attach($this->unit->id);

        $this->planning = $this->makeSection('Planning stage', 1);
        $this->verification = $this->makeSection('Verification stage', 2);
        $this->reflection = $this->makeSection('Reflection stage', 3);

        // Planning: una metacognición y dos ejercicios con el mismo título.
        $this->organization = $this->makeExercise($this->planning, 'Organization', 6, 'metacognition', 1);
        $this->makeExercise($this->planning, 'Resources', 4, 'engagement', 2);
        $this->makeExercise($this->planning, 'Resources', 4, 'engagement', 3);

        // Verification: multiple choice corregible.
        $this->evaluatingStatements = $this->makeExercise($this->verification, 'Evaluating statements', 2, 'comprehension', 1);

        // Multiple choice de respuesta personal: no tiene respuesta correcta.
        $personal = $this->makeExercise($this->verification, 'What do you think?', 2, 'comprehension', 2);
        $personalQuestion = $this->makeQuestion($personal, 'Your opinion?', 1);
        $personalQuestion->personal_response = true;
        $personalQuestion->save();

        // Reflection: un poll de engagement.
        $this->enjoyment = $this->makeExercise($this->reflection, 'Enjoyment', 7, 'engagement', 1);

        $organizationQ1 = $this->makeQuestion($this->organization, 'What is your plan?', 1);
        $organizationQ2 = $this->makeQuestion($this->organization, 'Any other strategy?', 2);

        $statementsQ1 = $this->makeQuestion($this->evaluatingStatements, 'Statement 1', 1, 'True');
        $statementsQ2 = $this->makeQuestion($this->evaluatingStatements, 'Statement 2', 2, 'False');

        $enjoymentQ1 = $this->makeQuestion($this->enjoyment, 'Did you enjoy it?', 1);

        // --- Planning: un intento con ayudas abiertas.
        $attempt = $this->makeTracking($this->organization, 1, 125, 2, 0);
        $this->makeResponse($attempt, $organizationQ1, 'Listen for names');
        $this->makeResponse($attempt, $organizationQ2, 'Take notes');
        TrackingHelpUsage::create([
            'tracking_id' => $attempt->id,
            'help_type' => 'Transcript',
            'open_count' => 7,
            'time_spent_seconds' => 169,
        ]);
        TrackingHelpUsage::create([
            'tracking_id' => $attempt->id,
            'help_type' => 'Glossary',
            'open_count' => 2,
            'time_spent_seconds' => 44,
        ]);

        // --- Verification: dos intentos, el segundo acierta sólo la primera pregunta.
        $first = $this->makeTracking($this->evaluatingStatements, 1, 310, 0, 2);
        $this->makeResponse($first, $statementsQ1, 'False');
        $this->makeResponse($first, $statementsQ2, 'True');
        TrackingFeedbackUsage::create([
            'tracking_id' => $first->id,
            'question_id' => $statementsQ1->id,
            'feedback_type' => 'Explanatory',
            'open_count' => 3,
        ]);
        TrackingFeedbackUsage::create([
            'tracking_id' => $first->id,
            'question_id' => $statementsQ2->id,
            'feedback_type' => 'Directive',
            'open_count' => 1,
        ]);

        $second = $this->makeTracking($this->evaluatingStatements, 2, 45, 1, 1);
        $this->makeResponse($second, $statementsQ1, 'True');
        $this->makeResponse($second, $statementsQ2, 'True');
        TrackingFeedbackUsage::create([
            'tracking_id' => $second->id,
            'question_id' => $statementsQ2->id,
            'feedback_type' => 'Knowledge of Correct Response',
            'open_count' => 2,
        ]);

        // --- Reflection.
        $poll = $this->makeTracking($this->enjoyment, 1, 60, 1, 0);
        $this->makeResponse($poll, $enjoymentQ1, '6');

        $comment = new Comment([
            'title' => 'Mi opinión',
            'content' => 'Me gustó la unidad',
        ]);
        $comment->user_id = $this->student->id;
        $comment->group_id = $this->group->id;
        $comment->created_at = '2026-06-02 10:30:00';
        $comment->updated_at = '2026-06-02 10:30:00';
        $comment->save();
    }

    /**
     * group_id no está en el $fillable de User, así que se asigna aparte.
     */
    private function makeStudent(string $userId, string $name): User
    {
        $student = User::create([
            'user_id' => $userId,
            'name' => $name,
            'password' => bcrypt('secret'),
            'role' => 'student',
        ]);

        $student->group_id = $this->group->id;
        $student->save();

        return $student->fresh();
    }

    private function makeSection(string $name, int $position): Section
    {
        $section = new Section([
            'name' => $name,
            'underscore_name' => strtolower(str_replace(' ', '_', $name)),
            'position' => $position,
        ]);
        $section->unit_id = $this->unit->id;
        $section->save();

        return $section;
    }

    private function makeExercise(Section $section, string $title, int $typeId, string $category, int $position): Exercise
    {
        $exercise = new Exercise([
            'title' => $title,
            'position' => $position,
            'category' => $category,
        ]);
        $exercise->section_id = $section->id;
        $exercise->exercise_type_id = $typeId;
        $exercise->save();

        return $exercise;
    }

    private function makeQuestion(Exercise $exercise, string $statement, int $position, ?string $correct = null): Question
    {
        $question = new Question([
            'statement' => $statement,
            'position' => $position,
            'correct_answer' => $correct,
        ]);
        $question->exercise_id = $exercise->id;
        $question->save();

        return $question;
    }

    private function makeTracking(Exercise $exercise, int $intent, int $seconds, int $correct, int $wrong): Tracking
    {
        $tracking = new Tracking;
        $tracking->intent_number = (string) $intent;
        $tracking->time_spent_in_seconds = $seconds;
        $tracking->correct_answers = (string) $correct;
        $tracking->wrong_answers = (string) $wrong;
        $tracking->exercise_id = $exercise->id;
        $tracking->user_id = $this->student->id;
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
