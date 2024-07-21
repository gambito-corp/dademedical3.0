<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modal extends Component
{
    public function __construct(public $show, public $title, public $content, public $footer, public $id = null, public $maxWidth = '2xl')
    {

    }
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
