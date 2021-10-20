<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BlockRestrictedUsers
{
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::guard($guard)->user();

        if ($user->is_banned) {
            return redirect('/perfil/usuario-bloqueado');
        } elseif (!$user->is_approved) {
            return redirect('/perfil/aprobacion-pendiente');
        }

        return $next($request);
    }
}
