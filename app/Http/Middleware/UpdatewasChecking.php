<?php

namespace App\Http\Middleware;

use App\Modwaserda;
use App\Roleaclwaserda;
use Closure;
use Illuminate\Support\Facades\Auth;

class UpdatewasChecking
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
            $mod = Modwaserda::where('path', $role)->first();
            $role = Roleaclwaserda::where('mod_kd', $mod->kode)->where('role_id', Auth::user()->role_id)->first();
            if ($role != null) {
                if ($role->update_acl == $mod->kode) {
                    return $next($request);
                } else {
                    return response(view('errors.200'));
                }
            } else {
                return response(view('errors.200'));
            }
        } else {
            return redirect(url('/login'));
        }
    }
}
