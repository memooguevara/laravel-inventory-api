<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function displayName(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::USER => 'User',
        };
    }
}

