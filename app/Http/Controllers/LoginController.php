<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\GeneratesAuthAccessCredentials;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use GeneratesAuthAccessCredentials;

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate(function ($request) {
            return $this->getAuthenticatedUser($request);
        });

        [$accessToken, $expiresAt] = $this->generateAccessCredentialsFor($user);

        return $this->jsonResponse(HTTP_SUCCESS, 'Login successful', [
            'token' => $accessToken,
            'expires_at' => $expiresAt,
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->jsonResponse(HTTP_SUCCESS, 'User logged out successfully.');
    }

    private function getAuthenticatedUser(LoginRequest $request): ?User
    {
        if (! $user = User::where('email', $request->email)->first()) {
            return null;
        }

        return Hash::check($request->password, $user->password) ? $user : null;
    }
}
