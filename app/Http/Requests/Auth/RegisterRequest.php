<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8', \Illuminate\Validation\Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => [__('Please enter your name.')],
            'email.required' => [__('Please enter your email.')],
            'password.required' => [__('Please enter your password.')],
            'username.required' => [__('Please enter your username.')],
            'username.unique' => [__('This username has already been taken.')],
            'email.email' => [__('Please enter a valid email address.')],
            'email.unique' => [__('This email address is already registered.')],
            'password.confirmed' =>[ __('The passwords do not match.')],
            'password.min' => [__('Password must be at least 8 characters.')],
        ];
    }

}
