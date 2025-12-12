<?php

namespace App\Http\Middleware;

use App\Domain\User\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @since 11/12/2025
 * @author Iago Oliveira <prog.iago.oliveira@gmail.com>
 */
class AuthMiddleware
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'token não informado'], 401);
        }

        $user = $this->userRepository->findByToken($token);

        if (!$user) {
            return response()->json(['error' => 'token inválido'], 401);
        }

        $request->attributes->set('auth_user', $user);

        return $next($request);
    }
}
