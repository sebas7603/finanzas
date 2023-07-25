<?php

namespace App\Helpers;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

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
     * Return a Json response when the user isn't authenticated
     *
     * @param \Throwable|null $th
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnUnauthorized (Throwable $th = null) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'msg' => 'El usuario no está autenticado',
            'error' => $th ? ['message' => $th->getMessage()] : null
        ], 401);
    }

    /**
     * Return a Json response when the user isn't authorized
     *
     * @param \Throwable|null $th
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnForbidden (Throwable $th = null) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'msg' => 'El usuario no está autorizado para esta operación',
            'error' => $th ? ['message' => $th->getMessage()] : null
        ], 403);
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

    /**
     * Return a Json response when an exception was thrown
     *
     * @param \Throwable $th
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnException (Throwable $th) : JsonResponse
    {
        if ($th instanceof AuthorizationException) {
            return static::returnForbidden($th);
        }

        if ($th instanceof AuthenticationException) {
            return static::returnUnauthorized($th);
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
}
