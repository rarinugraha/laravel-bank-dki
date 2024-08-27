<?php

namespace App\Enums;

enum Gender: string
{
    case LAKI_LAKI = 'laki-laki';
    case WANITA = 'wanita';

    public function label(): string
    {
        return match ($this) {
            self::LAKI_LAKI => 'Laki-Laki',
            self::WANITA => 'Wanita',
        };
    }
}
