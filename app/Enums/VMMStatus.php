<?php

namespace App\Enums;

enum VMMStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case InPreparation = 'in_preparation';
    case Running = 'running';
    case Finished = 'finished';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
