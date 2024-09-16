<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CheckPrivilege
{
    public function handle(Request $request, Closure $next, $page = null, $operation = null)
    {
        try {
            if ($page === null || $operation === null) {
                return $next($request);
            }

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $groupType = $user->groupType;

            if (!$groupType) {
                return response()->json(['error' => 'User group not found'], 404);
            }

            $hasPrivilege = $groupType->privileges()
                ->where('page_name', $page)
                ->where('operation', $operation)
                ->exists();

            if (!$hasPrivilege) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return $next($request);

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token absent'], 401);
        }
    }
}