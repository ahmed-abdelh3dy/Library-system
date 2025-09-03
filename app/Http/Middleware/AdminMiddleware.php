<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
   public function handle($request, Closure $next)
{
    if ($request->user() && $request->user()->role === 'admin') {
        return $next($request);
    }

    return response()->json(['message' => 'Forbidden you dont have permission to do this action'], 403);
}

}


