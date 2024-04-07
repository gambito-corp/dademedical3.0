<?php

namespace App\Livewire\Components\Atoms;

use Livewire\Component;

class InputText extends Component
{
    public $name;
    public $label;
    public $error;
    public $columns = 4;
    public $success = false;
    public $value;
	public $live = null;
	public $lazy = null;

    public function render()
    {
        return view('livewire.components.atoms.input-text');
    }
}
