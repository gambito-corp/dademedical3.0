<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tabla extends Component
{
    public function __construct(public $headers, public $data, public $sortBy, public $orderColumn, public $orderDirection, public $rowComponent)
    {
        //
    }
    public function render(): View|Closure|string
    {
        return view('components.tabla');
    }
}
