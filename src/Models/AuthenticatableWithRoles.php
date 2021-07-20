<?php


namespace Latus\Permissions\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Latus\Permissions\Models\Traits\HasRoles;

abstract class AuthenticatableWithRoles extends Authenticatable
{
    use HasRoles;
}