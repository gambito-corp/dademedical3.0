<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class BaseComponent extends Component
{
    use withPagination;
    public string $filter = 'active', $currentFilter = 'active', $search = '', $orderColumn = 'id', $orderDirection = 'desc';
    public bool $showDropdown = false;
    public int $paginate = 10;
    public array $paginacion = [10, 15, 20, 25, 30, 35, 40, 45, 50, 60, 70, 80, 90, 100, 200, 300, 400, 500, 1000];
    public function sortBy(string $column) : void
    {
        if ($this->orderColumn === $column) {
            $this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->orderColumn = $column;
            $this->orderDirection = 'asc';
        }
        $this->resetPage();
    }
    public function showPagination() : void
    {
        $this->showDropdown = !$this->showDropdown;
    }
    public function selectedPaginate($paginate):void
    {
        $this->paginate = $paginate;
        $this->showDropdown = false;
    }
}
