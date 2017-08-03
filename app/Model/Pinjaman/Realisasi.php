<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{
    protected $table = 'realisasi_pinjaman';

    protected $fillable = [
        'id_pinjaman',
        'tanggal_realisasi',
        'suku_bunga',
        'jangka_waktu',
        'biaya_administrasi',
        'biaya_administrasi_bank',
        'biaya_administrasi_tambahan',
        'biaya_provinsi',
        'biaya_lain',
        'realisasi',
        'uang_diterima',
        'angsuran',
        'keterangan'
    ];

    public function pinjamanid() {
        return $this->belongsTo('App\Model\Pinjaman\Pinjaman', 'id_pinjaman');
    }

}
