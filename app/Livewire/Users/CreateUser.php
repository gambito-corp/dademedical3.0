<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\Users\CreateUserForm;
use App\Models\Hospital;
use Livewire\Component;
use Spatie\Permission\Models\Role;

use Livewire\WithFileUploads;
//use Livewire\TemporaryUploadedFile;

class CreateUser extends Component
{

    use WithFileUploads;

    public $hospitals;
    public $roles;
    public CreateUserForm $usuario;

    public function mount()
    {

        $this->hospitals = Hospital::query()->get()->pluck('nombre', 'id');
        $this->roles = Role::query()->get()->pluck('name', 'id');
    }

    public function close()
    {
        $this->dispatch('closeModal', 'create');
    }

    public function render()
    {
        return view('livewire.users.create-user');
    }

    public function save()
    {
        $this->usuario->save();
        $this->reset('usuario');
        $this->dispatch('closeModal', 'create');
    }
}
