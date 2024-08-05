<?php

namespace Database\Factories;

use App\Models\Archivo;
use App\Models\Contrato;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class ArchivoFactory extends Factory
{
    protected $model = Archivo::class;

    public function definition()
    {
        $contrato = Contrato::all()->last();
        $paciente = $contrato ? $contrato->paciente : Paciente::all()->last();

        if (!$contrato || !$paciente) {
            // Crear un paciente y contrato si no existen
            $paciente = Paciente::factory()->create();
            $contrato = Contrato::factory()->create(['paciente_id' => $paciente->id]);
        }

        $date = $this->faker->date('Y_m_d');
        $timestamp = time();

        $tiposDocumentos = [
            Archivo::TIPO_SOLICITUD_OXIGENOTERAPIA,
            Archivo::TIPO_DNI_PACIENTE,
            Archivo::TIPO_DNI_CUIDADOR,
            Archivo::TIPO_DECLARACION_DOMICILIO,
            Archivo::TIPO_CROQUIS_DIRECCION,
            Archivo::TIPO_OTROS,
            Archivo::TIPO_ENTREGA_DISPOSITIVOS,
            Archivo::TIPO_GUIA_REMISION,
            Archivo::TIPO_CAMBIO_CONSUMIBLE,
            Archivo::TIPO_CAMBIO_MAQUINA,
            Archivo::TIPO_CAMBIO_DOSIS,
            Archivo::TIPO_CAMBIO_DIRECCION,
            Archivo::TIPO_INFORME_INCIDENCIA,
            Archivo::TIPO_RESPUESTA_INCIDENCIA,
            Archivo::TIPO_RECOJO_DISPOSITIVOS,
        ];

        $tipo = $this->faker->randomElement($tiposDocumentos);
        $file_name = $tipo . '_' . $date . '.pdf';

        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Contenido de prueba</h1>');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        $patientName = strtolower(str_replace(' ', '-', $paciente->name));
        $patientSurname = strtolower(str_replace(' ', '-', $paciente->surname));
        $patientId = $paciente->id;

        $directory = $patientName . '-' . $patientSurname . '-' . $patientId . '/' . $tipo;
        $path = $file_name;

        Storage::disk('archivos')->put($directory . '/' . $path, $pdfContent);
        $filePath = $directory . '/' . $path;

        return [
            'contrato_id' => $contrato->id,
            'paciente_id' => $paciente->id,
            'nombre' => $file_name,
            'ruta' => $filePath,
            'tipo' => $tipo,
        ];
    }
}
