<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\LoginResource;
use App\Http\Requests\Login\LoginRequest;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(LoginRequest $request): JsonResponse
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            /** @var User $user */
            $user = auth()->user();
            $token = $user->createToken('appToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => new LoginResource($user),
            ]);
        }

        return response()->json([
            'errors' => [
                'email' => 'Access denied',
            ],
        ], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successfully',
        ]);
    }

    public function user(): LoginResource|JsonResponse
    {
        return new LoginResource(auth()->user());
    }
}
