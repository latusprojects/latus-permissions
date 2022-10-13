<?php

return [
    'default_role' => env('LATUS_DEFAULT_USER_ROLE', 'user'),
    'user_class' => env('LATUS_USER_CLASS', \Latus\Permissions\Models\User::class),
    'role_class' => env('LATUS_ROLE_CLASS', \Latus\Permissions\Models\Role::class),
    'permission_class' => env('LATUS_PERMISSION_CLASS', \Latus\Permissions\Models\Permission::class),
];