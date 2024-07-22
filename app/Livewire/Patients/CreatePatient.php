<?php
namespace App\Livewire\Patients;

use App\Models\Hospital;
use App\Models\Paciente;
use App\Services\Paciente\PacienteService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class CreatePatient extends Component
{
    use WithFileUploads;

    protected PacienteService $patientService;

    public $hospitals;
    public $roles;
    public $currentStep = 1;
    public $totalSteps = 4;

    public $paciente = [];

    public function boot(PacienteService $patientService): void
    {
        $this->patientService = $patientService;
    }

    public function mount(): void
    {
        $this->hospitals = Hospital::query()->get()->pluck('nombre', 'id');
        $this->roles = Role::query()->get()->pluck('name', 'id');
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
        return match($this->currentStep) {
            1 => [
                'paciente.hospital' => 'required|exists:hospitals,id',
                'paciente.documento_tipo' => 'required|in:DNI,Pasaporte',
                'paciente.numero_documento' => 'required',
                'paciente.nombres' => 'required',
                'paciente.apellidos' => 'required',
            ],
            2 => [
                'paciente.tipo_origen' => 'required',
                'paciente.edad' => 'required|integer',
                'paciente.traqueotomia' => 'required',
                'paciente.horas_oxigeno' => 'required|integer',
                'paciente.dosis' => 'required',
                'paciente.diagnostico' => 'required',
                'paciente.historia_clinica' => 'required',
            ],
            3 => [
                'paciente.distrito' => 'required',
                'paciente.direccion' => 'required',
                'paciente.referencia' => 'required',
                'paciente.familiar_responsable' => 'required',
                'paciente.telefono1' => 'required',
                'paciente.telefono2' => 'nullable',
            ],
            4 => [
                'paciente.solicitud_oxigenoterapia' => 'required|file',
                'paciente.declaracion_jurada' => 'required|file',
                'paciente.documento_identidad' => 'required|file',
                'paciente.documento_identidad_cuidador' => 'required|file',
                'paciente.croquis' => 'required|file',
                'paciente.otros' => 'nullable|file',
            ],
            default => [],
        };
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rulesForCurrentStep());
    }

    public function checkReniec()
    {
        $this->paciente['nombres'] = 'hola';
        $this->paciente['apellidos'] = 'mundo';
        $paciente = $this->paciente;
        $exist = Paciente::query()
            ->where('dni', $paciente['numero_documento'])
            ->exists();

        if (!$exist) {
            if (strlen($paciente['numero_documento']) == 8){
                $datosPaciente = $this->patientService->checkReniec($paciente['numero_documento']);

                // Agregar los valores al array de nombres y apellidos sin eliminar los existentes
                $this->paciente['nombres'] = $datosPaciente['nombres'];
                $this->paciente['apellidos'] = $datosPaciente['apellidos'];

                // Mostrar la longitud del DNI y los datos del pacient
            }else{
                $this->addError('paciente.numero_documento', 'El DNI debe tener Exactamente 8 Digitos, Porfavor Revisar que este bien introducido');
            }
        } else {
            $this->fillExistingPreviusPatient();
        }
//        dd($paciente);
    }

    public function save()
    {
        $this->validateCurrentStep();
        // $this->paciente->save();
        $this->reset('paciente');
        $this->dispatch('closeModal', 'create');
    }

    public function render()
    {
        return view('livewire.patients.create-patient');
    }

    public function close()
    {
        $this->dispatch('closeModal', 'create');
    }

    private function fillExistingPreviusPatient()
    {

    }
}
