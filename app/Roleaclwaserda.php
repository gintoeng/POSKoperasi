<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roleaclwaserda extends Model
{
    protected $table = 'role_acl_waserda';
    
    protected $fillable = ['role_id', 'mod_kd', 'create_acl', 'read_acl', 'update_acl', 'delete_acl'];

    public function roleid() {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function modkd() {
        return $this->belongsTo('App\Modwaserda', 'mod_kd', 'kode');
    }
}
