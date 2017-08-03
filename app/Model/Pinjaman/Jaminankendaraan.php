<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminankendaraan extends Model
{
    protected $table = 'jaminan_kendaraan';

    protected $fillable = [
        'nomor_plat',
        'id_jaminan',
        'nomor_bpkb',
        'merek',
        'jenis',
        'tahun',
        'warna',
        'nomor_rangka',
        'bahan_bakar',
        'tipe',
        'model',
        'cc',
        'jumlah_roda',
        'nomor_mesin'
    ];
}
