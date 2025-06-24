<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();
        if (!$user || $user->role !== Role::ADMIN->value) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: You do not have permission to access this resource.',
            ], 403);
        }

        return $next($request);
    }
}
