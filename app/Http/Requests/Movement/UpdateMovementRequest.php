<?php

namespace App\Http\Requests\Movement;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateMovementRequest extends FormRequest
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
            'financial_id' => 'bail|required|exists:App\Models\Financial,id',
            'amount' => 'bail|required|numeric|min:500',
            'description' => 'bail|required|string|min:5',
            'income' => 'nullable|boolean',
            'date' => 'nullable|date',
            'movement_type_id' => 'bail|required|exists:App\Models\MovementType,id',
            'category_id' => 'bail|nullable|required_unless:movement_type_id,1|exists:App\Models\Category,id',
            'payment_method_id' => 'bail|nullable|required_unless:movement_type_id,1|exists:App\Models\PaymentMethod,id',
            'external_id' => 'bail|nullable|required_if:movement_type_id,3|exists:App\Models\External,id',
            'payment_id' => 'bail|nullable|prohibited_if:movement_type_id,1|exists:App\Models\Payment,id',
            'account_id' => 'bail|nullable|required_unless:movement_type_id,3|exists:App\Models\Account,id',
            'tags' => 'bail|nullable|array',
            'tags.*' => 'bail|distinct|exists:App\Models\Tag,id',
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
            'amount' => 'valor',
            'description' => 'descripción',
            'income' => 'ingreso',
            'date' => 'fecha del movimiento',
            'movement_type_id' => 'tipo de movimiento',
            'category_id' => 'categoría',
            'payment_method_id' => 'método de pago',
            'external_id' => 'tercero',
            'payment_id' => 'pago',
            'account_id' => 'cuenta',
            'tags' => 'etiquetas',
            'tags.*' => 'etiqueta',
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
            'financial_id.required' => 'Debe tener asignado unas finanzas.',
            'financial_id.exists' => 'Las finanzas asignadas no existen.',
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción es inválida.',
            'description.min' => 'La descripción debe tener al menos :min caracteres.',
            'category_id.required_unless' => 'La categoría es obligatoria si el movimiento es diferente a "ingreso".',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'payment_method_id.required_unless' => 'El método de pago es obligatorio si el movimiento es diferente a "ingreso".',
            'external_id.required_if' => 'El tercero es obligatorio si el tipo de movimiento es "crédito".',
            'payment_id.prohibited_if' => 'El pago es prohibido si el tipo de movimiento es "ingreso".',
            'account_id.required_unless' => 'La cuenta es obligatoria si el movimiento es diferente a "crédito".',
            'account_id.exists' => 'La cuenta seleccionada no existe.',
            'tags.array' => 'Las etiquetas deben ser un listado.',
            'tags.*.distinct' => 'La etiqueta se encuentra duplicada.',
            'tags.*.exists' => 'La etiqueta no existe.',
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
