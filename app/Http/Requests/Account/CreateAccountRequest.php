<?php

namespace App\Http\Requests\Account;

use App\Helpers\ReturnHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CreateAccountRequest extends FormRequest
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
            'financial_id' => 'missing',
            'bank_id' => 'bail|required|numeric|exists:App\Models\Bank,id',
            'number' => 'bail|required|regex:/^[0-9]+$/|min:6',
            'balance' => 'missing',
            'movement_amount' => 'bail|nullable|numeric|min:500',
            'payment_method' => 'bail|nullable|boolean',
            'card_last_numbers' => 'bail|nullable|regex:/^[0-9]+$/|size:4',
            'card_fee' => 'bail|nullable|numeric|min:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'financial_id' => 'finanzas',
            'bank_id' => 'banco',
            'number' => 'número de cuenta',
            'balance' => 'saldo de la cuenta',
            'movement_amount' => 'saldo inicial',
            'payment_method' => 'método de pago',
            'card_last_numbers' => 'últimos 4 dígitos de la tarjeta',
            'card_fee' => 'cuota de manejo de la tarjeta',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'financial_id.missing' => 'Las finanzas no deben estar en el request.',
            'number.regex' => 'El número de cuenta solo debe tener números.',
            'card_last_numbers.regex' => 'Los últimos 4 dígitos de la tarjeta solo pueden ser números.',
            'card_last_numbers.size' => 'Los últimos 4 dígitos de la tarjeta deben ser cuatro.',
            'card_fee.numeric' => 'La cuota de manejo de la tarjeta debe ser un número.',
            'card_fee.min' => 'La cuota de manejo de la tarjeta debe ser mayor o igual a 500.',
        ];
    }

    public function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(ReturnHelper::returnBadRequest($validator));
    }
}
