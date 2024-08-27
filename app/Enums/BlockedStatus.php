<?php

namespace App\Enums;

enum BlockedStatus: int
{
    case TERBLOKIR = 0;
    case TIDAK_TERBLOKIR = 1;

    public function label(): string
    {
        return match ($this) {
            self::TERBLOKIR => 'Terblokir',
            self::TIDAK_TERBLOKIR => 'Tidak Terblokir',
        };
    }
}
