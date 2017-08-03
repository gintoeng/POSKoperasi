<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class pengaturanAkunRelasi extends Model
{
    protected $table = 'pengaturan_akun_relasi';

    protected $fillable = [
        'id_header',
        'id_detail',
        'id_akun'
    ];

    public function akunheaderdrdetail(){
        return $this->belongsTo('App\Model\Akuntansi\pengaturanAkuns', 'id_detail');
    }
}
