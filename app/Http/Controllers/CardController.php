<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Http\Requests\Card\CreateCardRequest;
use App\Models\Card;
use App\Models\PaymentMethod;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    const RELATIONS = ['financial', 'account', 'bank', 'cardType', 'paymentMethods', 'payments'];

    public function index($financial_id) : JsonResponse
    {
        $cards = Card::where('financial_id', $financial_id)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'cards' => $cards->load($this::RELATIONS)
            ]
        ]);
    }

    public function create(CreateCardRequest $request, $financial_id) : JsonResponse
    {
        try {
            DB::beginTransaction();
            // Creating card
            $card = new Card();
            $card->fill($request->all());
            $card->financial_id = $financial_id;
            $card->bank_id = $request->bank_id;
            $card->account_id = $request->account_id;
            $card->card_type_id = $request->card_type_id;
            $card->quota = 0;
            $card->save();

            // Creating PaymentMethod
            $paymentMethod = new PaymentMethod();
            $paymentMethod->name = $card->bank->name . ' - ' . $card->cardType->name;
            $paymentMethod->card_id = $card->id;
            $paymentMethod->enabled = true;
            $paymentMethod->credit = $card->card_type_id == 2;
            $paymentMethod->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'La tarjeta se ha creado con éxito',
                'data' => [
                    'card' => $card->refresh()->load($this::RELATIONS)
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $financial_id, $id) : JsonResponse
    {
        $card = Card::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$card) return ReturnHelper::returnNotFound('La tarjeta no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'card' => $card->load($this::RELATIONS)
            ]
        ]);
    }

    public function update(Request $request, $financial_id, $id) : JsonResponse
    {
        $card = Card::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$card) return ReturnHelper::returnNotFound('La tarjeta no existe');

        try {
            DB::beginTransaction();
            $card->update($request->all());
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'La tarjeta se ha actualizado con éxito',
                'data' => [
                    'card' => $card->refresh()->load($this::RELATIONS)
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $financial_id, $id) : JsonResponse
    {
        $card = Card::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$card) return ReturnHelper::returnNotFound('La tarjeta no existe');

        PaymentMethod::destroy($card->paymentMethods()->get('id')->pluck('id'));
        $card->delete();
        return response()->json([
            'success' => true,
            'msg' => 'La tarjeta se ha eliminado con éxito',
        ]);
    }
}
