<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\AuthSV;

class AuthController extends BaseApi {
    protected $authSV;

    public function __construct() {
        $this->authSV = new AuthSV();
    }
    public function register(StoreUserRequest $request) {
        try {
            $params = [];
            $params = $request->only(['name', 'email', 'password']);
            $user = $this->authSV->register($params);
            return $this->SuccessResponse($user, 'User created successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function login(UserLoginRequest $request) {
        try {
            $params = [];
            $params = $request->only(['email', 'password']);
            $user = $this->authSV->login($params);
            return $user;
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function refreshToken() {
        try {
            $user = auth()->user();
            $token = $this->authSV->refreshToken($user->role);
            return $this->SuccessResponse($token, 'Token refreshed successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}