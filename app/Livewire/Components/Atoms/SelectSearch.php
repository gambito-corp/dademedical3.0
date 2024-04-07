<?php

namespace App\Livewire\Components\Atoms;

use Livewire\Attributes\On;
use Livewire\Component;

class SelectSearch extends Component
{
    public $selected;
    public $tipo;
    public $placeholderText = '';
    public $showDropdown = false;
    public $items;
    public $search = '';

    //EMISIÓN DE EVENTOS
    public function showDropdownComponete()
    {
        $this->showDropdown = true;
        $this->dispatch('showDropdown', tipo: $this->tipo);

    }

    // RECEPCIÓN DE EVENTOS
    #[On('chargeItems')]
    public function chargeItems($items)
    {
        $this->items = $items;
    }
    #[On('selectedSearchInput')]
    public function selectedSearchInput($key)
    {
        $this->selected = $this->items[$key];
        $this->showDropdown = false;
        $this->dispatch('itemSelected', $key, $this->tipo);
    }

    public function filterSearchSelect()
    {
        dd($this->items);
////        dd(array_filter($this->items, 'Sidi'));
//        // Convertir $this->items en una colección si no lo es
//        $itemsCollection = collect($this->items);
//
//        // Aplicar el filtro a la colección
//        $this->items = $itemsCollection->filter(function ($item) {
//            return str_contains($item, $this->selected);
//        });
    }

    public function render()
    {
        return view('livewire.components.atoms.select-search');
    }
}
