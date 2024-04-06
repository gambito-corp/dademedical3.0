<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Error extends Component
{
    public $for;

    public function __construct($for)
    {
        $this->for = $for;
    }

    public function render(): View|Closure|string
    {
        return view('components.error');
    }
}
