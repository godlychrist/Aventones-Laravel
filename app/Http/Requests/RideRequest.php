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
            'name' => 'required|string|max:255',
            'origin'    => $this->isMethod('post') ? 'required|string' : 'nullable|string',
            'destination'      => 'required|string|max:255',
            'date'  => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'space_cost'     => 'required|numeric',
            'space'  => 'required|numeric',
            'user_id' => 'required',
            'vehicle_id' => 'required',
            'status' => 'required|string|max:255',
        ];
    }
}
