<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class Penyusutanaset extends Model
{
    protected $table = 'penyusutan_aset';

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'nominal_harga',
        'penyusutan',
        'bulan',
        'status',
        'akun_kas',
        'akun_aset',
        'akun_biaya_penyusutan',
        'akun_akumulasi_penyusutan',
        'akun_keuntungan_aset',
        'akun_kerugian_aset'
    ];

    public function detailid() {
        return $this->hasMany('App\Model\Akuntansi\Penyusutandetail', 'id_penyusutan');
    }
}
