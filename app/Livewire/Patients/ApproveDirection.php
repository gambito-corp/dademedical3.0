<?php

namespace App\Livewire\Patients;

use App\Models\Archivo;
use App\Models\Direccion;
use App\Models\Paciente;
use App\Services\Archivo\ArchivoService;
use Hashids\Hashids;
use Livewire\Component;

class ApproveDirection extends Component
{
    protected ArchivoService $archivoService;
    public Paciente $paciente;
    public Direccion $direccion;
    public Direccion $cambioDireccion;
    public $approvalStatus = "approved";
    public $urlImagen;
    public $archivo;
    public $typeDocument;
    public $archivoId;

    public function boot(ArchivoService $archivoService): void
    {
        $this->archivoService = $archivoService;
    }

    public function mount($patientId)
    {
        // Cargar el paciente con su contrato y diagnósticos
        $this->paciente = Paciente::with('contrato.direcciones')->findOrFail($patientId);

        $this->direccion = $this->paciente->contrato->direcciones()
            ->where('active', 1)
            ->latest('id')
            ->first();

        $this->cambioDireccion = $this->paciente->contrato->direcciones()
            ->whereId($this->paciente->idDireccionPendiente)->first();

        $this->archivo = Archivo::query()->where('contrato_id', $this->paciente->contrato->id)
            ->where('paciente_id', $this->paciente->id)
            ->where('tipo', 'documento de cambio de dirección')
            ->get()->last();

        $hash = new Hashids();
        $this->archivoId = $hash->encode($this->archivo->id);

        $extension = strtolower(pathinfo($this->archivo->nombre, PATHINFO_EXTENSION));
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'])) {
            $this->typeDocument = 'imagen';
        } elseif ($extension === 'pdf') {
            $this->typeDocument = 'pdf';
        }
    }

    public function render()
    {
        return view('livewire.patients.approve-direction');
    }

    public function approve()
    {
        if ($this->approvalStatus != 'approved') {
            $this->cambioDireccion->update(['active' => 0]);
            $this->cambioDireccion->forceDelete();
            $this->archivoService->deleteDocument($this->archivo->id);
        }else{
            $this->direccion->update(['active' => 0]);
            $this->direccion->delete();
            $this->cambioDireccion->update(['active' => 1]);
        }
        $this->dispatch('closeModal', 'aproveDirecction');
    }

    public function close()
    {
        $this->dispatch('closeModal', 'aproveDirecction');
    }

    public function viewDocument()
    {
        $filename = Archivo::query()->where('contrato_id', $this->paciente->contrato->id)
            ->where('paciente_id', $this->paciente->id)
            ->where('tipo', 'documento de cambio de dirección')
            ->first();
        $this->urlImagen = $this->archivoService->showDocument($filename->nombre);
    }
}
