<?php

namespace App\Services;

use App\Actions\Category\CreateCategory;
use App\Actions\Category\DeleteCategory;
use App\Actions\Category\UpdateCategory;
use App\Models\Category;

class CategoryService
{
    public function create(array $data): Category
    {
        return (new CreateCategory())->handle($data);
    }

    public function update(Category $category, array $data): Category
    {
        return (new UpdateCategory())->handle($category, $data);
    }

    public function delete(Category $category): void
    {
        (new DeleteCategory())->handle($category);
    }
}
