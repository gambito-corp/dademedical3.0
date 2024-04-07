<?php

namespace App\Livewire\Components\Layout;

use Livewire\Attributes\On;
use Livewire\Component;

class SideBar extends Component
{
    public $isOpen = true;
    public $first = true;
    public $hide = false;

    public function render()
    {
        return view('livewire.components.layout.side-bar');
    }

    #[On('toggleAside')]
    public function toggleAside()
    {
        $this->isOpen = !$this->isOpen;
        $this->first = false;
        $this->dispatch('hideLinksAside');
    }

    #[On('hideLinksAside')]
    public function hideLinksAside()
    {
        $this->first = false;
        $this->hide = !$this->hide;
    }
}
