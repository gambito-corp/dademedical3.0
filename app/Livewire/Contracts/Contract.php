<?php

namespace App\Livewire\Contracts;



use AllowDynamicProperties;
use App\Livewire\BaseComponent;
use App\Models\Contrato;
use App\Services\Contrato\ContratoService;
use Livewire\Attributes\On;

#[AllowDynamicProperties] class Contract extends BaseComponent
{

    protected ContratoService $contractService;

    public $contracts, $contract;
    public string $filter = 'solicitado';
    public string $currentFilter = 'solicitado';

    public function boot(ContratoService $contractService) : void
    {
        $this->contractService = $contractService;
    }

    public function mount() : void
    {
        parent::mount();
        $this->contract = null;
    }



    public function render()
    {
        $data = $this->loadContracts();
        return view('livewire.contracts.contract', compact('data'));
    }

    public function loadContracts()
    {
        return $this->contractService->getContracts(
            $this->search, $this->filter, $this->orderColumn, $this->orderDirection, $this->paginate
        );
    }
    public function changeContract(string $title) : void
    {
        $this->currentFilter = $title;
        $this->filter = $title;
        $this->resetPage();
    }

    public function openModal(string $type, $contractId = null): void
    {
        if ($contractId !== null) {
            $this->contract = $this->contractService->obtenerContrato($contractId);
        }

        match ($type) {
            'edit' => $this->modalEdit = true,
            'delete' => $this->modalDelete = true,
            default => null,
        };
    }

    public function closeModal(string $type): void
    {
        match ($type) {
            'edit' => $this->modalEdit = false,
            'delete' => $this->modalDelete = false,
            default => null,
        };
    }

    public function deleteContract($contractId): void
    {
        $this->contractService->deleteContract($contractId);
        $this->closeModal('delete');
    }

    public function showContract($contractId)
    {
        $contract = Contrato::query()->whereId($contractId)->first();
        return redirect()->route('contracts.show', $contract);
    }
}
