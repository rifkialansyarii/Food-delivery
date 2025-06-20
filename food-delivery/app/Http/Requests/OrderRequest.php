<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'amount' => 'sometimes|required|numeric|min:0',
                'total' => 'sometimes|required|numeric|min:0',
                'location' => 'sometimes|required|string|max:255',
            ];
        }

        // Add this to ensure all paths return a value

        return [
            'user_id' => 'exists:users,id|nullable',
            'merchant_id' => 'required|exists:merchants,id',
            'menu_id' => 'required|exists:menus,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'amount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
        ];

    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
