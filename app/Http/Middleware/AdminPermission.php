<?php

namespace App\Http\Middleware;

use App\Models\AdminUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $admin = auth('admin')->user();

        if (!$admin instanceof AdminUser) {
            abort(401);
        }

        abort_unless($admin->hasPermission($permission), 403);

        return $next($request);
    }
}
