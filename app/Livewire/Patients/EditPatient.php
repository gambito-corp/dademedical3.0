<?php

namespace App\Livewire\Patients;

use App\Models\Hospital;
use App\Models\Paciente;
use App\Services\Paciente\PacienteService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class EditPatient extends Component
{
    use WithFileUploads;

    protected PacienteService $patientService;

    public Paciente $patient; // Asegúrate de que sea de tipo Paciente
    public array $patientData = []; // Declaramos $patientData como propiedad pública
    public array $telefonos = [];
    public array $hospitals;
    public array $roles;
    public array $distritos;
    public int $currentStep = 1;
    public int $totalSteps = 2;
    public $otros;

    public function boot(PacienteService $patientService): void
    {
        $this->patientService = $patientService;
    }

    public function mount($patientId): void
    {
        App::setLocale(session('locale'));

        // Cargamos el paciente con sus relaciones
        $this->patient = Paciente::query()->with([
            'contrato.diagnostico',
            'contrato.direccion',
            'contrato.telefonos',
            'contrato.archivos',
        ])->findOrFail($patientId);

        // Inicializamos los arrays
        $this->hospitals = Hospital::all()->pluck('nombre', 'id')->toArray();
        $this->distritos = include base_path('app/Values/distritos.php');
        $this->roles = Role::all()->pluck('name', 'id')->toArray();

        // Prellenamos los teléfonos
        $this->telefonos = $this->patient->contrato->telefonos->pluck('numero')->toArray();

        // **Inicializamos $patientData con los datos necesarios**
        $this->patientData = [
            'hospital' => $this->patient->hospital_id,
            'documento_tipo' => $this->patient->tipo_documento,
            'numero_documento' => $this->patient->dni,
            'nombres' => $this->patient->name,
            'apellidos' => $this->patient->surname,
            'tipo_origen' => $this->patient->origen,
            'edad' => $this->patient->edad,
            'familiar_responsable' => $this->patient->contrato->direccion->responsable,
            // Puedes agregar más campos si es necesario
        ];
    }

    public function addTelefono()
    {
        $this->telefonos[] = '';
    }

    public function removeTelefono($index)
    {
        if (count($this->telefonos) > 1) {
            unset($this->telefonos[$index]);
            $this->telefonos = array_values($this->telefonos); // Reindexar el array
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function validateCurrentStep()
    {
        $rules = $this->rulesForCurrentStep();
        $this->validate($rules);
    }

    public function rulesForCurrentStep()
    {
        $telefonoRules = [];
        foreach ($this->telefonos as $index => $telefono) {
            $telefonoRules["telefonos.$index"] = 'required|string';
        }

        $stepRules = match ($this->currentStep) {
            1 => [
                // Solo campos editables
                'patientData.tipo_origen' => 'required',
                'patientData.edad' => 'required|integer|max:149',
            ],
            2 => array_merge([
                'patientData.familiar_responsable' => 'required',
            ], $telefonoRules),
            3 => [
                'otros' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ],
            default => [],
        };

        return $stepRules;
    }

    public function save()
    {
        $this->validateCurrentStep();
        $this->patientData['telefonos'] = $this->telefonos;
        $this->patientData['otros'] = $this->otros;
        $this->patientData['patientId'] = $this->patient->id;
        $this->patientService->edit($this->patientData);
        $this->dispatch('closeModal', 'edit');
    }

    public function render()
    {
        return view('livewire.patients.edit-patient');
    }
}
