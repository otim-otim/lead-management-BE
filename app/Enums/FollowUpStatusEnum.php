<?php

namespace App\Enums;

enum FollowUpStatusEnum:string
{
    case PENDING = 'Pending';
    case COMPLETED = 'Completed';
    case MISSED = 'Missed';
   

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}