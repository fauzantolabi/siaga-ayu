<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil role user dari relasi role_id → roles.role_name
        $userRole = auth()->user()->role->role_name ?? null;

        // Jika role user tidak termasuk dalam daftar yang diizinkan
        if (!$userRole || !in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
