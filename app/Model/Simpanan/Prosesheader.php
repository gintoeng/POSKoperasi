<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Prosesheader extends Model
{
    protected $table = 'proses_simpanan_header';

    protected $fillable = [
        'tanggal_proses',
        'bulan',
        'tahun',
        'shunya',
        'keterangan',
        'autodebet',
        'tanggal_awal',
        'tanggal_akhir'
    ];

    public function detailid() {
        return $this->hasMany('App\Model\Simpanan\Prosesdetail', 'id_proses_header');
    }

}
