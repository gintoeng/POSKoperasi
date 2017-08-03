<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table = 'roles';

  protected $fillable = ['role_name','desc', 'akses'];

  public function userid() {
    return $this->hasMany('App\User', 'role_id');
  }
  public function roleaclid() {
    return $this->hasMany('App\RoleAcl', 'role_id');
  }
  public function roleaclwsid() {
    return $this->hasMany('App\Roleaclwaserda', 'role_id');
  }

}
