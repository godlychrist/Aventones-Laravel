<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plateNum' => 'required|numeric',          // en tu BD es int(11)
            'color'    => 'required|string|max:255',
            'brand'    => 'required|string|max:255',
            'model'    => 'required|string|max:255',
            'year'     => 'required|date',             // tu campo es DATE
            'capacity' => 'required|integer|min:1',    // int(11)
            'image'    => 'nullable|image|max:2048',   // opcional
        ];
    }
}
