<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    protected $table = 'jurnal_detail';

    protected $fillable = [
        'id_header',
        'id_transaksi',
        'id_akun',
        'debet',
        'kredit',
        'nominal',
        'posting'
    ];

    public function header(){
        return $this->belongsTo('App\Model\Akuntansi\JurnalHeader', 'id_header');
    }

    public function perkiraan(){
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'id_akun');
    }
}
