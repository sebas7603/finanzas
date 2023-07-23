<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\Movement\CreateMovementRequest;
use App\Http\Requests\Movement\UpdateMovementRequest;

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
        $this->authorize('create', Movement::class);
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
            return $this->handleException($th);
        }

    }

    public function view(Request $request, $id) : JsonResponse
    {
        $movement = Movement::find($id);
        if (!$movement) {
            return response()->json([
                'success' => false,
                'msg' => 'El movimiento no existe',
            ], 404);
        }

        $this->authorize('view', $movement);
        return response()->json([
            'success' => true,
            'data' => [
                'movement' => $movement->load($this::RELATIONS)
            ]
        ]);
    }

    public function update(UpdateMovementRequest $request, $id) : JsonResponse
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

            $this->authorize('update', $movement);
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
            return $this->handleException($th);
        }
    }

    public function delete(Request $request, $id) : JsonResponse
    {
        $movement = Movement::find($id);
        if (!$movement) {
            return response()->json([
                'success' => false,
                'msg' => 'El movimiento no existe',
            ], 404);
        }

        $this->authorize('delete', $movement);
        $movement->tags()->detach();
        $movement->delete();
        return response()->json([
            'success' => true,
            'msg' => 'El movimiento se ha eliminado con éxito',
        ]);
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
