<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ubah 'admin,guru' jadi ['admin', 'guru']
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }

        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}