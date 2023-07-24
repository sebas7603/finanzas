<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnHelper;
use App\Helpers\SlugHelper;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index() : JsonResponse
    {
        $user = Auth::user();
        $categories = Category::where('user_id', $user->id)->orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories
            ]
        ]);
    }

    public function create(StoreCategoryRequest $request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $category = new Category();
            $category->fill($request->all());
            $category->user_id = Auth::id();
            $category->slug = SlugHelper::getNonUniqueSlug($category, $category->name, 'user_id');
            $category->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'La categoría se ha creado con éxito',
                'data' => [
                    'category' => $category->refresh()
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
        $category = Category::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$category) return ReturnHelper::returnNotFound('La categoría no existe');

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category->refresh()
            ]
        ]);
    }

    public function update(StoreCategoryRequest $request, $slug) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $category = Category::where('user_id', $user->id)->where('slug', $slug)->first();
            if (!$category) return ReturnHelper::returnNotFound('La categoría no existe');
            if ($request->name !== $category->name) $category->slug = SlugHelper::getNonUniqueSlug($category, $request->name, 'user_id');
            $category->update($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'La categoría se ha actualizado con éxito',
                'data' => [
                    'category' => $category->refresh()
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
        $category = Category::where('user_id', $user->id)->where('slug', $slug)->first();
        if (!$category) return ReturnHelper::returnNotFound('La categoría no existe');

        $category->delete();
        return response()->json([
            'success' => true,
            'msg' => 'La categoría se ha eliminado con éxito',
        ]);
    }
}
