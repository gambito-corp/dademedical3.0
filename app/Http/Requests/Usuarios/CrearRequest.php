<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class CrearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hospital_id' => 'required|exists:hospitals,id',
            'rol' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'hospital_id.required' => 'El Hospital es Requerido',
            'hospital_id.exists' => 'El Hospital no Existe',
            'name.required' => 'El Nombre es Requerido',
            'name.string' => 'El Nombre debe ser un Texto',
            'name.max' => 'El Nombre no debe ser mayor a 255 Caracteres',
            'surname.required' => 'El Apellido es Requerido',
            'surname.string' => 'El Apellido debe ser un Texto',
            'surname.max' => 'El Apellido no debe ser mayor a 255 Caracteres',
            'email.required' => 'El Correo es Requerido',
            'email.email' => 'El Correo debe ser un Correo Valido',
            'email.unique' => 'El Correo ya Existe',
            'username.required' => 'El Usuario es Requerido',
            'username.string' => 'El Usuario debe ser un Texto',
            'username.max' => 'El Usuario no debe ser mayor a 255 Caracteres',
            'username.unique' => 'El Usuario ya Existe',
            'password.required' => 'La Contraseña es Requerida',
            'password.min' => 'La Contraseña debe tener al menos 8 Caracteres',
            'password.confirmed' => 'La Contraseña no Coincide',
            'password_confirmation.required' => 'La Confirmacion de la Contraseña es Requerida',
        ];
    }
}
