<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Card;
use App\Models\Movement;
use App\Models\PaymentMethod;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    const RELATIONS = ['financial', 'bank', 'cards', 'paymentMethods'];

    public function index($financial_id) : JsonResponse
    {
        $accounts = Account::withCount('movements')->where('financial_id', $financial_id)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'accounts' => $accounts->load(['bank'])
            ]
        ]);
    }

    public function create(CreateAccountRequest $request, $financial_id) : JsonResponse
    {
        try {
            DB::beginTransaction();
            // Creating account
            $account = new Account();
            $account->fill($request->all());
            $account->balance = $request->exists('movement_amount') ? $request->movement_amount : 0;
            $account->financial_id = $financial_id;
            $account->save();

            // Creating initial movement
            if ($request->movement_amount) {
                $movement = new Movement();
                $movement->financial_id = $financial_id;
                $movement->amount = $request->movement_amount;
                $movement->description = 'Saldo inicial de la cuenta';
                $movement->income = true;
                $movement->date = date('Y-m-d');
                $movement->movement_type_id = 1;
                $movement->account_id = $account->id;
                $movement->save();
            }

            // Creating Card
            if ($request->exists('card_last_numbers') && $request->card_last_numbers) {
                $card = new Card();
                $card->financial_id = $financial_id;
                $card->bank_id = $account->bank_id;
                $card->account_id = $account->id;
                $card->card_type_id = 1;
                $card->last_numbers = $request->card_last_numbers;
                $card->fee = $request->exists('card_fee') ? $request->card_fee : 0;
                $card->save();

                $cardPaymentMethod = new PaymentMethod();
                $cardPaymentMethod->name = $card->bank->name . ' - Tarjeta Débito';
                $cardPaymentMethod->card_id = $card->id;
                $cardPaymentMethod->enabled = true;
                $cardPaymentMethod->credit = false;
                $cardPaymentMethod->save();
            }

            // Creating PaymentMethod
            if ($request->exists('payment_method') && $request->payment_method) {
                $paymentMethod = new PaymentMethod();
                $paymentMethod->name = $account->bank->name . ' - Cuenta';
                $paymentMethod->account_id = $account->id;
                $paymentMethod->credit = false;
                $paymentMethod->save();
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'La cuenta se ha creado con éxito',
                'data' => [
                    'account' => $account->refresh()->load($this::RELATIONS)->loadCount('movements')
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $financial_id, $id) : JsonResponse
    {
        $account = Account::withCount('movements')->where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$account) return ReturnHelper::returnNotFound('La cuenta no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'account' => $account->load($this::RELATIONS)
            ]
        ]);
    }

    public function update(UpdateAccountRequest $request, $financial_id, $id) : JsonResponse
    {
        $account = Account::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$account) return ReturnHelper::returnNotFound('La cuenta no existe');

        try {
            DB::beginTransaction();
            $account->update([
                'number' => $request->number
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'La cuenta se ha actualizado con éxito',
                'data' => [
                    'account' => $account->refresh()->load($this::RELATIONS)
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $financial_id, $id) : JsonResponse
    {
        $account = Account::where('financial_id', $financial_id)->where('id', $id)->first();
        if (!$account) return ReturnHelper::returnNotFound('La cuenta no existe');

        // TODO: Remove Card
        // TODO: Remove PaymentMethod
        $account->delete();
        return response()->json([
            'success' => true,
            'msg' => 'La cuenta se ha eliminado con éxito',
        ]);
    }
}
