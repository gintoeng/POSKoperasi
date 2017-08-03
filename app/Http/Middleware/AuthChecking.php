<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthChecking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            $mod = \App\Module::where('menu_path', $role)->first();
            if ($mod != null) {
                $role = \App\RoleAcl::where('module_id', $mod->id)->where('role_id', Auth::user()->role_id)->first();
                if ($role != null) {
                    if ($role->read_acl == $mod->id) {
                        return $next($request);
                    } else {
                        return response(view('errors.200'));
                    }
                } else {
                    return response(view('errors.200'));
                }
            } else {
                return response(view('errors.404'));
            }
        } else {
            return redirect(url(''));
        }
    }
}
