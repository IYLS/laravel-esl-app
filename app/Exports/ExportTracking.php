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
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

/**
 * Export del sistema de tracking: un libro con una pestaña por indicador, con
 * los estudiantes en las filas y las columnas generadas a partir de las
 * unidades, stages, ejercicios y preguntas que tiene asignado el grupo.
 *
 * El formato sigue el archivo de referencia Columnas_de_datos.xlsx.
 *
 * El archivo se escribe con OpenSpout fila por fila directo a disco: armar el
 * libro con PhpSpreadsheet guarda cada celda en memoria y con grupos grandes
 * no alcanza en un servidor de 512MB.
 */
class ExportTracking
{
    /** Máximo de caracteres que Excel admite en una celda. */
    private const MAX_CELL_LENGTH = 32767;

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

    /**
     * Genera el archivo en una ruta temporal y lo devuelve como descarga; el
     * archivo se borra después de enviarlo.
     */
    public function download(string $fileName): BinaryFileResponse
    {
        $path = tempnam(sys_get_temp_dir(), 'tracking-export-');

        try {
            $this->store($path);
        } catch (Throwable $e) {
            @unlink($path);

            throw $e;
        }

        return response()->download($path, $fileName)->deleteFileAfterSend();
    }

    /**
     * Escribe el libro en $path, una pestaña tras otra.
     */
    public function store(string $path): void
    {
        $writer = new Writer();
        $writer->openToFile($path);
        $headingStyle = (new Style())->setFontBold();

        try {
            foreach ($this->sheets() as $index => $sheet) {
                $current = $index === 0 ? $writer->getCurrentSheet() : $writer->addNewSheetAndMakeItCurrent();
                $current->setName($sheet->title());

                $writer->addRow(Row::fromValues($sheet->headings(), $headingStyle));

                foreach ($sheet->generator() as $values) {
                    $writer->addRow(Row::fromValues(array_map([$this, 'cellValue'], $values)));
                }
            }
        } finally {
            $writer->close();
        }
    }

    /**
     * Igual que hacía PhpSpreadsheet: los textos numéricos se escriben como
     * número (salvo los que empiezan con 0, como "007") para que Excel pueda
     * sumarlos, y los textos demasiado largos se recortan al máximo de Excel.
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
