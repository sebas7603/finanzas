<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Movement\CreateMovementRequest;

class MovementController extends Controller
{
    const RELATIONS = ['financial', 'category', 'movementType', 'paymentMethod', 'external', 'payment', 'account', 'tags'];

    public function index() : JsonResponse
    {
        $movements = Movement::all()->load($this::RELATIONS);
        return response()->json([
            'success' => true,
            'data' => [
                'movements' => $movements
            ]
        ]);
    }

    public function create(CreateMovementRequest $request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $movement = Movement::create($request->all());
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
            return response()->json([
                'success' => false,
                'msg' => 'Ups! Hubo un error inesperado',
                'error' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode()
                ]
            ], 500);
        }

    }

    public function view(Request $request, $id) : JsonResponse
    {
        try {
            $movement = Movement::find($id);
            if (!$movement) {
                return response()->json([
                    'success' => false,
                    'msg' => 'El movimiento no existe',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => [
                    'movement' => $movement->load($this::RELATIONS)
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'msg' => 'Ups! Hubo un error inesperado',
                'error' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode()
                ]
            ], 500);
        }
    }

    public function update(Request $request, $id) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $movement = Movement::find($id);
            if (!$movement) {
                return response()->json([
                    'success' => false,
                    'msg' => 'El movimiento no existe',
                ], 404);
            }

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
                    'movement' => $movement->load($this::RELATIONS)
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'msg' => 'Ups! Hubo un error inesperado',
                'error' => [
                    'tags' => $request->tags[0],
                    'message' => $th->getMessage(),
                    'code' => $th->getCode()
                ]
            ], 500);
        }
    }

    public function delete(Request $request, $id) : JsonResponse
    {
        try {
            $movement = Movement::find($id);
            if (!$movement) {
                return response()->json([
                    'success' => false,
                    'msg' => 'El movimiento no existe',
                ], 404);
            }

            $movement->tags()->detach();
            $movement->delete();
            return response()->json([
                'success' => true,
                'msg' => 'El movimiento se ha eliminado con éxito',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'msg' => 'Ups! Hubo un error inesperado',
                'error' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode()
                ]
            ], 500);
        }
    }
}
