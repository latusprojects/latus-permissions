<?php


namespace Latus\Permissions\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Latus\Permissions\Repositories\Contracts\UserRepository;

class UserService
{

    public static array $create_validation_rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email',
        'password' => 'required|string|min:10|max:255',
    ];

    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    public function createUser(array $attributes): Model
    {
        $validator = Validator::make($attributes, self::$create_validation_rules);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->userRepository->create($attributes);
    }


}