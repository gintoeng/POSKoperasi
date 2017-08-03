<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class ReturDetail extends Model
{
    protected $table="detail_retur";
    protected $fillable=[
        'id',
        'produk',
        'qty',
        'harga',
        'sub_total',
        'barcode',
        'no_ref',
        'kasir',
        'tanggal',
        'cabang'
    ];
}