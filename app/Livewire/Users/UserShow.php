<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class UserShow extends Component
{
    public User $user;

    public function close()
    {
        $this->dispatch('closeModal', 'show', $this->user->id);
    }

    public function render()
    {
        return view('livewire.users.user-show');
    }
}
