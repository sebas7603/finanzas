<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El :attribute debe ser aceptado.',
    'accepted_if' => 'El :attribute debe ser aceptado cuando :other es :value.',
    'active_url' => 'La :attribute no es una URL válida.',
    'array' => 'Los :attribute deben ser un listado.',
    'between' => [
        'array' => 'El :attribute debe tener entre :min y :max items.',
        'file' => 'El :attribute debe tener entre :min y :max kilobytes.',
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'string' => 'El :attribute debe tener entre :min y :max caracteres.',
    ],
    'boolean' => 'El :attribute debe ser verdadero o falso.',
    'confirmed' => 'La confirmación del :attribute no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'La :attribute no es una fecha válida.',
    'distinct' => 'Los :attribute tienen un valor duplicado.',
    'email' => 'El :attribute no es un email válido.',
    'exists' => 'El :attribute seleccionado no existe.',
    'max' => [
        'array' => 'El :attribute no debe tenér mas de :max items.',
        'file' => 'El :attribute no debe tener más de :max kilobytes.',
        'numeric' => 'El :attribute no debe tener un valor mayor a :max.',
        'string' => 'El :attribute no debe tener más de :max caracteres.',
    ],
    'min' => [
        'array' => 'El :attribute debe tener al menos :min items.',
        'file' => 'El :attribute debe tener al menos :min kilobytes.',
        'numeric' => 'El :attribute debe ser mayor o igual a :min.',
        'string' => 'El :attribute debe tener al menos :min caracteres.',
    ],
    'missing' => 'El :attribute no debe estar en el request.',
    'numeric' => 'El :attribute debe ser un número.',
    'password' => [
        'letters' => 'La contraseña debe tener al menos una letra.',
        'mixed' => 'La contraseña debe tener mayúsculas y minúsculas.',
        'numbers' => 'La contraseña debe tener al menos un número.',
        'symbols' => 'La contraseña debe tener al menos un símbolo.',
        'uncompromised' => 'La contraseña ingresada se encuentra en un data leak',
    ],
    'prohibited_if' => 'El :attribute es prohibido si el :other es :value.',
    'prohibited_unless' => 'El :attribute es prohibido a menos que el :other sea :values.',
    'regex' => 'El :attribute no tiene un formato válido.',
    'required' => 'El :attribute es obligatorio.',
    'required_if' => 'El :attribute es obligatorio si el :other es :value.',
    'required_unless' => 'El :attribute es obligatorio si el :other es diferente a :values.',
    'required_without' => 'El :attribute es obligatorio cuando el :values es nulo.',
    'size' => [
        'array' => 'El :attribute debe tener :size items.',
        'file' => 'El :attribute debe tener :size kilobytes.',
        'numeric' => 'El :attribute debe ser :size.',
        'string' => 'El :attribute debe tener :size caracteres.',
    ],
    'string' => 'El :attribute debe ser un string.',
    'unique' => 'Ya existe un usuario con este :attribute.',
    'url' => 'La :attribute debe ser una URL válida.',
];
