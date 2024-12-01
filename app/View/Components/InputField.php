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
    public $value;
    public $disabled;

    public function __construct($name, $label, $type = 'text', $options = [], $value = null, $disabled = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->options = $options;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    public function render(): View
    {
        return view('components.input-field');
    }
}
