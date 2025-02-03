<?php

namespace App\Livewire\Incidences;

use App\Livewire\BaseComponent;
use App\Models\Incidencia;
use App\Services\Incidencia\IncidenciaService;
use Livewire\Attributes\On;

class Incidence extends BaseComponent
{

    protected $incidenciaService;

    public $incidencia;
    protected $data;

    public $modalEdit = false, $modalShow = false;

    public function boot(IncidenciaService $incidenciaService) : void
    {
        $this->incidenciaService = $incidenciaService;
    }

    public function mount() : void
    {
        parent::mount();
        $this->incidencia = null;
    }

    public function loadIncidences()
    {
        return $this->incidenciaService->getIncidences(
            $this->search, $this->filter, $this->orderColumn, $this->orderDirection, $this->paginate
        );

    }

    public function changeIncidence($state)
    {
        $this->currentFilter = $state;
        $this->filter = $state;
        $this->resetPage();
    }

    public function render()
    {
        $data = $this->data = $this->loadIncidences();
        return view('livewire.incidences.incidence', compact('data'));
    }

    public function resetModals():void
    {
        $this->modalEdit = false;
        $this->modalShow = false;
    }

    public function openModal($type, $incidenceId = null):void
    {
        if ($incidenceId !== null) {
            $this->incidencia = $this->incidenciaService->findWithTrashed($incidenceId);
        }
        $this->resetModals();
        match ($type){
            'edit' => $this->modalEdit = true,
            'show' => $this->modalShow = true,
        };
    }

    #[On('closeModal')]
    public function closeModal(string $type, $incidenceId = null):void
    {
        if ($incidenceId !== null) {
            $this->incidencia = null;
        }
        match ($type){
            'edit' => $this->modalEdit = false,
            'show' => $this->modalShow = false,
        };
        $this->resetModals();
    }
}
