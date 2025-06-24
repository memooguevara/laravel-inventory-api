<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function getCategoryById(int $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json($category);
    }

    public function createCategory(CategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    public function updateCategory(CategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
        $category->update($request->validated());

        return response()->json($category);
    }

    public function deleteCategory(int $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
        $category->delete();

        return response()->json(null, 204);
    }
}
