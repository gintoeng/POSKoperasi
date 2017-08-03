<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approverole extends Model
{
    protected $table = 'approvel_role';

    protected $fillable = ['id_user', 'id_for', 'for', 'level'];

    public function userid() {
        return $this->belongsTo('App\User', 'id_user');
    }
}
