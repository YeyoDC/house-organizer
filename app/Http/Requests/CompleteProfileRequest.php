<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteProfileRequest extends FormRequest
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
            'displayName' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // 2MB max
        ];
    }
    public function messages(): array
    {
        return [
            'displayName.required' => 'Please enter your display name.',
            'phone.required' => 'Please enter your phone number.',
            'phone.numeric' => 'The phone number must be numeric.',
            // add other custom messages for your rules here
        ];
    }
}
