<?php

namespace App\Livewire\Contracts\Forms;

use App\Services\Archivo\ArchivoService;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contrato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OsAprobado extends Component
{
    use WithFileUploads;

    public Contrato $contract;

    protected ArchivoService $archivoService;

    // Campos del formulario
    public $fecha_entrega;
    public $ficha_instalacion;
    public $guia_remision;

    public $mostrarInputFiles = false;
    public $mostrarBotonAprobar = false;
    public $mostrarBotonCancelar = true;

    // Reglas de validación
    protected $rules = [
        'fecha_entrega' => 'required|date',
        'ficha_instalacion' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'guia_remision' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];

    public function boot(ArchivoService $archivoService): void
    {
        $this->archivoService = $archivoService;
    }

    public function mount(Contrato $contract)
    {
        $this->contract = $contract;
    }

    public function render()
    {
        return view('livewire.contracts.forms.os-aprobado');
    }

    // Función que se ejecuta al actualizar 'fecha_entrega'
    public function updatedFechaEntrega()
    {
       if ($this->fecha_entrega !== null) {
           $this->mostrarBotonCancelar = false;
           $this->mostrarInputFiles = true;
           $this->mostrarBotonAprobar = true;
       }else{
           $this->mostrarBotonCancelar = true;
           $this->mostrarInputFiles = false;
           $this->mostrarBotonAprobar = false;
           $this->ficha_instalacion = null;
           $this->guia_remision = null;
       }

    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Preparar los archivos para guardar
            $archivos = [
                'ficha_instalacion' => $this->ficha_instalacion,
                'guia_remision' => $this->guia_remision,
            ];


            // Obtener datos del paciente
            $patientId = $this->contract->paciente->id;
            $patientName = $this->contract->paciente->name;
            $patientSurname = $this->contract->paciente->surname;

            // Guardar archivos utilizando ArchivoService
            $this->archivoService->save(
                $archivos,
                $this->contract->id,
                $patientId,
                $patientName,
                $patientSurname
            );

            // Actualizar contrato
            $this->contract->contratoFechas->fecha_entrega = $this->fecha_entrega;
            $this->contract->estado_orden = 4;
            $this->contract->save();

            DB::commit();

            // Despachar evento para actualizar el componente padre
            $this->dispatch('orden-actualizada', ['contractId' => $this->contract->id]);

            session()->flash('status', 'La Orden de Servicio ha sido entregada con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar la Orden de Servicio.');
        }
    }

    public function cancelarOS()
    {
        try {
            DB::beginTransaction();

            // Actualizar contrato
            $this->contract->estado_orden = 3; // 'Anulado'
            $this->contract->save();
            $this->dispatch('orden-actualizada', ['contractId' => $this->contract->id]);

            DB::rollBack();

            // Despachar evento para actualizar el componente padre

            session()->flash('status', 'La Orden de Servicio ha sido anulada.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            session()->flash('error', 'Ocurrió un error al anular la Orden de Servicio.');
        }
    }
}
