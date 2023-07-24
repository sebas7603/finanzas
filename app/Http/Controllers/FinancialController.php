<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Http\Requests\Financial\StoreFinancialRequest;
use App\Models\Financial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function create(StoreFinancialRequest $request) : JsonResponse
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
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $id) : JsonResponse
    {
        $financial = Financial::find($id);
        if (!$financial) return ReturnHelper::returnNotFound('Las finanzas no existen');
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

    public function update(StoreFinancialRequest $request, $id) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $financial = Financial::find($id);
            if (!$financial) return ReturnHelper::returnNotFound('Las finanzas no existen');

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
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $id) : JsonResponse
    {
        $financial = Financial::find($id);
        if (!$financial) return ReturnHelper::returnNotFound('Las finanzas no existen');

        $financial->delete();
        return response()->json([
            'success' => true,
            'msg' => 'Las finanzas se han eliminado con éxito',
        ]);
    }
}
