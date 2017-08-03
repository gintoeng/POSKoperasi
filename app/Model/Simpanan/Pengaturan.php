<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan_simpanan';

    protected $fillable = [
        'kode',
        'jenis_simpanan',
        'suku_bunga',
        'sistem_bunga',
        'saldo_minimum_bunga',
        'saldo_minimum',
        'setoran_minimum',
        'saldo_minimum_pajak',
        'saldo_minimum_shu',
        'menerima_shu',
        'administrasi',
        'autodebet',
        'persen_pajak',
        'akun_kas_bank',
        'akun_setoran',
        'akun_penarikan',
        'akun_bunga',
        'akun_administrasi',
        'akun_pajak',
        'kode_awal_rekening',
        'jumlah_digit_rekening',
        'nomor_akhir_rekening',
        'id_shu',
        'autocreate',
        'wajibpokok',
        'pokokstat'
    ];

    public function sbunga() {
        return $this->belongsTo('App\Model\Sistembunga', 'sistem_bunga');
    }

    public function apkas() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_kas_bank');
    }

    public function apsetoran() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_setoran');
    }

    public function appenarikan() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_penarikan');
    }

    public function apbunga() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_bunga');
    }


    public function apadministrasi() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_administrasi');
    }

    public function appajak() {
        return $this->belongsTo('App\Model\Akuntansi\Perkiraan', 'akun_pajak');
    }

    public function simpananid() {
        return $this->hasMany('App\Model\Simpanan\Simpanan', 'jenis_simpanan');
    }
    
    public function approveroleid() {
        return $this->hasMany('App\Approverole', 'id_for');
    }

    public function shuid() {
        return $this->belongsTo('App\Model\Master\Katshudetail', 'id_shu');
    }
    
}
