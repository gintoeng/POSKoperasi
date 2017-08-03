<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class pembelianSupplierDetail extends Model
{
    protected $table = "PembelianSupplierDetail";
    protected $fillable = [
        'id',
        'id_header',
        'id_barang',
        'qty',
        'tanggal',
        'sub_total',
        'keterangan',
        'stok_sistem',
        'stok_fisik',
        'tanggal_expired'
    ];

    public function barang()
    {
        return $this->belongsTo('App\Model\Inventory\TambahProduk', 'id_barang');
    }

    public function headerid()
    {
        return $this->belongsTo('App\Model\Inventory\pembelianSupplierHeader', 'id_header');
    }

}
