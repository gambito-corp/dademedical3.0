<?php

namespace App\Livewire\Components\Organism;

use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
{
    public $showNotifications = false;
    public $notifications;

    public function render()
    {

        return view('livewire.components.organism.notifications');
    }

    #[On('toggleNotifications')]
    public function toggleNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
    }

    public function closeNotifications()
    {
        $this->showNotifications = false;
    }
}
