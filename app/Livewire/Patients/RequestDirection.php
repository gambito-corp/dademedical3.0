<?php

namespace App\Livewire\Patients;

use App\Models\Archivo;
use App\Models\Paciente;
use App\Services\Archivo\ArchivoService;
use App\Services\Direccion\DireccionService;
use App\Services\Paciente\PacienteService;
use Hashids\Hashids;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestDirection extends Component
{
    use WithFileUploads;
    protected PacienteService $patientService;
    Protected ArchivoService $archivoService;
    Protected DireccionService $direccionService;

    public int $patientId;
    public Paciente $patient;
    public $file;
    public $distrito, $direccion, $referencia, $responsable, $telefono, $distritos, $telefonos;
    public $archivosCambioDireccion;

    public function boot(
        PacienteService $patientService,
        ArchivoService $archivoService,
        DireccionService $direccionService
    ): void
    {
        $this->patientService = $patientService;
        $this->archivoService = $archivoService;
        $this->direccionService = $direccionService;
    }

    public function mount(): void
    {
        App::setLocale(session('locale'));

        // Cargar el paciente y el contrato
        $this->patient = $this->patientService->findWithTrashed($this->patientId)
            ->load(['contrato.direccion', 'contrato.archivos']);

        $direccion = $this->patient->contrato->direccion;
        $direccionChanged = $this->patient->contrato->ultimaDireccionPendiente();

        $this->distritos = include base_path('app/Values/distritos.php');

        // Filtrar los archivos del tipo 'cambio de dirección'
        $this->archivosCambioDireccion = $this->patient->contrato->archivos
            ->where('tipo', Archivo::TIPO_CAMBIO_DIRECCION);
//        dd($this->patient->contrato->archivos);

        // Establecer valores iniciales en los campos
        $this->distrito = $direccionChanged->distrito ?? $direccion->distrito;
        $this->direccion = $direccionChanged->calle ?? $direccion->calle;
        $this->referencia = $direccionChanged->referencia ?? $direccion->referencia;
        $this->responsable = $direccionChanged->responsable ?? $direccion->responsable;
    }

    public function showDocument($fileName)
    {
        return $this->archivoService->showDocument($fileName);
    }



    protected function rules()
    {
        return [
            'distrito' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'referencia' => 'nullable|string|max:500',
            'responsable' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Máximo 2MB
        ];
    }


    public function render()
    {
        $this->patient = $this->patientService->findWithTrashed($this->patientId)->load('contrato.direccion');
        return view('livewire.patients.request-direction');
    }

    public function encrypter($value)
    {
        $hash = new Hashids();
        return $hash->encode($value);
    }

    public function save()
    {
        $data = [
            'paciente_id' => $this->patient->id,
            'contrato_id' => $this->patient->contrato->id,
            'distrito' => $this->distrito,
            'direccion' => $this->direccion,
            'referencia' => $this->referencia,
            'responsable' => $this->responsable,
            'nombre' => $this->patient->nombre,
            'apellido' => $this->patient->apellido,

        ];

        $this->direccionService->newDireccion($data, $this->file);

        // Eliminar los archivos preexistentes de cambio de dosis antes de guardar el nuevo
        if ($this->archivosCambioDireccion->isNotEmpty()) {
            $this->archivoService->detachedFiles($this->archivosCambioDireccion);
        }

        $this->reset(
            'file',
            'distrito',
            'direccion',
            'referencia',
            'responsable'
        );

        $this->dispatch('closeModal', 'changeDirecction');
    }
    public function close()
    {
        $this->dispatch('closeModal', 'changeDirecction');
    }
}
