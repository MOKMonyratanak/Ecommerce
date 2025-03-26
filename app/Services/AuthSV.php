<?php

namespace App\Services;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthSV extends BaseService {
    public function getQuery() {
        return User::query();
    }

    public function register($data) {
        $query = $this->getQuery();
        $user = $query->create($data);
        return $user;
    }

    public function login($data) {
        $credentials = $data;
        $token = Auth::guard('api-user')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = Auth::guard('api-user')->user();
        return $this->respondWithToken($token, $user,'user');
    }

    public function refreshToken(String $role) {
        $token = JWTAuth::getToken();
        if (!$token) {
            throw new \Exception('Token not provided');
        }
        try {
            if ($role == 'user') {
                $newToken = Auth::guard('api-user')->setTTL(ttl: config('jwt.refresh_ttl'))->refresh();
            }
            else if ($role == 'admin') {
                $newToken = Auth::guard('api')->setTTL(ttl: config('jwt.refresh_ttl'))->refresh();
            }
        }
        catch (\Exception $e) {
            throw new \Exception('Token is invalid');
        }
        return $this->respondWithToken($newToken);
    }
    protected function respondWithToken($token, $user = null, $role) {
        $expires_in = Auth::guard('api-user')->factory()->getTTL() * 60;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'data' => [
                'user' => $user,
            ],
            'expires_in_second' => $expires_in
        ]);
    }

    protected function respondWithRefreshToken($token, $user = null) {
        return response()->json([
            'refresh_token' => $token,
            'token_type' => 'bearer',
            'expires_in_seconds' => config('jwt.refresh_ttl') * 60
        ]);
    }
}

