<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Obtener todas las categorías",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorías",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     * )
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Obtener una categoría por ID",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría encontrada",
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Categoría no encontrada",
     *     ),
     *     @OA\Response(
     *       response=401,
     *       description="No autorizado",
     *     ),
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Crear una nueva categoría",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Electronics"),
     *             @OA\Property(property="description", type="string", example="Category for electronic products"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada exitosamente",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *     ),
     * )
     */
    public function createCategory(CategoryRequest $request): JsonResponse
    {
        $category = $this->service->create($request->validated());

        return response()->json($category, 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/categories/{id}",
     *     summary="Actualizar una categoría existente",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Electronics"),
     *             @OA\Property(property="description", type="string", example="Category for electronic products"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada exitosamente",
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Categoría no encontrada",
     *     ),
     * )
     */
    public function updateCategory(CategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
        $category = $this->service->update($category, $request->validated());

        return response()->json($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Eliminar una categoría",
     *     tags={"Categorías"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Categoría eliminada exitosamente",
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="Categoría no encontrada",
     *     ),
     * )
     */
    public function deleteCategory(int $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
        $this->service->delete($category);

        return response()->json(null, 204);
    }
}
