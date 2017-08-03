<?php

namespace App\Policies;

use Auth;
use App\User;
use App\RoleAcl;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // public function getUser(User $user, RoleAcl $role_acl)
    // {
    //   $role_acl = RoleAcl::where('role_id',Auth::user()->role_id)->where('module_id',7)->first();
    //   return Auth::user()->role_id === $role_acl->role_id;
    // }
}
