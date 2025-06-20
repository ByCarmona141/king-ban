<?php

namespace Bycarmona141\KingBan\Middleware;

use ByCarmona141\KingBan\KingBan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthBanned {
    protected KingBan $kingBan;

    public function __construct(KingBan $kingBan) {
        $this->kingBan = $kingBan;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response {
        // Verifica por IP
        if ($this->kingBan->isIPBanned($request->ip())) {
            return response()->json([
                'message' => 'Acceso denegado: esta IP está baneada.'
            ], 403);
        }

        // Verifica por Token (si aplica y está presente)
        $token = $request->bearerToken();
        if ($token && $this->kingBan->isTokenBanned($token)) {
            return response()->json([
                'message' => 'Acceso denegado: este token está baneado.'
            ], 403);
        }

        // Verifica por Usuario autenticado
        if ($request->user() && $this->kingBan->isUserBanned($request->user()->id)) {
            return response()->json([
                'message' => 'Acceso denegado: este usuario está baneado.'
            ], 403);
        }

        return $next($request);
    }
}