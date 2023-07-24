<?php

namespace App\Helpers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Throwable;

class ReturnHelper
{
    /**
     * Return a Json response when a bad request was received
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnBadRequest (Validator $validator) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'msg' => 'Errores en los datos enviados',
            'error' => [
                'fields' => $validator->errors()
            ]
        ], 400);
    }

    /**
     * Return a Json response when an exception was thrown
     *
     * @param \Throwable $th
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnException (Throwable $th) : JsonResponse
    {
        if ($th instanceof AuthorizationException) {
            return response()->json([
                'success' => false,
                'msg' => 'El usuario no está autorizado para esta operación',
                'error' => [
                    'message' => $th->getMessage()
                ]
            ], 403);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Ups! Hubo un error inesperado',
            'error' => [
                'class' => get_class($th),
                'message' => $th->getMessage(),
                'code' => $th->getCode(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTrace()
            ]
        ], 500);
    }

    /**
     * Return a Json response when a resource hasn't been found
     *
     * @param  string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnNotFound ($msg = 'El recurso solicitado no existe') : JsonResponse
    {
        return response()->json([
            'success' => false,
            'msg' => $msg,
        ], 404);
    }
}
