<?php

namespace Database\Factories;

use App\Models\Archivo;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Factories\Factory;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class ArchivoFactory extends Factory
{
    protected $model = Archivo::class;

    public function definition()
    {

        $contrato = Contrato::all()->last();
        // Generate a date string for file names
        $date = $this->faker->date('Y_m_d');

        // Define array of possible file names
        $file_names = [
            'solicitud_de_Oxigenoterapia_' . $date,
            'dni_' . $date,
            'documento_alta_' . $date
        ];

        // Pick a random file name
        $file_name = $this->faker->randomElement($file_names);

        // Generate a timestamp for the file path
        $timestamp = time();

        // Prepare PDF content
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Contenido de prueba</h1>');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        if ($contrato) {
            $pacienteName = $contrato->paciente->name;
            $pacienteId = $contrato->paciente->id;
            $contratoId = $contrato->id;
        } else {
            $contratoId = Contrato::all()->last()->id;
            $pacienteName = Contrato::all()->last()->paciente->name;
            $pacienteId = Contrato::all()->last()->paciente->id;
        }

        // Use the specific 'archivos' disk to store the PDF file
        Storage::disk('archivos')->put($pacienteName.'-'.$pacienteId.'/'.$contratoId.'/'.$timestamp.'.pdf', $pdfContent);

        // Define the file path
        $filePath = $pacienteName.'-'.$pacienteId.'/'.$contratoId.'/'.$timestamp.'.pdf';

        return [
            'contrato_id' => $contratoId,
            'nombre' => $file_name,
            'ruta' => $filePath,
        ];
    }
}
