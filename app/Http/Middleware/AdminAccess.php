<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class AdminAccess
{
    protected JWTAuth $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->jwtAuth->getToken();
        $user = $this->jwtAuth->toUser();

        if ($user && $user->is_admin === 1) {
            return $next($request);
        } else {
            return response()->json(['status' => 'error',
                                    'message' => 'Forbidden'],
                                    403);
        }
    }
}
