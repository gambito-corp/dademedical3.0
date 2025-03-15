<?php

namespace App\Livewire\Consumibles;

use Livewire\Component;

class Consumible extends Component
{
    public function render()
    {
        $data = Consumible::query()->paginate(10);
        return view('livewire.consumibles.consumible', compact('data'));
    }
}
