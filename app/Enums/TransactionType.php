<?php

namespace App\Enums;

enum TransactionType: string
{
    case Investment = 'investment';
    case Winning = 'winning';
    case Withdrawal = 'withdrawal';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
