<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Vehicle;
use Illuminate\Validation\Validator;

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
            'space'       => 'required|integer|min:1|max:4',
            'space_cost'  => 'required|numeric|min:0',
            'vehicle_id'  => 'required|string|exists:vehicles,plateNum',
            'status'      => 'nullable|in:active,inactive',
            'user_id'     => 'nullable|string',
        ];
    }

    /**
     * Configure the validator instance to add custom validation
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que los asientos no excedan la capacidad del vehículo
            if ($this->has('vehicle_id') && $this->has('space')) {
                $vehicle = Vehicle::where('plateNum', $this->vehicle_id)->first();
                
                if ($vehicle && $this->space > $vehicle->capacity) {
                    $validator->errors()->add(
                        'space', 
                        "Los asientos disponibles no pueden exceder la capacidad del vehículo ({$vehicle->capacity} asientos)"
                    );
                }
            }
        });
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
            'space.max'            => 'Los asientos disponibles no pueden ser más de 4',
            'space_cost.required'  => 'El costo es requerido',
            'vehicle_id.required'  => 'El vehículo es requerido',
            'vehicle_id.exists'    => 'El vehículo seleccionado no existe',
        ];
    }
}