<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->service->register($request->validated(), Auth::user());

        return response()->json($user, 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials',
                ], 401);
            }

            return response()->json([
                'token' => $token,
            ]);
        } catch (JWTException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token',
            ], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Could not log out'], 500);
        }
    }

    public function me(): JsonResponse
    {
        return response()->json(Auth::user());
    }
}
