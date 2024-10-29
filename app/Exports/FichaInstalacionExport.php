<?php

namespace App\Exports;

use App\Models\Contrato;
use App\Traits\GeneralToolsTrait;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FichaInstalacionExport
{
    use GeneralToolsTrait;
    public Contrato $contract;
    public array $productos;

    public function __construct(Contrato $contract, array $productos)
    {
        $this->contract = $contract;
        $this->productos = $productos;

    }

    public function generateSpreadsheet()
    {
        // Cargar la plantilla desde la ubicación proporcionada
        $templatePath = storage_path('app/templates/Ficha-instalacion2.xltx');
        $spreadsheet = IOFactory::load($templatePath);

        // Seleccionar la primera hoja
        $sheet = $spreadsheet->getActiveSheet();

        // Rellenar los datos del contrato y sus productos asociados en la plantilla
        $sheet->setCellValue('I8', $this->extractDateFromDateTime($this->contract->fecha->fecha_solicitud) ?? 'N/A');
        $sheet->setCellValue('I9', $this->extractTimeFromDateTime($this->contract->fecha->fecha_solicitud) ?? 'N/A');
        $sheet->setCellValue('I11', $this->productos['tanque']?->codigo ?? 'N/A');
        $sheet->setCellValue('I12', $this->productos['regulador']?->codigo ?? 'N/A');
        $sheet->setCellValue('I13', $this->productos['carrito']?->codigo ?? 'N/A');
        $sheet->setCellValue('D11', $this->productos['maquina']?->productable?->marca ?? 'N/A');
        $sheet->setCellValue('D12', $this->productos['maquina']?->productable?->modelo ?? 'N/A');
        $sheet->setCellValue('D13', $this->productos['maquina']?->codigo ?? 'N/A');
        $sheet->setCellValue('E25', $this->contract?->diagnostico?->dosis ?? 'N/A');
        $sheet->setCellValue('E38', $this->contract?->paciente?->full_name ?? 'N/A');
        $sheet->setCellValue('E39', $this->contract?->ultimaDireccionAprobada()?->responsable ?? 'N/A');
        $sheet->setCellValue('E40', $this->contract?->paciente?->dni ?? 'N/A');
        $sheet->setCellValue('E41', $this->contract?->ultimaDireccionAprobada()?->calle . ' ' . $this->contract?->paciente?->direccion?->distrito ?? 'N/A');
        $sheet->setCellValue('E42', $this->contract->telefonos?->pluck('numero')?->implode(', ') ?? 'N/A');

        return $spreadsheet;
    }

    public function saveSpreadsheet($path)
    {
        $spreadsheet = $this->generateSpreadsheet();
        $writer = new Xlsx($spreadsheet);

        // Crear la carpeta de salida si no existe
        $outputPath = storage_path('app/templates/output');
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0777, true);
        }

        // Guardar el archivo en la ruta especificada
        $writer->save($outputPath . '/' . $path);
    }
}
