<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Helpers\SlugHelper;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index() : JsonResponse
    {
        $user = Auth::user();
        $tags = Tag::where('user_id', $user->id)->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'tags' => $tags
            ]
        ]);
    }

    public function create(Request $request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $tag = new Tag();
            $tag->fill($request->all());
            $tag->user_id = Auth::id();
            $tag->slug = SlugHelper::getNonUniqueSlug($tag, $tag->name, 'user_id');
            $tag->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'La etiqueta se ha creado con éxito',
                'data' => [
                    'tag' => $tag->refresh()
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
        $tag = Tag::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$tag) return ReturnHelper::returnNotFound('La etiqueta no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'tag' => $tag->refresh()
            ]
        ]);
    }

    public function update(Request $request, $slug) : JsonResponse
    {
        $user = Auth::user();
        $tag = Tag::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$tag) return ReturnHelper::returnNotFound('La etiqueta no existe');

        try {
            DB::beginTransaction();
            if (SlugHelper::checkIfSlugNeedsChange($tag->name, $request->name)) $tag->slug = SlugHelper::getNonUniqueSlug($tag, $request->name, 'user_id');
            $tag->update($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'La etiqueta se ha actualizado con éxito',
                'data' => [
                    'tag' => $tag->refresh()
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
        $tag = Tag::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$tag) return ReturnHelper::returnNotFound('La etiqueta no existe');

        $tag->delete();
        return response()->json([
            'success' => true,
            'msg' => 'La etiqueta se ha eliminado con éxito',
        ]);
    }
}
