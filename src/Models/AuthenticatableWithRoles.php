<?php


namespace Latus\Permissions\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Traits\HasRoles;

abstract class AuthenticatableWithRoles extends Authenticatable implements Permissible
{
    use HasRoles;
}