<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class POSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $role = Role::find(Auth::user()->role_id);
            if ($role->akses == "pos" || $role->akses == "kasir") {
                return $next($request);
            } else {
                return response(view('errors.200'));
            }
        } else {
            return redirect(url('/login'));
        }
    }
}
