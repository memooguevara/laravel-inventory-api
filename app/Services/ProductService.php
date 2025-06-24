<?php

namespace App\Services;

use App\Actions\Product\CreateProduct;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\UpdateProduct;
use App\Models\Product;

class ProductService
{
    public function create(array $data): Product
    {
        return (new CreateProduct())->handle($data);
    }

    public function update(Product $product, array $data): Product
    {
        return (new UpdateProduct())->handle($product, $data);
    }

    public function delete(Product $product): void
    {
        (new DeleteProduct())->handle($product);
    }
}
