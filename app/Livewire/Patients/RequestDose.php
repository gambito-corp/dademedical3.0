<?php

namespace App\Livewire\Patients;

use AllowDynamicProperties;
use App\Models\Paciente;
use App\Services\Diagnostico\DiagnosticoService;
use App\Services\Paciente\PacienteService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestDose extends Component
{
    use WithFileUploads;
    protected PacienteService $patientService;
    protected DiagnosticoService $diagnosticoService;

    public int $patientId;
    public Paciente $patient;
    public $file;

    // Otras propiedades públicas
    public $historia_clinica, $diagnostico, $dosis, $frecuencia, $comentarios;

    public function boot(PacienteService $patientService, DiagnosticoService $diagnosticoService): void
    {
        $this->patientService = $patientService;
        $this->diagnosticoService = $diagnosticoService;
    }

    public function mount(): void
    {
        App::setLocale(session('locale'));
        // Cargar paciente y asignar valores a las propiedades
        $this->patient = $this->patientService->findWithTrashed($this->patientId)->load('contrato.diagnostico');

        $diagnostico = $this->patient->contrato->diagnostico;

        $this->historia_clinica = $diagnostico->historia_clinica;
        $this->diagnostico = $diagnostico->diagnostico;
        $this->dosis = $diagnostico->dosis;
        $this->frecuencia = $diagnostico->frecuencia;
        $this->comentarios = $diagnostico->comentarios;
    }

    public function update()
    {
        dd($this->file);
    }
    // Reglas de validación
    protected function rules()
    {
        return [
            'historia_clinica' => 'required|string|max:255',
            'diagnostico' => 'required|string|max:255',
            'dosis' => ['required', function ($attribute, $value, $fail) {
                $sanitized = $this->sanitizeDosis($value);
                if ($sanitized < 0.5 || $sanitized > 10.0) {
                    $fail('La dosis debe estar entre 0.5 y 10.0 LPM.');
                }
                $this->dosis = $sanitized . ' LPM'; // Actualizar el valor de dosis
            }],
            'frecuencia' => ['required', function ($attribute, $value, $fail) {
                $sanitized = $this->sanitizeFrecuencia($value);
                if ($sanitized < 1 || $sanitized > 24) {
                    $fail('La frecuencia debe estar entre 1 y 24 horas.');
                }
                $this->frecuencia = $sanitized . ' horas'; // Actualizar el valor de frecuencia
            }],
            'comentarios' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Máximo 2MB
        ];
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

    private function sanitizeFrecuencia($frecuencia)
    {
        // Eliminar cualquier carácter no numérico
        $frecuencia = preg_replace('/\D/', '', $frecuencia);

        // Convertir a entero
        $frecuencia = intval($frecuencia);

        // Limitar a rango permitido
        $frecuencia = min(max($frecuencia, 1), 24);

        return $frecuencia;
    }


    public function render()
    {
        $this->patient = $this->patientService->findWithTrashed($this->patientId)->load('contrato.diagnostico');
        return view('livewire.patients.request-dose');
    }

    public function save()
    {
        // Validar los datos antes de guardar
        $validatedData = $this->validate();
        $data = [
            'historia_clinica' => $this->historia_clinica,
            'diagnostico' => $this->diagnostico,
            'dosis' => $this->dosis,
            'frecuencia' => $this->frecuencia,
            'comentarios' => $this->comentarios,
            'paciente_id' => $this->patient->id,
            'contrato_id' => $this->patient->contrato->id,
            'nombre' => $this->patient->name,
            'apellido' => $this->patient->surname
        ];
        $this->diagnosticoService->newDiagnostico($data, $this->file);

        $this->reset(
            'file',
            'historia_clinica',
            'diagnostico',
            'dosis',
            'frecuencia',
            'comentarios'
        );

        $this->dispatch('closeModal', 'changeDose');
    }
    public function close()
    {
        $this->dispatch('closeModal', 'create');
    }
}
