<?php

namespace App\Enums;

enum FollowUpStatusEnum
{
    case PENDING;
    case COMPLETED;
    case MISSED;
   

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }
}