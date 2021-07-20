<?php


namespace Latus\Permissions\Models;


use Illuminate\Database\Eloquent\Model;
use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Traits\HasPermissions;

abstract class ModelWithPermissible extends Model implements Permissible
{
    use HasPermissions;
}