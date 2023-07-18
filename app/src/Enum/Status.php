<?php

namespace App\Enum;

enum Status: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case BLOCKED = 'blocked';

    public static function toValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
