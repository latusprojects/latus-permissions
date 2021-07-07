<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Repositories\Contracts\RoleRepository;

class RoleService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:5',
        'level' => 'required|integer|min:0|max:65556',
    ];

    public function __construct(
        protected RoleRepository $roleRepository
    )
    {
    }

    public function createRole(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->roleRepository->create($attributes);
    }


}