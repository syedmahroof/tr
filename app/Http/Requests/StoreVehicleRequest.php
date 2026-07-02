<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_name' => 'required|string|max:255',
            'owner_type' => 'required|string|max:100',
            'license_plate' => 'required|string|max:50',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
            'photo' => 'nullable|image|max:5120',
        ];
    }
}
