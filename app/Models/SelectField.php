<?php

namespace App\Models;

class SelectField extends FormField
{
    public $options;

    public function __construct($nombre, $id, $options, $placeholder = '', $value = '', $required = false, $eloquentModel = null)
    {
        parent::__construct($nombre, $id, 'select', $placeholder, $value, $required, $eloquentModel);
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
