<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'jenis_simpanan',
        'nomor_simpanan',
        'anggota',
        'suku_bunga',
        'sistem_bunga',
        'tanggal_pembuatan',
        'setoran_bulanan',
        'jangka_waktu',
        'status',
        'tanggal_status',
        'saldo_blokir',
        'keterangan'
    ];

    public function pengaturanid() {
        return $this->belongsTo('App\Model\Simpanan\Pengaturan', 'jenis_simpanan');
    }

    public function anggotaid() {
        return $this->belongsTo('App\Model\Master\Anggota', 'anggota');
    }

    public function akumulasiid() {
        return $this->hasOne('App\Model\Simpanan\Akumulasi', 'id_simpanan');
    }

    public function transaksi(){
        return $this->hasMany('App\Model\Simpanan\Transaksi', 'id_simpanan');
    }

    public function sbunga() {
        return $this->belongsTo('App\Model\Sistembunga', 'sistem_bunga');
    }
}
