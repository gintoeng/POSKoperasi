<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aksestutup extends Model
{
    protected $table = 'akses_tutup';
    
    protected $fillable = ['id_user', 'id_for', 'tutup', 'jenis', 'tipecs'];

    public function userid() {
        return $this->belongsTo('App\User', 'id_user');
    }
}
