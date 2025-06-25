<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Obtener todos los productos",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     * )
     */
    public function getProducts(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Obtener un producto por ID",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto encontrado",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     * )
     */
    public function getProductById(int $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json($product);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crear un nuevo producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Producto 1"),
     *             @OA\Property(property="description", type="string", example="Descripción del producto 1"),
     *             @OA\Property(property="price", type="number", format="float", example=19.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado exitosamente",
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
    public function createProduct(ProductRequest $request): JsonResponse
    {
        $product = $this->service->create($request->validated());

        return response()->json($product, 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/products/{id}",
     *     summary="Actualizar un producto existente",
     *     tags={"Productos"},
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
     *             @OA\Property(property="name", type="string", example="Producto 1"),
     *             @OA\Property(property="description", type="string", example="Descripción del producto 1"),
     *             @OA\Property(property="price", type="number", format="float", example=19.99),
     *             @OA\Property(property="stock", type="integer", example=100),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado exitosamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     * )
     */
    public function updateProduct(ProductRequest $request, int $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        $product = $this->service->update($product, $request->validated());

        return response()->json($product);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Producto eliminado exitosamente",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *     ),
     * )
     */
    public function deleteProduct(int $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        $this->service->delete($product);

        return response()->json(null, 204);
    }
}
