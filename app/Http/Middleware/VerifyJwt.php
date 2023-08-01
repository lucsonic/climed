<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJwt
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $mensagem = 'Token de autorização não encontrado';
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $mensagem = 'Token é inválido';
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $mensagem = 'O token está expirado';
            }

            $erro = [
                'error' => [
                    'code' => 401,
                    'message' => $mensagem,
                ],
            ];

            return response()->json($erro, 401);
        }
        return $next($request);
    }
}
