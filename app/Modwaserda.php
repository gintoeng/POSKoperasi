<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modwaserda extends Model
{
    protected $table = 'modules_waserda';

    protected $fillable = ['kode', 'nama', 'path'];

    public function roleaclws() {
        return $this->hasMany('App\Roleaclwaserda', 'mod_id');
    }
}
