<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'produk';
    protected $fillable = [
        'nama',
        'unit',
        'classification',
        'curr',
        'harga_jual',
        'harga_beli',
        'disc',
        'disc_nominal',
        'disc_tipe',
        'tanggal_awal_diskon',
        'tanggal_akhir_diskon',
        'stok',
        'stok_minimum',
        'barcode',
        'remark',
        'status',
        'expired',
        'print_label',
        'ganti_harga',
        'kategori',
        'id_cabang',
        'ket',
        'untung',
//        'id_vendor',
        'foto',
//        'adjust',
//        'no_faktur',
        'proc',
        'konsinyasi',
        'id_shu'
    ];

    public function unitid() {
        return $this->belongsTo('App\Model\Master\Unit', 'unit');
    }

    public function kategoriid() {
        return $this->belongsTo('App\Model\Master\Kategori', 'kategori');
    }

    public function matauang() {
        return $this->belongsTo('App\Model\Master\Matauang', 'curr');
    }

    public function mappingcabang() {
        return $this->belongsToMany('App\Model\Master\Cabang', 'produk_mapping', 'id_produk', 'id_cabang');
    }

    public function shuid() {
        return $this->belongsTo('App\Model\Master\Katshudetail', 'id_shu');
    }
    
}
