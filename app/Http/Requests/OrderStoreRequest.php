<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id', 
            'payment_method_id' => 'required|integer|exists:payment_methods,id', 
            'status' => 'required|string|in:Pending,In Process, Completed, Canceled', 
            'address' => 'required|string', 
            'total' => 'required|numeric'
        ];
    }
}
