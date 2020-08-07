<?php

namespace Spatie\Permission\Middlewares;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckAdminPermissions
{
    public function handle($request, Closure $next, $roleOrPermission)
    {
        if (Auth::guest()) {
//            return redirect(route('home'));
            //throw UnauthorizedException::notLoggedIn();
            abort('404');
        }

        $rolesOrPermissions = is_array($roleOrPermission)
            ? $roleOrPermission
            : explode('|', $roleOrPermission);

        if (! Auth::user()->hasAnyRole($rolesOrPermissions) && ! Auth::user()->hasAnyPermission($rolesOrPermissions)) {
//            throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
            abort('404');
        }

        return $next($request);
    }
}
