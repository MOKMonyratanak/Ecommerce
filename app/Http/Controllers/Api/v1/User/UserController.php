<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserSV;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserSV $userService)
    {
        $this->userService = $userService;
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();

            // Ensure the user has the 'user' role
            if ($user->role !== 'user') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Update the user's profile using the UserSV service
            $updatedUser = $this->userService->updateUser($user->global_id, $request->all());

            return response()->json([
                'message' => 'Profile updated successfully',
                'data' => $updatedUser,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function viewProfile()
    {
        try {
            $user = auth()->user();

            // Ensure the user has the 'user' role
            if ($user->role !== 'user') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Fetch the user's profile using the UserSV service
            $userProfile = $this->userService->getUserByID($user->id);

            return response()->json([
                'message' => 'Profile fetched successfully',
                'data' => $userProfile,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    

}