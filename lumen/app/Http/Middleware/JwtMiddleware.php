<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Usuarios;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        
        if(!$token) {
            // Erro 401 caso o token não tenha sido enviado via Bearer Token
            return response()->json([
                'erro' => 'Você não possui autorização para utilizar esta funcionalidade.'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'O token expirou. Favor fazer o login novamente.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Um erro aconteceu ao tentar verficar o usuário. Talvez a assinatura esteja errada.'
            ], 400);
        }

        $user = Usuarios::find($credentials->sub);

        // Vamos colocar o usuário no request para que a gente consiga pegar ele através do auth
        $request->auth = $user;

        return $next($request);
    }
}