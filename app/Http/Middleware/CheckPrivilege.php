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
        // Set the guard to API to ensure JSON responses
        auth()->shouldUse('api');

        try {
            // Check if token exists
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['error' => 'Token not provided'], 401);
            }

            // Attempt to authenticate the token
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // If page and operation are not defined, proceed without privilege check
            if ($page === null || $operation === null) {
                return $next($request);
            }

            // Get user group type and check privileges
            $groupType = $user->groupType;

            if (!$groupType) {
                return response()->json(['error' => 'User group not found'], 404);
            }

            // Check if the user has the required privilege
            $hasPrivilege = $groupType->privileges()
                ->where('page_name', $page)
                ->where('operation', $operation)
                ->exists();

            if (!$hasPrivilege) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }

            // Proceed to the next middleware/request
            return $next($request);

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is absent or malformed'], 401);
        }
    }
}
