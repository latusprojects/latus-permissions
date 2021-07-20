<?php


namespace Latus\Permissions\Models;


use Illuminate\Database\Eloquent\Model;
use Latus\Permissions\Models\Traits\Permissible;

abstract class ModelWithPermissible extends Model
{
    use Permissible;
}