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
            $financial = new Financial();
            $financial->fill($request->all());
            $financial->user_id = Auth::id();
            $financial->save();
            return response()->json([
                'success' => true,
                'msg' => 'Las finanzas se han creado con éxito',
                'data' => [
                    'financial' => $financial->refresh()
                ]
            ], 201);
        } catch (\Throwable $th) {
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $id) : JsonResponse
    {
        $financial = Financial::find($id);
        if (!$financial) return ReturnHelper::returnNotFound('Las finanzas no existen');

        $this->authorize('view', $financial);
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
        $financial = Financial::find($id);
        if (!$financial) return ReturnHelper::returnNotFound('Las finanzas no existen');

        $this->authorize('update', $financial);
        try {
            $financial->update($request->all());
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
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $id) : JsonResponse
    {
        $financial = Financial::find($id);
        if (!$financial) return ReturnHelper::returnNotFound('Las finanzas no existen');

        $this->authorize('delete', $financial);
        $financial->delete();
        return response()->json([
            'success' => true,
            'msg' => 'Las finanzas se han eliminado con éxito',
        ]);
    }
}
