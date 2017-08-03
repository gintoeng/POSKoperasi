<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleAcl extends Model
{
  protected $table = 'role_acl';

  protected $fillable = [
    'id',
    'role_id',
    'module_id',
    'create_acl',
    'read_acl',
    'update_acl',
    'delete_acl',
    'module_parent'
  ];

  public function roleid() {
    return $this->belongsTo('App\Role', 'role_id');
  }

  public function moduleid() {
    return $this->belongsTo('App\Module', 'module_id');
  }
}
