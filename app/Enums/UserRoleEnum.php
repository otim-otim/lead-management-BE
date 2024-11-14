<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case SALESMANAGER = 'sales_manager';
    case SALESREP = 'sales_rep';

    /**
     * Get all enum values as an array
     *
     * @return array
     */
    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
