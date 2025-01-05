<?php

declare(strict_types=1);

namespace App\SocialNetwork\UI\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

final class JWTAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token || $token === 'null') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $decoded = JWT::decode(
                $token,
                new Key(Config::get('auth.jwt_secret'), 'HS256'),
            );

            $request->merge(['user_id' => $decoded->sub]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['error' => 'Invalid JWT token'], 401);
        }

        return $next($request);
    }
}