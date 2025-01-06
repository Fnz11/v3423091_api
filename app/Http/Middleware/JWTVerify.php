<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTVerify
{
    public function handle($request, Closure $next)
    {
        try {
            $token = null;

            // Check Authorization header first
            if ($request->header('Authorization')) {
                $token = str_replace('Bearer ', '', $request->header('Authorization'));
            }

            // Then check cookie
            if (!$token && $request->cookie('token')) {
                $token = $request->cookie('token');
            }

            // Finally check X-Auth-Token header
            if (!$token && $request->header('X-Auth-Token')) {
                $token = $request->header('X-Auth-Token');
            }

            Log::info('Token being used:', ['token' => $token]);

            if (!$token) {
                Log::warning('No token found in request');
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return redirect()->route('login');
            }

            try {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();
                if (!$user) {
                    throw new \Exception('User not found');
                }
                
                // Add user to request
                $request->merge(['user' => $user]);
                return $next($request);

            } catch (TokenExpiredException $e) {
                return response()->json(['error' => 'Token expired'], 401);
            } catch (TokenInvalidException $e) {
                return response()->json(['error' => 'Token invalid'], 401);
            }
        } catch (\Exception $e) {
            Log::error('JWT Verification failed:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
