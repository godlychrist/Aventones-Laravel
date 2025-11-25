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
}
