<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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