<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = [
        'jenis_tabungan',
        'nomor_tabungan',
        'nasabah',
        'marketing',
        'suku_bunga',
        'tanggal_pembuatan',
        'setoran_bulanan',
        'jangka_waktu',
        'status',
        'tanggal_status',
        'keterangan',
        'saldo_blokir'
    ];
}
