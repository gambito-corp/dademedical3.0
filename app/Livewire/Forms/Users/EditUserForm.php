<?php

namespace App\Livewire\Forms\Users;

use App\Services\User\UserServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class EditUserForm extends Form
{
    public $id;
    public $name;
    public $surname;
    public $email;
    public $username;
    public $password;
    public $password_confirmation;
    public $profile_photo_path;
    public $role;
    public $hospital;
    public $active;


    protected UserServices $UserServices;

    public function boot(UserServices $UserServices)
    {
        $this->UserServices = $UserServices;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->id,
            'email' => 'required|email|max:255|unique:users,email,' . $this->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo_path' => 'nullable|image|max:1024',
            'role' => 'required|exists:roles,id',
            'hospital' => 'required|exists:hospitals,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre debe ser una cadena de texto',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres',
            'surname.required' => 'El campo apellido es requerido',
            'surname.string' => 'El campo apellido debe ser una cadena de texto',
            'surname.max' => 'El campo apellido no debe exceder los 255 caracteres',
            'email.required' => 'El campo correo es requerido',
            'email.email' => 'El campo correo debe ser un correo válido',
            'email.max' => 'El campo correo no debe exceder los 255 caracteres',
            'email.unique' => 'El correo ya se encuentra registrado',
            'username.required' => 'El campo usuario es requerido',
            'username.string' => 'El campo usuario debe ser una cadena de texto',
            'username.max' => 'El campo usuario no debe exceder los 255 caracteres',
            'username.unique' => 'El usuario ya se encuentra registrado',
            'password.required' => 'El campo contraseña es requerido',
            'password.string' => 'El campo contraseña debe ser una cadena de texto',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres',
            'profile_photo_path.image' => 'El campo foto de perfil debe ser una imagen',
            'profile_photo_path.max' => 'El campo foto de perfil no debe exceder los 1024 kilobytes',
            'role.exists' => 'El rol seleccionado no es válido',
            'hospital.exists' => 'El hospital seleccionado no es válido',
            'hospital.required' => 'El Hospital es requerido'
        ];
    }


    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $user = $this->UserServices->find($this->id);
            $data = $this->only([
                'name',
                'surname',
                'email',
                'username',
                'role',
                'hospital',
            ]);

            $save = $this->UserServices->update($user, $data);

            $this->resetInputFields();

            DB::commit();

            return true;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en EditUserForm::save: ' . $e->getMessage());
        }

        return false;
    }

    private function resetInputFields(){
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
