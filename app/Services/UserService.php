<?php

namespace App\Services;

use App\Actions\Category\CreateCategory;
use App\Actions\Category\UpdateCategory;
use App\Models\Category;
use App\Models\User;

class UserService
{
    public function register(array $data, ?User $user): User
    {
        return (new RegisterUser())->handle($data, $user);
    }
}
