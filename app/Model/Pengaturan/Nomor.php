<?php

namespace App\Model\Pengaturan;

use Illuminate\Database\Eloquent\Model;

class Nomor extends Model
{
    protected $table = 'nomor';

    protected $fillable = [
        'modul',
        'kode_awal',
        'kode_awal2',
        'kode_awal3',
        'kode_awal4',
        'pemisah',
        'pemisah2',
        'pemisah3',
        'kode',
        'nomor_now',
        'jumlah_digit',
        'nomor_akhir'
    ];
}
