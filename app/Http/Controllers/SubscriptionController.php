<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    const RELATIONS = ['financial', 'category', 'external', 'payments'];

    public function index($financial_id) : JsonResponse
    {
        $subscriptions = Subscription::where('financial_id', $financial_id)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'subscriptions' => $subscriptions->load($this::RELATIONS)
            ]
        ]);
    }

    public function create(StoreSubscriptionRequest $request, $financial_id) : JsonResponse
    {
        try {
            $subscription = new Subscription();
            $subscription->fill($request->only([
                'description',
                'amount',
                'day',
                'month',
                'category_id',
                'external_id',
            ]));
            $subscription->financial_id = $financial_id;
            $subscription->save();
            return response()->json([
                'success' => true,
                'msg' => 'La suscripción se ha creado con éxito',
                'data' => [
                    'subscription' => $subscription->refresh()->load([...$this::RELATIONS, 'payments.paymentMethod'])
                ]
            ], 201);
        } catch (\Throwable $th) {
            return ReturnHelper::returnException($th);
        }
    }

    public function show(Request $request, $financial_id, $id) : JsonResponse
    {
        $subscription = Subscription::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$subscription) return ReturnHelper::returnNotFound('La suscripción no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'subscription' => $subscription->load($this::RELATIONS)
            ]
        ]);
    }

    public function update(StoreSubscriptionRequest $request, $financial_id, $id) : JsonResponse
    {
        $subscription = Subscription::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$subscription) return ReturnHelper::returnNotFound('La suscripción no existe');

        try {
            $subscription->update($request->only([
                'description',
                'amount',
                'day',
                'month',
                'category_id',
                'external_id',
            ]));
            return response()->json([
                'success' => true,
                'msg' => 'La suscripción se ha actualizado con éxito',
                'data' => [
                    'subscription' => $subscription->refresh()->load([...$this::RELATIONS, 'payments.paymentMethod'])
                ]
            ]);
        } catch (\Throwable $th) {
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $financial_id, $id) : JsonResponse
    {
        $subscription = Subscription::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$subscription) return ReturnHelper::returnNotFound('La suscripción no existe');

        try {
            DB::beginTransaction();
            Payment::destroy($subscription->payments()->get('id')->pluck('id'));
            $subscription->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'La suscripción se ha eliminado con éxito',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }
}
