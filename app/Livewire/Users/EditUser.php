<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\Users\EditUserForm;
use App\Models\User;
use App\Models\Hospital;
use App\Services\User\UserServices;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{

    public EditUserForm $usuario;
    public $hospitals;
    public $roles;
    protected UserServices $UserServices;

    public function boot(UserServices $UserServices)
    {
        $this->UserServices = $UserServices;
    }


    public function mount(User $user)
    {

        $this->usuario->id = $user->id;
        $this->usuario->hospital = $user->hospital->id;
        $this->usuario->role = $user->roles->first()->id;
        $this->usuario->name = $user->name;
        $this->usuario->surname = $user->surname;
        $this->usuario->email = $user->email;
        $this->usuario->username = $user->username;
        $this->usuario->active = $user->active;

        $this->hospitals = Hospital::query()->get()->pluck('nombre', 'id');
        $this->roles = Role::query()->get()->pluck('name', 'id');
    }

    public function close()
    {
        $this->resetInputFields();
        $this->dispatch('closeModal', 'edit', $this->usuario->id);
    }


    public function save()
    {
        $this->usuario->save();
        $this->resetInputFields();
        $this->dispatch('closeModal', 'edit', $this->usuario->id);
    }
    public function render()
    {
        return view('livewire.users.edit-user');
    }

    private function resetInputFields(){
        $this->id = '';
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->username = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->profile_photo_path = '';
        $this->role = '';
        $this->hospital = '';
        $this->active = '';
    }
}
