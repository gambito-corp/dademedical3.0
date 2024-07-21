<?php

namespace App\Livewire\Components\Atoms;

use App\Livewire\BaseComponent as Component;
class PatientsRow extends Component
{
    public $patient;
    public $keyIndex;

    public function mount($patient, $keyIndex)
    {
        $this->patient = $patient;
        $this->keyIndex = $keyIndex;
    }

    public function render()
    {
        return view('livewire.components.atoms.patients-row');
    }
}
