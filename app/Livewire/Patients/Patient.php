<?php

namespace App\Livewire\Patients;

use App\Services\Paciente\PacienteService;
use App\Livewire\BaseComponent as Component;
use Livewire\Attributes\On;

class Patient extends Component
{
    protected PacienteService $patientService;
    public $pacientes, $paciente;
    public bool $modalCreate = false, $modalEdit = false, $modalShow = false, $modalDelete = false, $showDropdown = false;

    public function boot(PacienteService $patientService) : void
    {
        $this->patientService = $patientService;
    }

    public function mount() : void
    {
        parent::mount();
        $this->paciente = null; // Inicializar la variable $paciente
    }

    public function render()
    {
        $data = $this->loadPatients();
        return view('livewire.patients.patient', compact('data'));
    }

    public function loadPatients()
    {
        return $this->patientService->getPatients(
            $this->search, $this->filter, $this->orderColumn, $this->orderDirection, $this->paginate
        );
    }

    public function changePatient(string $title) : void
    {
        $this->currentFilter = $title;
        $this->filter = $title;
        $this->resetPage();
    }

    public function openModal(string $type, $patientId = null):void
    {
        if ($patientId !== null) {
            $this->paciente = $this->patientService->findWithTrashed($patientId);
        }

        $this->resetModals();

        match ($type) {
            'create' => $this->modalCreate = true,
            'edit' => $this->modalEdit = true,
            'show' => $this->modalShow = true,
            'delete' => $this->modalDelete = true,
            default => null,
        };
    }

    #[On('closeModal')]
    public function closeModal(string $type, $patientId = null)
    {
        if ($patientId !== null) {
            $this->paciente = null;
        }

        match ($type) {
            'create' => $this->modalCreate = false,
            'edit' => $this->modalEdit = false,
            'show' => $this->modalShow = false,
            'delete' => $this->modalDelete = false,
            default => null,
        };
    }

    private function resetModals()
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
        $this->modalShow = false;
        $this->modalDelete = false;
    }
}
