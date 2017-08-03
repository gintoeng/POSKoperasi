<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Transaksidetail extends Model
{
protected $table="transaksi_detail";
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
'cabang',
'untung',
'konsinyasi',
'harga_beli',
 'diskon',
    'stat',
    'bayarstat'
];

}
