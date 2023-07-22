<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'bail|required|string|email|min:6',
            'password' => 'required|min:8'
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
