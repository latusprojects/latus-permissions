<?php

namespace Latus\Permissions\Helpers;

class Classes
{
    public static function user(): string
    {
        return config('latus-permissions.user_class');
    }

    public static function role(): string
    {
        return config('latus-permissions.role_class');
    }

    public static function permission(): string
    {
        return config('latus-permissions.permission_class');
    }
}