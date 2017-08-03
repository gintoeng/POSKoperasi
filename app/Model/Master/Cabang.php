<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'pesawat',
        'fax',
        'nomor_rekening',
        'akun_kas',
        'akun_cabang',
        'akun_persediaan_wsd',
        'akun_piutang_wsd',
        'akun_penjualan_wsd',
        'akun_pendapatan_wsd',
        'akun_penampungan_retur',
        'akun_biaya_selisih_opname',
        'id_shu'
    ];

    public function mappingproduk() {
        return $this->belongsToMany('App\Model\Master\Barang', 'produk_mapping', 'id_cabang', 'id_produk');
    }

    public function shuid() {
        return $this->belongsTo('App\Model\Master\Katshudetail', 'id_shu');
    }
}
