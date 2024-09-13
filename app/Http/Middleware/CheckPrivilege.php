<?php

namespace App\Http\Middleware;

use App\Models\GroupPrivilege;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $page
     * @param  string  $operation
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $page = null, $operation = null)
    {
        if ($page === null || $operation === null) {
            return $next($request);
        }
        // Get the authenticated user
        $user = JWTAuth::parseToken()->authenticate();

        // Check if the user has the required privilege for the operation on the given page
        $hasPrivilege = GroupPrivilege::where('group_type_id', $user->group_type_id)
            ->where('page_name', $page)    
            ->where('operation', $operation)
            ->exists();

        if (!$hasPrivilege) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
