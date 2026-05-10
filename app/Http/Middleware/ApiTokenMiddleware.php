<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['message' => 'Non authentifié. Token manquant.'], 401);
        }

        $user = User::where('api_token', hash('sha256', $token))->first();
        
        if (!$user) {
            return response()->json(['message' => 'Non authentifié. Token invalide.'], 401);
        }

        $request->merge(['api_user' => $user]);

        return $next($request);
    }
}
