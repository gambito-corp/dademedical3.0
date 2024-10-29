<?php

namespace App\Exports;

use App\Models\Contrato;
use App\Traits\GeneralToolsTrait;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Log;

class FichaRecogidaExport
{
    use GeneralToolsTrait;

    public Contrato $contract;

    public function __construct(Contrato $contract)
    {
        $this->contract = $contract;
    }

    public function generateSpreadsheet()
    {
        try {
            // Cargar la plantilla desde la ubicación proporcionada
            $templatePath = storage_path('app/templates/Ficha-Recojo.xlt');
            $spreadsheet = IOFactory::load($templatePath);

            // Seleccionar la primera hoja
            $sheet = $spreadsheet->getActiveSheet();

            // Rellenar los datos en las celdas especificadas

            // G4: Fecha de Recojo
            $fechaRecojo = $this->contract->contratoFechas->fecha_solicitud_recojo
                ? $this->contract->contratoFechas->fecha_solicitud_recojo->format('d/m/Y')
                : 'N/A';
            $sheet->setCellValue('G4', $fechaRecojo);

            // D6: Texto Plano 'Marca'
            $sheet->setCellValue('D6', 'Marca');

            // D7: Texto Plano 'Modelo'
            $sheet->setCellValue('D7', 'Modelo');

            // D8: Texto Plano 'Serie'
            $sheet->setCellValue('D8', 'Serie');

            // E13: Nombre Completo del Paciente
            $patientFullName = $this->contract->paciente->full_name ?? 'N/A';
            $sheet->setCellValue('E13', $patientFullName);

            // E14: Nombre Completo del Responsable
            $responsibleFullName = $this->contract->direccion->responsable ?? 'N/A';
            $sheet->setCellValue('E14', $responsibleFullName);

            // E15: DNI
            $dni = $this->contract->paciente->dni ?? 'N/A';
            $sheet->setCellValue('E15', $dni);

            // E16: Dirección
            $address = $this->contract->direccion
                ? $this->contract->direccion->calle . ', ' . $this->contract->direccion->distrito
                : 'N/A';
            $sheet->setCellValue('E16', $address);

            // E17: Teléfonos
            $phoneNumbers = $this->contract->telefonos->pluck('numero')->implode(', ') ?? 'N/A';
            $sheet->setCellValue('E17', $phoneNumbers);

            return $spreadsheet;

        } catch (\Exception $e) {
            Log::error('Error generating spreadsheet: ' . $e->getMessage());
            throw $e;
        }
    }

    public function saveSpreadsheet($filename)
    {
        $spreadsheet = $this->generateSpreadsheet();
        $writer = new Xlsx($spreadsheet);

        // Crear la carpeta de salida si no existe
        $outputPath = storage_path('app/templates/output');
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0777, true);
        }

        // Guardar el archivo en la ruta especificada
        $writer->save($outputPath . '/' . $filename);
    }
}
