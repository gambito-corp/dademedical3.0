<?php

namespace App\Livewire\Contracts\Forms;

use Livewire\Component;
use App\Models\Contrato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Exports\FichaRecogidaExport;
use Maatwebsite\Excel\Facades\Excel;

class OsEntregado extends Component
{
    public Contrato $contract;
    public $fecha_solicitud_recojo;

    public function mount(Contrato $contract)
    {
        $this->contract = $contract;
    }

    public function render()
    {
        return view('livewire.contracts.forms.os-entregado', [
            'contract' => $this->contract->load('contratoFechas'),
        ]);
    }

    // Acción al hacer clic en "Imprimir Ficha de Recogida"
    public function imprimirFichaRecogida()
    {
        try {
            // Crear una instancia del exportador
            $export = new FichaRecogidaExport($this->contract);

            $patientName = Str::slug($this->contract->paciente->full_name, '_');

            // Definir el nombre del archivo de salida
            $outputFilename = 'Ficha_Recogida_' . $patientName . '.xlsx';

            // Guardar el archivo Excel
            $export->saveSpreadsheet($outputFilename);

            // Definir la ruta completa del archivo para descargar
            $outputPath = storage_path('app/templates/output/' . $outputFilename);

            // Retornar la descarga al usuario
            if (!file_exists($outputPath)) {
                abort(404, 'El archivo no se pudo generar');
            }
        } catch (\Exception $e) {
            Log::error('Error al generar la ficha de recogida: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al generar la ficha de recogida.');
        }
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    // Acción al hacer clic en "Asignar Fecha de Solicitud de Recojo"
    public function asignarFechaSolicitudRecojo()
    {
        $this->validate([
            'fecha_solicitud_recojo' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar la fecha de solicitud de recogida
            $contratoFechas = $this->contract->contratoFechas;
            $contratoFechas->fecha_baja = $this->fecha_solicitud_recojo;
            $contratoFechas->save();

            // Actualizar el estado del contrato a 'En Proceso de Recojo' (estado 5)
            $this->contract->estado_orden = 5;
            $this->contract->save();

            DB::commit();

            // Despachar evento para actualizar el componente padre
            $this->dispatch('orden-actualizada', ['contractId' => $this->contract->id]);

            session()->flash('status', 'La fecha de solicitud de recogida ha sido asignada con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar fecha de solicitud de recogida: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al asignar la fecha de solicitud de recogida.');
        }
    }
}
