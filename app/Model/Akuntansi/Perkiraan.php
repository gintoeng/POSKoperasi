<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class Perkiraan extends Model
{
    protected $table = 'perkiraan';

    protected $fillable = [
        'tipe_akun',
        'kelompok',
        'parent',
        'kode_akun',
        'nama_akun',
        'kas'
    ];

    public function jurnaldetail(){
        return $this->hasMany('App\Model\Akuntansi\JurnalDetail', 'id_akun');
    }

    public function childern(){
        return $this->hasMany('App\Model\Akuntansi\Perkiraan', 'parent', 'id');
    }
}
