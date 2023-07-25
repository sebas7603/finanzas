<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Helpers\SlugHelper;
use App\Http\Requests\Bank\StoreBankRequest;
use App\Models\Bank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin', ['except' => ['index']]);
    }

    public function index() : JsonResponse
    {
        $banks = Bank::orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'banks' => $banks
            ]
        ]);
    }

    public function create(StoreBankRequest $request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $bank = new Bank();
            $bank->fill($request->all());
            $bank->slug = SlugHelper::getUniqueSlug($bank, $bank->name);
            $bank->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'El banco se ha creado con éxito',
                'data' => [
                    'bank' => $bank->refresh()
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $slug) : JsonResponse
    {
        $bank = Bank::where('slug', $slug)->first();
        if (!$bank) return ReturnHelper::returnNotFound('El banco no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'bank' => $bank->refresh()
            ]
        ]);
    }

    public function update(StoreBankRequest $request, $slug) : JsonResponse
    {
        $bank = Bank::where('slug', $slug)->first();
        if (!$bank) return ReturnHelper::returnNotFound('El banco no existe');

        try {
            DB::beginTransaction();
            if (SlugHelper::checkIfSlugNeedsChange($bank->name, $request->name)) $bank->slug = SlugHelper::getUniqueSlug($bank, $request->name);
            $bank->update($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'El banco se ha actualizado con éxito',
                'data' => [
                    'bank' => $bank->refresh()
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $slug) : JsonResponse
    {
        $bank = Bank::where('slug', $slug)->first();
        if (!$bank) return ReturnHelper::returnNotFound('El banco no existe');

        $bank->delete();
        return response()->json([
            'success' => true,
            'msg' => 'El banco se ha eliminado con éxito',
        ]);
    }
}
