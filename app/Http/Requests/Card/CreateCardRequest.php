<?php

namespace App\Http\Requests\Card;

use App\Helpers\ReturnHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CreateCardRequest extends FormRequest
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
            'bank_id' => 'bail|required|exists:App\Models\Bank,id',
            'card_type_id' => 'bail|required|exists:App\Models\CardType,id',
            'last_numbers' => 'bail|required|regex:/^[0-9]+$/|size:4',
            'account_id' => 'bail|required_if:card_type_id,1|prohibited_unless:card_type_id,1|exists:App\Models\Account,id',
            'quota' => 'missing',
            'amount' => 'bail|required_if:card_type_id,2|prohibited_unless:card_type_id,2|numeric|min:500',
            'fee' => 'bail|nullable|numeric|min:500',
            'balance_day' => 'bail|required_without:payment_day|prohibited_unless:card_type_id,2|numeric|between:1,30',
            'payment_day' => 'bail|required_without:balance_day|prohibited_unless:card_type_id,2|numeric|between:1,30',
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
            'card_type_id' => 'tipo de tarjeta',
            'last_numbers' => 'últimos 4 dígitos de la tarjeta',
            'account_id' => 'cuenta',
            'quota' => 'valor a pagar',
            'amount' => 'cupo',
            'card_fee' => 'cuota de manejo de la tarjeta',
            'balance_day' => 'día de corte',
            'payment_day' => 'día límite de pago',
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
            'last_numbers.required' => 'Los últimos 4 dígitos de la tarjeta son obligatorios.',
            'last_numbers.regex' => 'Los últimos 4 dígitos de la tarjeta solo pueden ser números.',
            'last_numbers.size' => 'Los últimos 4 dígitos de la tarjeta deben ser cuatro.',
            'account_id.required_if' => 'La cuenta es obligatoria si es una tarjeta Débito.',
            'account_id.prohibited_unless' => 'La cuenta es prohibida a menos que sea una tarjeta Débito.',
            'account_id.exists' => 'La cuenta seleccionada no existe.',
            'amount.required_if' => 'El cupo es obligatorio si es una tarjeta de Crédito.',
            'amount.prohibited_unless' => 'El cupo es prohibido a menos que sea una tarjeta de Crédito.',
            'fee.numeric' => 'La cuota de manejo de la tarjeta debe ser un número.',
            'fee.min' => 'La cuota de manejo de la tarjeta debe ser mayor o igual a 500.',
            'balance_day.prohibited_unless' => 'El día de corte es prohibido a menos que sea una tarjeta de Crédito.',
            'payment_day.prohibited_unless' => 'El día límite de pago es prohibido a menos que sea una tarjeta de Crédito.',
        ];
    }

    public function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(ReturnHelper::returnBadRequest($validator));
    }
}
