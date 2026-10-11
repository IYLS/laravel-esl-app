<?php

namespace App\Exports;

use App\Exports\Sheets\AnswersSheet;
use App\Exports\Sheets\CompletedExercisesSheet;
use App\Exports\Sheets\CorrectPerExerciseSheet;
use App\Exports\Sheets\ExerciseCategoryTimeSheet;
use App\Exports\Sheets\FeedbackSheet;
use App\Exports\Sheets\ForumSheet;
use App\Exports\Sheets\HelpOptionsInteractionsSheet;
use App\Exports\Sheets\HelpOptionsTimeSheet;
use App\Exports\Sheets\IncorrectPerQuestionSheet;
use App\Exports\Sheets\PlatformTimeSheet;
use App\Exports\Sheets\RawDataSheet;
use App\Exports\Sheets\ReflectionSheet;
use App\Exports\Sheets\StagesCompletedExercisesSheet;
use App\Exports\Sheets\StagesTimeSheet;
use App\Exports\Sheets\TriesPerExerciseSheet;
use App\Exports\Sheets\UnitsCompletedSheet;
use App\Exports\Sheets\UnitTimeSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Export del sistema de tracking: un libro con una pestaña por indicador, con
 * los estudiantes en las filas y las columnas generadas a partir de las
 * unidades, stages, ejercicios y preguntas que tiene asignado el grupo.
 *
 * El formato sigue el archivo de referencia Columnas_de_datos.xlsx.
 */
class ExportTracking implements WithMultipleSheets
{
    /** @var int[] */
    protected array $userIds;

    /** 'student' o 'group'; se conserva para distinguir el origen del export. */
    protected string $exportType;

    public function __construct($userIds, string $exportType = 'student')
    {
        $this->userIds = is_array($userIds) ? $userIds : [$userIds];
        $this->exportType = $exportType;
    }

    public function sheets(): array
    {
        $context = new TrackingExportContext($this->userIds);

        return [
            new RawDataSheet($context),
            new UnitsCompletedSheet($context),
            new PlatformTimeSheet($context),
            new UnitTimeSheet($context),
            new StagesCompletedExercisesSheet($context),
            new CompletedExercisesSheet($context),
            new StagesTimeSheet($context),
            new ExerciseCategoryTimeSheet($context),
            new ReflectionSheet($context),
            new FeedbackSheet($context),
            new HelpOptionsInteractionsSheet($context),
            new HelpOptionsTimeSheet($context),
            new ForumSheet($context),
            new TriesPerExerciseSheet($context),
            new IncorrectPerQuestionSheet($context),
            new CorrectPerExerciseSheet($context),
            new AnswersSheet($context),
        ];
    }
}
