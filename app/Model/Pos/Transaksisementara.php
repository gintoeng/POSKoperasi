<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Transaksisementara extends Model
{
protected $table="transaksi_sementara";
protected $fillable=[
'barcode',
'harga',
'id',
'no_ref',
'produk',
'qty',
'sub_total',
'untung',
'cabang',
'diskon',
'konsinyasi',
'harga_beli'
];
}
