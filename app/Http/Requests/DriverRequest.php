<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cedula'    => $this->isMethod('post') ? 'required|numeric' : 'nullable|numeric',
            'name'      => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'birthDate' => 'required|date',
            'email'     => 'required|email|max:255',
            'phoneNum'  => 'required|numeric',
            'image'     => 'nullable|file',
            'password'  => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'cedula.required'    => 'La cédula es requerida',
            'cedula.numeric'     => 'La cédula debe ser numérica',
            'name.required'      => 'El nombre es requerido',
            'name.max'           => 'El nombre no puede exceder 255 caracteres',
            'lastname.required'  => 'El apellido es requerido',
            'lastname.max'       => 'El apellido no puede exceder 255 caracteres',
            'birthDate.required' => 'La fecha de nacimiento es requerida',
            'birthDate.date'     => 'La fecha de nacimiento debe ser una fecha válida',
            'email.required'     => 'El correo electrónico es requerido',
            'email.email'        => 'El correo electrónico debe ser válido',
            'email.max'          => 'El correo electrónico no puede exceder 255 caracteres',
            'phoneNum.required'  => 'El número de teléfono es requerido',
            'phoneNum.numeric'   => 'El número de teléfono debe ser numérico',
            'password.required'  => 'La contraseña es requerida',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres',
            'image.file'         => 'El archivo debe ser una imagen válida',
        ];
    }
}
