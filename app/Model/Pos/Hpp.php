<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Hpp extends Model
{
    protected $table="hpp";
    protected $fillable=[
        'produk',
        'id_produk',
        'persedian_awal',
        'qty_persediaan',
        'pembelian',
        'qty_pembelian',
        'hpp_unit',
        'hpp_asli',
        'tanggal',
        'penjualan',
        'qty_penjualan',
        'stok_akhir',
        'cabang'
    ];
}
