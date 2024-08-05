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

    public $patient;
    public $hospitals, $roles, $distritos;
    public $telefonos = [''];
    public $reingreso = false;
    public $currentStep = 1, $totalSteps = 3;

    public function boot(PacienteService $patientService): void
    {
        $this->patientService = $patientService;
    }

    public function mount($patientId): void
    {
        App::setLocale(session('locale'));
        $this->patient = Paciente::findOrFail($patientId);
        $this->hospitals = Hospital::all()->pluck('nombre', 'id');
        $this->distritos = include base_path('app/Values/distritos.php');
        $this->roles = Role::all()->pluck('name', 'id');
        $this->telefonos = $this->patient?->telefonos?->pluck('numero')?->toArray() ?: [''];
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

    public function save()
    {
        $this->validate([
            'patient.hospital' => 'required|exists:hospitals,id',
            'patient.documento_tipo' => 'required|in:DNI,Pasaporte',
            'patient.numero_documento' => 'required|alpha_num',
            'patient.nombres' => 'required|string',
            'patient.apellidos' => 'required|string',
            'patient.tipo_origen' => 'required',
            'patient.edad' => 'required|integer| max:149',
            'patient.traqueotomia' => 'required|boolean',
            'patient.horas_oxigeno' => 'required',
            'patient.dosis' => ['required', function ($attribute, $value, $fail) {
                $sanitized = $this->sanitizeDosis($value);
                if ($sanitized < 0.5 || $sanitized > 10.0) {
                    $fail('La dosis debe estar entre 0.5 y 10.0 LPM.');
                }
                $this->patient['dosis'] = $sanitized . ' LPM'; // Actualizar el valor de dosis
            }],
            'patient.diagnostico' => 'required',
            'patient.historia_clinica' => 'required',
            'patient.distrito' => 'required',
            'patient.direccion' => 'required',
            'patient.referencia' => 'required',
            'patient.familiar_responsable' => 'required',
        ]);

        // Guardar datos actualizados del paciente
        $this->patient->update([
            'hospital' => $this->patient['hospital'],
            'documento_tipo' => $this->patient['documento_tipo'],
            'numero_documento' => $this->patient['numero_documento'],
            'nombres' => $this->patient['nombres'],
            'apellidos' => $this->patient['apellidos'],
            'tipo_origen' => $this->patient['tipo_origen'],
            'edad' => $this->patient['edad'],
            'traqueotomia' => $this->patient['traqueotomia'],
            'horas_oxigeno' => $this->patient['horas_oxigeno'],
            'dosis' => $this->patient['dosis'],
            'diagnostico' => $this->patient['diagnostico'],
            'historia_clinica' => $this->patient['historia_clinica'],
            'distrito' => $this->patient['distrito'],
            'direccion' => $this->patient['direccion'],
            'referencia' => $this->patient['referencia'],
            'familiar_responsable' => $this->patient['familiar_responsable'],
        ]);

        $this->patient->telefonos()->delete();
        foreach ($this->telefonos as $telefono) {
            $this->patient->telefonos()->create(['numero' => $telefono]);
        }

        $this->dispatch('closeModal', 'edit');
    }

    public function render()
    {
        return view('livewire.patients.edit-patient');
    }

    private function sanitizeDosis($dosis)
    {
        $dosis = preg_replace('/[-\/]/', ' ', $dosis);
        $parts = array_filter(explode(' ', $dosis), 'is_numeric');
        if (count($parts) > 1) {
            $maxValue = max($parts);
        } else {
            $maxValue = $dosis;
        }
        $maxValue = floatval($maxValue);
        $maxValue = min(max($maxValue, 0.5), 10.0);
        return $maxValue;
    }
}
