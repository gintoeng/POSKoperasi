<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class pengaturanAkuns extends Model
{
    protected $table = 'pengaturan_akuns';

    protected $fillable = [
        'caption',
        'status'
    ];

    public function akunheader(){
        return $this->hasMany('App\Model\Akuntansi\pengaturanAkunRelasi', 'id_header');
    }
}
