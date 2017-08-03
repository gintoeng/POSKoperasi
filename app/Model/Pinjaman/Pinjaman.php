<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'nama_pinjaman',
        'nomor_pinjaman',
        'anggota',
        'sistem_bunga',
        'suku_bunga',
        'tanggal_pengajuan',
        'jumlah_pengajuan',
        'jangka_waktu',
        'jatuh_tempo',
        'jumlah_angsuran_pokok',
        'perhitungan_bunga',
        'digunakan_untuk',
        'sumber_dana',
        'kolektibilitas',
        'keterangan',
        'status_realisasi',
        'status_lunas',
        'status_pasangan',
        'status_tutup',
        'nama_pasangan',
        'pekerjaan_pasangan',
        'alamat_pasangan',
        'nomor_telepon_pasangan',
        'nama_penjamin',
        'pekerjaan_penjamin',
        'alamat_penjamin',
        'nomor_telepon_penjamin',
        'nomor_ktp_penjamin',
        're',
        'parent',
        'approved'

    ];

    public function pengaturanid() {
        return $this->belongsTo('App\Model\Pinjaman\Pengaturan', 'nama_pinjaman');
    }

    public function anggotaid() {
        return $this->belongsTo('App\Model\Master\Anggota', 'anggota');
    }

    public function kolektibilitasid() {
        return $this->belongsTo('App\Model\Master\Kolektibilitas', 'kolektibilitas');
    }

    public function jaminanid() {
        return $this->hasMany('App\Model\Pinjaman\Jaminan', 'id_pinjaman');
    }

    public function realisasiid() {
        return $this->hasOne('App\Model\Pinjaman\Realisasi', 'id_pinjaman');
    }

    public function pembayaranid() {
        return $this->hasMany('App\Model\Pinjaman\Pembayaran', 'id_pinjaman');
    }

    public function sbunga() {
        return $this->belongsTo('App\Model\Sistembunga', 'sistem_bunga');
    }
}
