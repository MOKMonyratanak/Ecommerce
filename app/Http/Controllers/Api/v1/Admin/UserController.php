<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserSV;

class UserController extends BaseApi {
    protected $userSV;

    public function __construct() {
        $this->userSV = new UserSV();
    }

    public function getUser($global_id) {
        try {
            $user = $this->userSV->getUser($global_id);
            return $this->SuccessResponse($user, 'User fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function getAllUsers() {
        try {
            $users = $this->userSV->getAllUsers();
            return $this->SuccessResponse($users, 'Users fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function createUser(StoreUserRequest $request) {
        try {
            $params = [];
            $params = $request->only(['name', 'email', 'password', 'role']);
            $user = $this->userSV->createUser($params);
            return $this->SuccessResponse($user, 'User created successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function updateUser(UpdateUserRequest $request, $global_id) {
        try {
            $params = [];
            $params = $request->only(['name', 'email', 'password', 'role']);
            $user = $this->userSV->updateUser($global_id, $params);
            return $this->SuccessResponse($user, 'User updated successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function deleteUser($global_id) {
        try {
            $user = $this->userSV->deleteUser($global_id);
            return $this->SuccessResponse($user, 'User deleted successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}