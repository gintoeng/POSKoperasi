<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Autoheader extends Model
{
    protected $table = 'autodebet_pinjaman_header';

    protected $fillable = [
        'tanggal_proses',
        'bulan',
        'tahun',
        'shunya',
        'keterangan',
        'tanggal_awal',
        'tanggal_akhir'
    ];

    public function detailid() {
        return $this->hasMany('App\Model\Pinjaman\Autodetail', 'id_auto_header');
    }
}
