<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileUpload extends Component
{
    public $label;
    public $name;
    public $error;
    public $value;

    public function __construct($label, $name, $error = null, $value = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->error = $error;
        $this->value = $value;
    }

    public function render(): View|Closure|string
    {
        return view('components.file-upload');
    }
}
