<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'min:5'],
            'message' => ['required', 'min:10'],
            'services_id' => ['required', 'exists:services,id'],
        ];

    }
    public function attributes(): array
    {
        return [
            'services_id' => 'services',
        ];
        
    }
}
