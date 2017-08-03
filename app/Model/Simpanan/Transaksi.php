<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'simpanan_transaksi';

    protected $fillable = [
        'kode',
        'tipe',
        'id_simpanan',
        'id_dari',
        'id_tujuan',
        'saldo_awal',
        'kredit',
        'debet',
        'nominal',
        'saldo_akhir',
        'tanggal',
        'status',
        'info',
        'keterangan',
        'approved'
    ];

    public function simpananid() {
       return  $this->belongsTo('App\Model\Simpanan\Simpanan', 'id_simpanan');
    }

    public function dariid() {
        return  $this->belongsTo('App\Model\Simpanan\Simpanan', 'id_dari');
    }

    public function tujuanid() {
        return  $this->belongsTo('App\Model\Simpanan\Simpanan', 'id_tujuan');
    }
}
