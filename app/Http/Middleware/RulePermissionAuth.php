<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RulePermissionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $auth =  auth('sanctum');
        $user =  $auth->user();
        if(!$auth->check() || $user->rule_id==null || $user->rule_id<0 || !in_array($user->rule_id, $roles)){
            return response()->json([
                'error' => "You don't have any permission!",
            ], 403);
        }
        return $next($request);
    }
}
