<?php

namespace App\Livewire\Patients;

use App\Models\Archivo;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Services\Archivo\ArchivoService;
use Hashids\Hashids;
use Livewire\Component;

class ApproveDose extends Component
{

    protected ArchivoService $archivoService;

    public Paciente $patient;
    public Diagnostico $diagnostico;
    public Diagnostico $doseChangeRequest;

    public $approvalStatus;

    public $comments;
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
        $this->patient = Paciente::with('contrato.diagnosticos')->findOrFail($patientId);

        // Obtener el último diagnóstico aprobado (active = 1)
        $this->diagnostico = $this->patient->contrato->diagnosticos()
            ->where('active', 1)
            ->latest('id')
            ->first();

        // Obtener el diagnóstico pendiente de aprobación (active = 0)
        $this->doseChangeRequest = $this->patient->contrato->diagnosticos()
            ->whereId($this->patient->idDiagnosticoPendiente)->first();

        $this->archivo = Archivo::query()->where('contrato_id', $this->patient->contrato->id)
            ->where('paciente_id', $this->patient->id)
            ->where('tipo', 'documento de cambio de dosis')
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
        return view('livewire.patients.approve-dose');
    }

    public function approve()
    {

        if  ($this->approvalStatus = 'approved') {
            $this->diagnostico->update(['active' => 0]);
            $this->diagnostico->delete();
            $this->doseChangeRequest->update(['active' => 1]);
        } else {
            $this->doseChangeRequest->update(['active' => 0]);
            $this->doseChangeRequest->delete();
            $this->archivoService->deleteDocument($this->archivo->id);
        }
        $this->dispatch('closeModal', 'approveDose');
    }

    public function close()
    {
        $this->dispatch('closeModal', 'approveDose');
    }

    public function viewDocument()
    {
        $filename = Archivo::query()->where('contrato_id', $this->patient->contrato->id)
            ->where('paciente_id', $this->patient->id)
            ->where('tipo', 'documento de cambio de dosis')
            ->first();
        $this->urlImagen = $this->archivoService->showDocument($filename->nombre);
    }
}
