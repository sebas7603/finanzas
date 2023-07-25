<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Helpers\SlugHelper;
use App\Http\Requests\External\StoreExternalRequest;
use App\Models\External;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExternalController extends Controller
{
    public function index() : JsonResponse
    {
        $user = Auth::user();
        $externals = External::where('user_id', $user->id)->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'externals' => $externals
            ]
        ]);
    }

    public function create(StoreExternalRequest $request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $external = new External();
            $external->fill($request->all());
            $external->user_id = Auth::id();
            $external->slug = SlugHelper::getNonUniqueSlug($external, $external->name, 'user_id');
            $external->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'El tercero se ha creado con éxito',
                'data' => [
                    'external' => $external->refresh()
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function view(Request $request, $slug) : JsonResponse
    {
        $user = Auth::user();
        $external = External::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$external) return ReturnHelper::returnNotFound('El tercero no existe');
        $this->authorize('view', $external);

        return response()->json([
            'success' => true,
            'data' => [
                'external' => $external->refresh()
            ]
        ]);
    }

    public function update(StoreExternalRequest $request, $slug) : JsonResponse
    {
        $user = Auth::user();
        $external = External::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$external) return ReturnHelper::returnNotFound('El tercero no existe');
        $this->authorize('update', $external);

        try {
            DB::beginTransaction();
            if (SlugHelper::checkIfSlugNeedsChange($external->name, $request->name)) $external->slug = SlugHelper::getNonUniqueSlug($external, $request->name, 'user_id');
            $external->update($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'El tercero se ha actualizado con éxito',
                'data' => [
                    'external' => $external->refresh()
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return ReturnHelper::returnException($th);
        }
    }

    public function delete(Request $request, $slug) : JsonResponse
    {
        $user = Auth::user();
        $external = External::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$external) return ReturnHelper::returnNotFound('El tercero no existe');
        $this->authorize('delete', $external);

        $external->delete();
        return response()->json([
            'success' => true,
            'msg' => 'El tercero se ha eliminado con éxito',
        ]);
    }
}
