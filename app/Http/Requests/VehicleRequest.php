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
            'capacity' => 'required|integer|min:1|max:4',    // Máximo 4 pasajeros
            'image'    => 'nullable|image|max:2048',   // opcional
        ];
    }

    public function messages(): array
    {
        return [
            'plateNum.required' => 'El número de placa es requerido',
            'plateNum.numeric'  => 'El número de placa debe ser numérico',
            'color.required'    => 'El color es requerido',
            'color.max'         => 'El color no puede exceder 255 caracteres',
            'brand.required'    => 'La marca es requerida',
            'brand.max'         => 'La marca no puede exceder 255 caracteres',
            'model.required'    => 'El modelo es requerido',
            'model.max'         => 'El modelo no puede exceder 255 caracteres',
            'year.required'     => 'El año es requerido',
            'year.date'         => 'El año debe ser una fecha válida',
            'capacity.required' => 'La capacidad es requerida',
            'capacity.integer'  => 'La capacidad debe ser un número entero',
            'capacity.min'      => 'La capacidad mínima es 1 pasajero',
            'capacity.max'      => 'La capacidad máxima es 4 pasajeros',
            'image.image'       => 'El archivo debe ser una imagen',
            'image.max'         => 'La imagen no puede exceder 2MB',
        ];
    }
}
