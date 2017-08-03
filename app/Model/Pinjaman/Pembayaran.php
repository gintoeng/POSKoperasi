<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran_pinjaman';

    protected $fillable = [
        'id_pinjaman',
        'nomor_transaksi',
        'bulan_ke',
        'tipe',
        'cara_bayar',
        'status',
        'tanggal',
        'tanggal_bayar',
        'saldo',
        'pokok',
        'bunga',
        'denda',
        'lain',
        'total',
        'start',
        'autodebet',
        'keterangan'
    ];

    public function pinjamanid() {
        return $this->belongsTo('App\Model\Pinjaman\Pinjaman', 'id_pinjaman');
    }

}
