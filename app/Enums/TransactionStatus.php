<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
