<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Http\Requests\debt\StoredebtRequest;
use App\Models\Debt;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    const RELATIONS = ['financial', 'category', 'external', 'bank', 'payments'];

    public function index($financial_id) : JsonResponse
    {
        $debts = Debt::where('financial_id', $financial_id)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'debts' => $debts->load($this::RELATIONS)
            ]
        ]);
    }

    public function create(Request $request, $financial_id) : JsonResponse
    {
        try {
            $debt = new Debt();
            $debt->fill($request->only([
                'description',
                'amount',
                'fee_value',
                'fee_day',
                'fee_number',
                'fee_current',
                'status',
                'category_id',
                'external_id',
                'bank_id',
            ]));
            $debt->financial_id = $financial_id;
            $debt->save();
            return response()->json([
                'success' => true,
                'msg' => 'La deuda se ha creado con éxito',
                'data' => [
                    'debt' => $debt->refresh()->load([...$this::RELATIONS, 'payments.paymentMethod'])
                ]
            ], 201);
        } catch (\Throwable $th) {
            return ReturnHelper::returnException($th);
        }
    }

    public function show(Request $request, $financial_id, $id) : JsonResponse
    {
        $debt = Debt::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$debt) return ReturnHelper::returnNotFound('La deuda no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'debt' => $debt->load([...$this::RELATIONS, 'payments.paymentMethod'])
            ]
        ]);
    }

    public function update(Request $request, $financial_id, $id) : JsonResponse
    {
        $debt = Debt::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$debt) return ReturnHelper::returnNotFound('La deuda no existe');

        try {
            $debt->update($request->only([
                'description',
                'amount',
                'fee_value',
                'fee_day',
                'fee_number',
                'fee_current',
                'status',
                'category_id',
                'external_id',
                'bank_id',
            ]));
            return response()->json([
                'success' => true,
                'msg' => 'La deuda se ha actualizado con éxito',
                'data' => [
                    'debt' => $debt->refresh()->load([...$this::RELATIONS, 'payments.paymentMethod'])
                ]
            ]);
        } catch (\Throwable $th) {
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $financial_id, $id) : JsonResponse
    {
        $debt = Debt::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$debt) return ReturnHelper::returnNotFound('La deuda no existe');

        try {
            DB::beginTransaction();
            Payment::destroy($debt->payments()->get('id')->pluck('id'));
            $debt->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'La deuda se ha eliminado con éxito',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }
}
