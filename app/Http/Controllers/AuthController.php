<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => [
                'sometimes',
                function ($attribute, $value, $fail) use ($user) {
                    if (!$user || $user->role !== Role::ADMIN->value) {
                        $fail("You do not have permission to set the {$attribute}.");
                    }
                    if (!in_array($value, array_column(Role::cases(), 'value'))) {
                        $fail("The {$attribute} must be one of the following: " . implode(', ', array_column(Role::cases(), 'value')));
                    }
                }
            ]
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $role = ($user && $user->role === Role::ADMIN->value && $request->filled('role'))
            ? $request->role
            : Role::USER->value;
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $role,
        ]);

        return response()->json($newUser, 201);
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
