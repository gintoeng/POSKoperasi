<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class TabunganTransaksi extends Model
{
    protected $table = 'tabungan_transaksi';

    protected $fillable = [
        'kode',
        'tipe',
        'id_tabungan',
        'id_dari',
        'id_tujuan',
        'saldo_awal',
        'debet',
        'kredit',
        'nominal',
        'tanggal',
        'status',
        'keterangan'
    ];
}
