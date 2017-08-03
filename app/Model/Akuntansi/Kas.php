<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $table = 'kas';

    protected $fillable = [
        'id_akun',
        'keterangan',
        'tanggal',
        'jumlah',
        'tipe'
    ];

    public function kperkiraan() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'id_akun');
    }
}
