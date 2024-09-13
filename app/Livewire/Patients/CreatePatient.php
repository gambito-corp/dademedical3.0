<?php

namespace App\Livewire\Patients;

use App\Models\Hospital;
use App\Models\Paciente;
use App\Services\Paciente\PacienteService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class CreatePatient extends Component
{
    use WithFileUploads;

    protected PacienteService $patientService;

    public $hospitals, $roles, $distritos;
    public $currentStep = 1;
    public $totalSteps = 4;
    public $paciente = [];
    public $telefonos = [''];
    public $reingreso = false;

    public function boot(PacienteService $patientService): void
    {
        $this->patientService = $patientService;
    }

    public function mount(): void
    {
        App::setLocale(session('locale'));
        $this->hospitals = Hospital::all()->pluck('nombre', 'id');
        $this->distritos = include base_path('app/Values/distritos.php');
        $this->roles = Role::all()->pluck('name', 'id');
        $this->telefonos = ['',''];
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

        // Validar que al menos se ingresen dos números de teléfono en la tercera etapa
        if ($this->currentStep == 3 && count($this->telefonos) < 2) {
            $this->addError('telefonos', 'Debe ingresar al menos dos números de teléfono.');
        }
    }

    public function rulesForCurrentStep()
    {
        $telefonoRules = [];
        foreach ($this->telefonos as $index => $telefono) {
            $telefonoRules["telefonos.$index"] = 'required|string';
        }

        $stepRules = match ($this->currentStep) {
            1 => [
                'paciente.hospital' => 'required|exists:hospitals,id',
                'paciente.documento_tipo' => 'required|in:DNI,Pasaporte',
                'paciente.numero_documento' => 'required|alpha_num',
                'paciente.nombres' => 'required|string',
                'paciente.apellidos' => 'required|string',
            ],
            2 => [
                'paciente.tipo_origen' => 'required',
                'paciente.edad' => 'required|integer| max:149',
                'paciente.traqueotomia' => 'required|boolean',
                'paciente.horas_oxigeno' => 'required',
                'paciente.dosis' => ['required', function ($attribute, $value, $fail) {
                    $sanitized = $this->sanitizeDosis($value);
                    if ($sanitized < 0.5 || $sanitized > 10.0) {
                        $fail('La dosis debe estar entre 0.5 y 10.0 LPM.');
                    }
                    $this->paciente['dosis'] = $sanitized . ' LPM'; // Actualizar el valor de dosis
                }],
                'paciente.diagnostico' => 'required',
                'paciente.historia_clinica' => 'required',
            ],
            3 => array_merge([
                'paciente.distrito' => 'required',
                'paciente.direccion' => 'required',
                'paciente.referencia' => 'required',
                'paciente.familiar_responsable' => 'required',
            ], $telefonoRules),
            4 => $this->fileValidationRules(),
            default => [],
        };

        return $stepRules;
    }

    private function fileValidationRules()
    {
        $userHospital = auth()->user()->hospital_id;
        $selectedHospital = $this->paciente['hospital'] ?? null;

        if ($userHospital == 2 || $selectedHospital == 2) {
            return [
                'paciente.solicitud_oxigenoterapia' => 'required|file|mimes:jpg,jpeg,png,pdf',
                'paciente.documento_identidad' => 'required|file|mimes:jpg,jpeg,png,pdf',
                'paciente.declaracion_jurada' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'paciente.documento_identidad_cuidador' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'paciente.croquis' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'paciente.otros' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ];
        }

        return [
            'paciente.solicitud_oxigenoterapia' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'paciente.declaracion_jurada' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'paciente.documento_identidad' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'paciente.documento_identidad_cuidador' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'paciente.croquis' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'paciente.otros' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'paciente.dosis') {
            $this->paciente['dosis'] = $this->formatDosis($this->paciente['dosis']);
        } elseif ($propertyName == 'paciente.horas_oxigeno') {
            $this->paciente['horas_oxigeno'] = $this->formatFrecuencia($this->paciente['horas_oxigeno']);
        }

        $this->validateOnly($propertyName, $this->rulesForCurrentStep());
    }

    private function sanitizeDosis($dosis)
    {
        // Reemplazar diferentes posibles delimitadores por un espacio
        $dosis = preg_replace('/[-\/]/', ' ', $dosis);

        // Separar los valores por espacios
        $parts = array_filter(explode(' ', $dosis), 'is_numeric');

        // Si hay más de un valor, tomamos el mayor
        if (count($parts) > 1) {
            $maxValue = max($parts);
        } else {
            $maxValue = $dosis;
        }

        // Limpiar y convertir a double
        $maxValue = floatval($maxValue);

        // Limitar a rango permitido
        $maxValue = min(max($maxValue, 0.5), 10.0);

        return $maxValue;
    }

    private function formatDosis($dosis)
    {
        return $dosis . ' LPM';
    }

    private function formatFrecuencia($frecuencia)
    {
        if ($frecuencia >24) $frecuencia = 24;
        return $frecuencia . ' horas';
    }

    public function checkReniec()
    {
        if (!isset($this->paciente['numero_documento']) || empty($this->paciente['numero_documento'])) {
            $this->addError('paciente.numero_documento', 'Ingrese un número de documento.');
            return;
        }
        $exist = Paciente::query()->firstWhere('dni', $this->paciente['numero_documento']);
        if ($exist && $exist->active == 1) {
            $this->addError('paciente.numero_documento', 'El paciente ya se encuentra en tratamiento. No se puede volver a ingresar.');
            return;
        }

        // Si el paciente existe pero no está activo, rellenar datos
        if ($exist && $exist->active != 1) {
            $this->fillExistingPreviusPatient();
            $this->reingreso = true;
            return;
        }

        if ($this->paciente['documento_tipo'] !== 'DNI') {
            return;
        }

        try {
            if (strlen($this->paciente['numero_documento']) !== 8) {
                $this->addError('paciente.numero_documento', 'El DNI debe tener exactamente 8 dígitos. Por favor, revise.');
                return;
            }
            $datosPaciente = $this->patientService->checkReniec($this->paciente['numero_documento']);
            $this->paciente['nombres'] = ucwords(strtolower($datosPaciente['nombres']));
            $this->paciente['apellidos'] = ucwords(strtolower($datosPaciente['apellidoPaterno'] . ' ' . $datosPaciente['apellidoMaterno']));
        } catch (\Exception $e) {
            // Manejar errores específicos de la API
            if ($e->getCode() === 404) {
                $this->addError('paciente.numero_documento', 'No se encontró información para el DNI ingresado.');
            } else {
                $this->addError('paciente.numero_documento', 'Error al consultar Reniec. Intente nuevamente más tarde.');
            }
        }
    }

    public function save()
    {
        $this->validateCurrentStep();

        // Sanitize and format 'dosis' and 'horas_oxigeno'
        $this->paciente['dosis'] = $this->sanitizeDosis($this->paciente['dosis']);
        $this->paciente['horas_oxigeno'] = (int) filter_var($this->paciente['horas_oxigeno'], FILTER_SANITIZE_NUMBER_INT);

        $this->paciente['telefonos'] = $this->telefonos;
        $this->paciente['reingreso'] = $this->reingreso;


        $this->patientService->create($this->paciente);

        $this->reset('paciente', 'telefonos');
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
        $paciente = Paciente::query()
            ->with(['user.hospital', 'contrato.archivos', 'contrato.diagnostico', 'contrato.direccion', 'contrato.telefonos'])
            ->where('dni', $this->paciente['numero_documento'])
            ->first();

        $this->paciente = [
            'hospital' => $this->paciente['hospital'],
            'documento_tipo' => $this->paciente['documento_tipo'],
            'numero_documento' => $paciente->dni,
            'nombres' => $paciente->name,
            'apellidos' => $paciente->surname,
            'tipo_origen' => $paciente->origen,
            'edad' => $paciente->edad,
            'traqueotomia' => $paciente->contrato->traqueotomia,
            'horas_oxigeno' => $paciente->contrato->diagnostico->frecuencia,
            'dosis' => $paciente->contrato->diagnostico->dosis,
            'diagnostico' => $paciente->contrato->diagnostico->diagnostico,
            'historia_clinica' => $paciente->contrato->diagnostico->historia_clinica,
            'distrito' => $paciente->contrato->direccion->distrito,
            'direccion' => $paciente->contrato->direccion->calle,
            'referencia' => $paciente->contrato->direccion->referencia,
            'familiar_responsable' => $paciente->contrato->direccion->responsable,
        ];

        if ($paciente->contrato->telefonos->isNotEmpty()) {
            $this->telefonos = $paciente->contrato->telefonos->pluck('numero')->toArray();
        }
    }
}
