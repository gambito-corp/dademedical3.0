<?php

namespace App\Livewire\Patients;

use App\Models\Diagnostico;
use App\Models\Paciente;
//use App\Models\DoseChangeRequest;
use Livewire\Component;

class ApproveDose extends Component
{
    public Paciente $patient;
    public Diagnostico $diagnostico;
    public Diagnostico $doseChangeRequest;

    public $approvalStatus;

    public $comments;

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
    }

    public function render()
    {
        return view('livewire.patients.approve-dose');
    }

    public function approve()
    {
        dd('Approve');

        // Cerrar el modal o redirigir
        $this->emit('closeModal', 'approveDose');
    }

    public function close()
    {
        $this->emit('closeModal', 'approveDose');
    }
}
