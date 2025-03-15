<?php

namespace App\Livewire\Inventory;

use App\Livewire\BaseComponent;
use AllowDynamicProperties;
use App\Models\Producto;
use App\Services\Inventario\InventarioService;
use Livewire\Attributes\On;

class Inventory extends BaseComponent
{

    protected InventarioService $inventarioService;
    public $inventarios, $inventario;
    public string $filter = 'Maquinas';
    public string $currentFilter = 'Maquinas';
    public string $subFilter = 'activos';
    public array $subFilters = [
        'Maquinas' => ['activos', 'alquilados', 'mantenimiento', 'baja', 'registro'],
        'Tanques' => ['activos', 'alquilados', 'baja'],
        'Reguladores' => ['activos', 'alquilados', 'baja'],
        'Carritos' => ['activos', 'alquilados', 'baja'],
    ];

    public bool
        $modalCreate = false,
        $modalEdit = false;

    public function boot(InventarioService $inventarioService): void
    {
        $this->inventarioService = $inventarioService;
    }

    public function mount(): void
    {
        parent::mount();
        $this->inventario = null;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        $data = $this->loadInventario();
        return view('livewire.inventory.inventory', compact('data'));
    }

    public function loadInventario()
    {
        return $this->inventarioService->getInventario(
            $this->search, $this->filter, $this->subFilter, $this->orderColumn, $this->orderDirection, $this->paginate
        );
    }

    public function changeInventory(string $title): void
    {
        $this->currentFilter = $title;
        $this->filter = $title;
        $this->subFilter = 'activos';
        $this->resetPage();
    }
    public function changeSubFilter(string $subFilter)
    {
        $this->subFilter = $subFilter;
    }


    public function openModal(string $type, $inventarioId = null):void
    {
        if ($inventarioId !== null) {
            $this->inventario = $this->inventarioService->findWithTrashed($inventarioId);
        }

        $this->resetModals();

        match ($type) {
            'create' => $this->modalCreate = true,
            'edit' => $this->modalEdit = true,
            default => null,
        };
    }

    #[On('closeModal')]
    public function closeModal(string $type, $inventarioId = null)
    {
        if ($inventarioId !== null) {
            $this->inventario = null;
        }

        match ($type) {
            'create' => $this->modalCreate = false,
            'edit' => $this->modalEdit = false,
            default => null,
        };
    }

    private function resetModals()
    {
        $this->modalCreate = false;
        $this->modalEdit = false;
    }
}
