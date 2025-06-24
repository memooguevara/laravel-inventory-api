<?php

namespace App\Actions\User;

use App\Enums\Role;
use App\Models\Product;
use App\Models\User;

class RegisterUser
{
    public function handle(array $data, ?User $authUser): User
    {
        $isAdmin = $authUser && $authUser->role === Role::ADMIN->value;
        $role = ($isAdmin && isset($data['role']))
            ? $data['role']
            : Role::USER->value;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $role,
        ]);
    }
}
