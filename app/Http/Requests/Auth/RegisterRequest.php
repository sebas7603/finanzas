<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'names' => 'required|string|min:3',
            'lastnames' => 'required|string|min:3',
            'email' => 'bail|required|string|email|min:6|unique:App\Models\User,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => 'required',
        ];
    }

    public function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'msg' => 'Errores en los datos enviados',
            'error' => [
                'fields' => $validator->errors()
            ]
        ]));
    }
}
