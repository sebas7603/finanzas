<?php

namespace App\Http\Controllers;

use App\Models\Financial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    public function index() : JsonResponse
    {
        $user = Auth::user();
        $financials = Financial::where('user_id', $user->id)->orderBy('created_at')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'financials' => $financials
            ]
        ]);
    }

    public function create(Request $request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $params = $request->all();
            $params['user_id'] = Auth::id();
            $financial = Financial::create($params);
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Las finanzas se han creado con éxito',
                'data' => [
                    'financial' => $financial->refresh()
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->handleException($th);
        }
    }

    public function view(Request $request, $id) : JsonResponse
    {
        $financial = Financial::find($id);
        if (!$financial) return $this->returnFinancial404();
        return response()->json([
            'success' => true,
            'data' => [
                'financial' => $financial->refresh()->load([
                    'lastBalance',
                    'movements' => function ($query) {
                        $query->limit(10);
                    }
                ])
            ]
        ]);
    }

    public function update(Request $request, $id) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $financial = Financial::find($id);
            if (!$financial) return $this->returnFinancial404();

            $financial->update($request->all());
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Las finanzas se han actualizado con éxito',
                'data' => [
                    'financial' => $financial->refresh()->load([
                        'lastBalance',
                        'movements' => function ($query) {
                            $query->limit(10);
                        }
                    ])
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->handleException($th);
        }
    }

    public function delete(Request $request, $id) : JsonResponse
    {
        $financial = Financial::find($id);
        if (!$financial) return $this->returnFinancial404();

        $financial->delete();
        return response()->json([
            'success' => true,
            'msg' => 'Las finanzas se han eliminado con éxito',
        ]);
    }

    public function returnFinancial404 () : JsonResponse
    {
        return response()->json([
            'success' => false,
            'msg' => 'Las finanzas no existen',
        ], 404);
    }

    public function handleException (\Throwable $e) : JsonResponse
    {
        $msg = 'Ups! Hubo un error inesperado';
        $code = 500;

        if ($e instanceof AuthorizationException) {
            $msg = 'El usuario no está autorizado para esta operación';
            $code = 403;
        }

        return response()->json([
            'success' => false,
            'msg' => $msg,
            'error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]
        ], $code);
    }
}
