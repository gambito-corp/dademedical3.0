<?php

namespace App\Livewire\Contracts\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contrato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Archivo\ArchivoService;

class OsRecogido extends Component
{
    use WithFileUploads;

    public Contrato $contract;
    protected ArchivoService $archivoService;

    // Campos del formulario
    public $fecha_recogida;
    public $ficha_recogida;

    public $mostrarBotonFinalizar = false;

    // Reglas de validación
    protected $rules = [
        'fecha_recogida' => 'required|date',
        'ficha_recogida' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];

    public function boot(ArchivoService $archivoService)
    {
        $this->archivoService = $archivoService;
    }

    public function mount(Contrato $contract)
    {
        $this->contract = $contract;
    }

    public function render()
    {
        return view('livewire.contracts.forms.os-recogido');
    }

    // Función que se ejecuta al actualizar 'fecha_recogida' o 'ficha_recogida'
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // Mostrar el botón 'Finalizar OS' solo si ambos campos están completos y válidos
        if ($this->fecha_recogida && $this->ficha_recogida) {
            $this->mostrarBotonFinalizar = true;
        } else {
            $this->mostrarBotonFinalizar = false;
        }
    }

    public function finalizarOS()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Preparar el archivo para guardar
            $archivos = [
                'ficha_recogida' => $this->ficha_recogida,
            ];

            // Obtener datos del paciente
            $patientId = $this->contract->paciente->id;
            $patientName = $this->contract->paciente->name;
            $patientSurname = $this->contract->paciente->surname;

            // Guardar archivo utilizando ArchivoService
            $this->archivoService->save(
                $archivos,
                $this->contract->id,
                $patientId,
                $patientName,
                $patientSurname
            );

            // Actualizar contrato
            $this->contract->estado_orden = 6; // 'Finalizado'
            $this->contract->save();

            // Actualizar fecha de recogida en contratoFechas
            $contratoFechas = $this->contract->contratoFechas;
            $contratoFechas->fecha_recogida = $this->fecha_recogida;
            $contratoFechas->save();

            DB::commit();

            // Despachar evento para actualizar el componente padre
            $this->dispatch('orden-actualizada', ['contractId' => $this->contract->id]);

            session()->flash('status', 'La Orden de Servicio ha sido finalizada con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al finalizar la Orden de Servicio: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al finalizar la Orden de Servicio.');
        }
    }
}
