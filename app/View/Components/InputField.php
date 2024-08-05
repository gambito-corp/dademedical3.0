<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputField extends Component
{
    public $name;
    public $label;
    public $type;
    public $options;

    public function __construct($name, $label, $type = 'text', $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->options = $options;
    }

    public function render(): View
    {
        return view('components.input-field');
    }
}
