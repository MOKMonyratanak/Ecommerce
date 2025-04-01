<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\AuthSV;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

    public function logout()
    {
        try {
            // Get the currently authenticated user
            $user = auth()->user();

            // Determine the guard based on the user's role
            $guard = $user->role === 'admin' ? 'api' : 'api-user';
    
            // Logout the user by invalidating the token
            Auth::guard($guard)->logout();
    
            return $this->SuccessResponse(null, 'Logout successful');
        } catch (\Exception $e) {
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

    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            // Use stateless() to avoid session issues in API routes
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->user();
    
            // Check if the user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
    
            if (!$user) {
                // Register the user if they don't exist
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('default_password'), // Set a default password
                    'role' => 'user', // Default role
                ]);
            }
    
            // Generate a JWT token for the user
            $token = Auth::guard('api-user')->login($user);
    
            // Return the token and user details
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to login via Google: ' . $e->getMessage()], 500);
        }
    }
}