<?php

namespace App\Livewire\Incidences;

use App\Services\Incidencia\IncidenciaService;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EditIncidence extends Component
{
    protected IncidenciaService $incidenciaService;

    public $incidenceId;
    #[Validate('required')]
    public $tipo_incidencia;

    #[Validate('required')]
    public $incidencia;

    #[Validate('nullable')]
    public $respuesta;

    #[Validate('boolean')]
    public $active;

    public function boot(IncidenciaService $incidenciaService): void
    {
        $this->incidenciaService = $incidenciaService;
    }

    public function mount($incidenceId)
    {
        $this->incidenceId = $incidenceId;
        $incidence = $this->incidenciaService->findWithTrashed($incidenceId);
        $this->tipo_incidencia = $incidence->tipo_incidencia;
        $this->incidencia = $incidence->incidencia;
        $this->respuesta = $incidence->respuesta;
        $this->active = (bool)$incidence->active;
    }

    public function updateIncidence()
    {
        $validated = $this->validate();
        $this->incidenciaService->update([
            'id' => $this->incidenceId,
            'tipo_incidencia' => $this->tipo_incidencia,
            'incidencia' => $this->incidencia,
            'respuesta' => $this->respuesta,
            'active' => $this->active,
        ]);

        $this->dispatch('incidenceUpdated');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.incidences.edit-incidence');
    }
}
