<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'status' => 'required',
            'ride_id' => 'required',
            'date'  => 'required|string|max:255',
            'driver_id' => 'required',
        ];
    }
}
