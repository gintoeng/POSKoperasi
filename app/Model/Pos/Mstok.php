<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Mstok extends Model
{
    protected $table="mastok";
    protected $fillable=[
        'stok_awal',
        'id_produk',
        'harga_beli',
        'tanggal_expired',
        'cabang',
        'produk'
    ];
}
