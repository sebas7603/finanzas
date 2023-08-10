<?php

namespace App\Http\Requests\Card;

use App\Helpers\ReturnHelper;
use App\Models\Card;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Closure;

class UpdateCardRequest extends FormRequest
{
    protected ?Card $card;

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
        $this->card = Card::find($this->route('id'));
        return [
            'financial_id' => 'missing',
            'bank_id' => 'missing',
            'card_type_id' => 'missing',
            'last_numbers' => 'bail|filled|regex:/^[0-9]+$/|size:4',
            'account_id' => 'missing',
            'quota' => 'missing',
            'amount' => [
                'bail',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->card && $this->card->card_type_id != 2 && $this->exists($attribute)) {
                        $fail('El cupo no debe estar en el request');
                    }
                },
                'filled',
                'numeric',
                'min:500',
            ],
            'fee' => 'bail|nullable|numeric|min:0',
            'balance_day' => [
                'bail',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->card && $this->card->card_type_id != 2 && $this->exists($attribute)) {
                        $fail('El día de corte no debe estar en el request');
                    }
                },
                'filled',
                'numeric',
                'between:1,30',
            ],
            'payment_day' => [
                'bail',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->card && $this->card->card_type_id != 2 && $this->exists($attribute)) {
                        $fail('El día límite de pago no debe estar en el request');
                    }
                },
                'filled',
                'numeric',
                'between:1,30',
            ],
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
            'last_numbers.filled' => 'Los últimos 4 dígitos de la tarjeta son obligatorios.',
            'last_numbers.regex' => 'Los últimos 4 dígitos de la tarjeta solo pueden ser números.',
            'last_numbers.size' => 'Los últimos 4 dígitos de la tarjeta deben ser cuatro.',
            'account_id.missing' => 'La cuenta no debe estar en el request.',
            'fee.numeric' => 'La cuota de manejo de la tarjeta debe ser un número.',
            'fee.min' => 'La cuota de manejo de la tarjeta debe ser mayor o igual a :min.',
        ];
    }

    public function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(ReturnHelper::returnBadRequest($validator));
    }
}
