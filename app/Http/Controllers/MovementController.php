<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Http\Requests\Movement\StoreMovementRequest;
use App\Models\Financial;
use App\Models\Movement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{
    const RELATIONS = ['financial', 'category', 'movementType', 'paymentMethod', 'external', 'payment', 'account', 'tags'];

    public function index($financial_id) : JsonResponse
    {
        $movements = Movement::where('financial_id', $financial_id)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'movements' => $movements->load($this::RELATIONS)
            ]
        ]);
    }

    public function create(StoreMovementRequest $request, $financial_id) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $movement = new Movement();
            $movement->fill($request->all());
            $movement->financial_id = $financial_id;
            $movement->save();
            $movement->tags()->attach($request->tags);
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'El movimiento se ha creado con éxito',
                'data' => [
                    'movement' => $movement->refresh()->load($this::RELATIONS)
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $financial_id, $id) : JsonResponse
    {
        $movement = Movement::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$movement) return ReturnHelper::returnNotFound('El movimiento no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'movement' => $movement->load($this::RELATIONS)
            ]
        ]);
    }

    public function update(StoreMovementRequest $request, $financial_id, $id) : JsonResponse
    {
        $movement = Movement::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$movement) return ReturnHelper::returnNotFound('El movimiento no existe');

        try {
            DB::beginTransaction();
            $movement->update($request->all());
            if ($request->has('tags')) {
                if (empty($request->tags)) {
                    // Remove all tags from the movement
                    $movement->tags()->detach();
                } else {
                    $movement->tags()->sync($request->tags);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'El movimiento se ha actualizado con éxito',
                'data' => [
                    'movement' => $movement->refresh()->load($this::RELATIONS)
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $financial_id, $id) : JsonResponse
    {
        $movement = Movement::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$movement) return ReturnHelper::returnNotFound('El movimiento no existe');

        $movement->tags()->detach();
        $movement->delete();
        return response()->json([
            'success' => true,
            'msg' => 'El movimiento se ha eliminado con éxito',
        ]);
    }
}
