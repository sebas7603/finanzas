<?php

namespace App\Http\Requests\Subscription;

use App\Helpers\ReturnHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreSubscriptionRequest extends FormRequest
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
            'description' => 'bail|filled|string|min:5',
            'amount' => 'bail|filled|numeric|min:500',
            'day' => 'bail|filled|integer|between:1,30',
            'month' => 'bail|nullable|integer|between:1,12',
            'category_id' => 'bail|filled|exists:App\Models\Category,id',
            'external_id' => 'bail|filled|exists:App\Models\External,id',
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
            'description' => 'descripción',
            'amount' => 'valor de la suscripción',
            'day' => 'día de pago',
            'month' => 'mes de pago',
            'category_id' => 'categoría',
            'external_id' => 'tercero',
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
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción es inválida.',
            'description.min' => 'La descripción debe tener al menos :min caracteres.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }

    public function failedValidation(Validator $validator) : JsonResponse
    {
        throw new HttpResponseException(ReturnHelper::returnBadRequest($validator));
    }
}
