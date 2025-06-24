<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
    }

    public function getProducts(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }

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

    public function createProduct(ProductRequest $request): JsonResponse
    {
        $product = $this->service->create($request->validated());

        return response()->json($product, 201);
    }

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
