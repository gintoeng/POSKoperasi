<?php namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class TambahProduk extends Model
{
    protected $table = "produk";
    protected $fillable = [
    'kode',
    'barcode',
    'curr',
    'disc',
    'tanggal_awal_diskon',
    'tanggal_akhir_diskon',
    'expired',
    'ganti_harga',
    'harga_beli',
    'harga_jual',
    'kategori',
    'ket',
    'remark',
    'status',
    'nama',
    'print_label',
    'status',
//    'stok',
    'stok_minimum',
    'classification',
    'remark',
    'unit',
    'untung',
    'id_vendor',
    'foto',
//    'no_faktur',
//    'id_cabang',
        'proc',
        'id_shu'
    ];

    public function vendorid() {
        return $this->belongsTo('App\Model\Master\Vendor', 'id_vendor');
    }

    public function unitid() {
        return $this->belongsTo('App\Model\Master\Unit', 'unit');
    }

    public function mappingcabang() {
        return $this->belongsToMany('App\Model\Master\Cabang', 'produk_mapping', 'id_produk', 'id_cabang');
    }
}
