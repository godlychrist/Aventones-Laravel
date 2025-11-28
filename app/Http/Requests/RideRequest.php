<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'origin'      => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required|date_format:H:i',
            'space'       => 'required|integer|min:1',
            'space_cost'  => 'required|numeric|min:0',
            'vehicle_id'  => 'required|string|exists:vehicles,plateNum',
            'status'      => 'nullable|in:active,inactive',
            'user_id'     => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'El nombre es requerido',
            'origin.required'      => 'El origen es requerido',
            'destination.required' => 'El destino es requerido',
            'date.required'        => 'La fecha es requerida',
            'time.required'        => 'La hora es requerida',
            'space.required'       => 'Los espacios son requeridos',
            'space_cost.required'  => 'El costo es requerido',
            'vehicle_id.required'  => 'El vehículo es requerido',
            'vehicle_id.exists'    => 'El vehículo seleccionado no existe',
        ];
    }
}