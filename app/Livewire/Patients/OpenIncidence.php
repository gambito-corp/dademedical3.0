<?php

namespace App\Livewire\Patients;

use App\Models\Incidencia;
use App\Models\Paciente;
use App\Services\Paciente\PacienteService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class OpenIncidence extends Component
{

    protected PacienteService $patientService;
    public $patientId;
    public $incidenceType;
    public $description;
    public Paciente $patient;

    public function boot(PacienteService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function mount($patientId)
    {
        App::setLocale(session('locale'));
        $this->patientId = $patientId;
        $this->patient = $this->patientService->findWithTrashed($this->patientId)
            ->load(['contrato.incidencias']);
    }

    protected function rules()
    {
        return [
            'incidenceType' => 'required',
            'description' => 'required',
        ];
    }

    public function submit()
    {
        $this->validate();
        dd($this->patient->contrato->id);

        Incidencia::query()->create([
            'contract_id' => $this->patient->contrato->id,
            'user_id' => auth()->id(),
            'tipo_incidencia' => $this->incidenceType,
            'incidencia' => $this->description,
            'active' => true,
            'fecha_incidencia' => now(),
        ]);
        $this->dispatch('incidence');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.patients.open-incidence');
    }
    public function close()
    {
        $this->dispatch('closeModal', 'changeDirecction');
    }
}
