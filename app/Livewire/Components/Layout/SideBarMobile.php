<?php

namespace App\Livewire\Components\Layout;

use Livewire\Component;
use Livewire\Attributes\On;

class SideBarMobile extends Component
{
    public $isOpen = false;
    public $first = true;

    public function render()
    {
        return view('livewire.components.layout.side-bar-mobile');
    }

    #[On('toggleSidebar')]
    public function toggleSidebar()
    {
        $this->isOpen = !$this->isOpen;
        $this->first = false;
    }
}
