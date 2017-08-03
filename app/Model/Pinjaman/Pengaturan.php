<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan_pinjaman';

    protected $fillable = [
        'kode',
        'nama_pinjaman',
        'suku_bunga',
        'sistem_bunga',
        'maksimum_waktu',
        'tipe_maksimum_waktu',
        'tipe_denda_perhari',
        'jumlah_denda_perhari',
        'persen_denda_perhari',
        'toleransi_denda',
        'akun_kas_bank',
        'akun_realisasi',
        'akun_angsuran',
        'akun_bunga',
        'akun_administrasi',
        'akun_administrasi_bank',
        'akun_administrasi_tambahan',
        'akun_denda',
        'biaya_provinsi',
        'akun_lain_lain',
        'akun_hapus_pinjaman',
        'akun_piutang_pinjaman',
        'akun_tampungan_pinjaman',
        'akun_piutang_tak_tertagih',
        'kode_awal_rekening',
        'jumlah_digit_rekening',
        'nomor_akhir_rekening',
        'gambar',
        'gambar2',
        'id_shu',
        'tipe_pinjaman',
        'biaya_admin_bank',
        'biaya_admin_fee',
        'biaya_admin_tambahan'
    ];

    public function sbunga() {
        return $this->belongsTo('App\Model\Sistembunga', 'sistem_bunga');
    }

    public function apkas() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_kas_bank');
    }

    public function aprealisasi() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_realisasi');
    }

    public function apangsuran() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_angsuran');
    }

    public function apbunga() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_bunga');
    }

    public function apadministrasi() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_administrasi');
    }

    public function apdenda() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_denda');
    }

    public function shuid() {
        return $this->belongsTo('App\Model\Master\Katshudetail', 'id_shu');
    }

    public function approvinsi() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'biaya_provinsi');
    }

    public function aplain() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_lain_lain');
    }

    public function aphapus() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_hapus_pinjaman');
    }

    public function docid() {
        return $this->hasMany('App\Attach', 'id_pengaturan');
    }

    public function approveroleid() {
        return $this->hasMany('App\Approverole', 'id_for');
    }
}
