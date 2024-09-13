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

    /**
     * Crea una nueva instancia del componente.
     *
     * @param string $name
     * @param string $label
     * @param string $type
     * @param array $options
     * @param mixed $value
     * @param bool $disabled
     */
    public function __construct($name, $label, $type = 'text', $options = [], $value = null, $disabled = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->options = $options;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    /**
     * Obtiene la vista que representa el componente.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.input-field');
    }
}
