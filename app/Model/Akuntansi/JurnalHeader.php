<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class JurnalHeader extends Model
{
    protected $table = 'jurnal_header';

    protected $fillable = [
        'kode_jurnal',
        'tanggal',
        'keterangan',
        'status',
        'tipe'
    ];

    public function detail(){
        return $this->hasMany('App\Model\Akuntansi\JurnalDetail', 'id_header');
    }

    public function detail1(){
        return $this->hasOne('App\Model\Akuntansi\JurnalDetail', 'id_header');
    }
}
