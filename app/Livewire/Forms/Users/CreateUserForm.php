<?php

namespace App\Livewire\Forms\Users;

use App\Repositories\User\UserRepository;
use App\Services\User\UserServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateUserForm extends Form
{
    use WithFileUploads;
    public $name;
    public $surname;
    public $email;
    public $username;
    public $password;
    public $password_confirmation;
    public $profile_photo_path;
    public $role = 1;
    public $hospital = 1;
    public $active = true;
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
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
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
            'role.required' => 'El campo rol es requerido',
            'role.exists' => 'El rol seleccionado no es válido',
            'hospital.required' => 'El campo hospital es requerido',
            'hospital.exists' => 'El hospital seleccionado no es válido',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->storeProfilePhoto();
            $data = $this->only([
                'name',
                'surname',
                'email',
                'username',
                'password',
                'role',
                'hospital',
                'profile_photo_path',
            ]);
            if(isset($data['role'])) {
                $data['rol'] = $data['role'];
                unset($data['role']);
            }
            if(isset($data['hospital'])) {
                $data['hospital_id'] = $data['hospital'];
                unset($data['hospital']);
            }
            $this->UserServices->create($data);
            $this->reset('name', 'surname', 'email', 'username', 'password', 'password_confirmation', 'profile_photo_path', 'role', 'hospital');
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en CreateUserForm::save: ' . $e->getMessage());
        }
        return false;
    }

    private function storeProfilePhoto()
    {
        if ($this->profile_photo_path) {
            $filename = time() . '_' . uniqid() . '.' . $this->profile_photo_path->getClientOriginalExtension();
            $this->profile_photo_path->storeAs('',$filename, 'profile_photos');
            $this->profile_photo_path = $filename;
        }
    }
}
