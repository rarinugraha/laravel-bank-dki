<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case SUPERVISI = 'supervisi';
    case CS = 'cs';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::SUPERVISI => 'Supervisi',
            self::CS => 'Customer Service'
        };
    }
}
