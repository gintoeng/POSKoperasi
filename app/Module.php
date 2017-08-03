<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  protected $table = 'modules';

  protected $fillable = [
    'menu_parent',
    'module_name',
    'menu_mask',
    'menu_path',
    'menu_icon',
    'menu_order',
    'divider'
  ];

  public function roleaclid() {
    return $this->hasMany('App\RoleAcl', 'module_id');
  }
}
