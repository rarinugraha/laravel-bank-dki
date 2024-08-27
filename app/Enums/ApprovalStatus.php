<?php

namespace App\Enums;

enum ApprovalStatus: string
{
    case MENUNGGU_APPROVAL = 'menunggu_approval';
    case DISETUJUI = 'disetujui';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU_APPROVAL => 'Menunggu Approval',
            self::DISETUJUI => 'Disetujui',
        };
    }
}
