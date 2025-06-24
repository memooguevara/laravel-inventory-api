<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => [
                'sometimes',
                function ($attribute, $value, $fail) use ($user) {
                    if (!$user || $user->role !== Role::ADMIN->value) {
                        $fail("You do not have permission to set the {$attribute}.");
                    }
                    if (!in_array($value, array_column(Role::cases(), 'value'))) {
                        $fail("The {$attribute} must be one of the following: " . implode(', ', array_column(Role::cases(), 'value')));
                    }
                }
            ]
        ];
    }
}
