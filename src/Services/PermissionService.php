<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Repositories\Contracts\PermissionRepository;

class PermissionService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:5',
        'guard' => 'required|string|min:3',
    ];

    public function __construct(
        protected PermissionRepository $permissionRepository
    )
    {
    }

    public function createPermission(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->permissionRepository->create($attributes);
    }
}