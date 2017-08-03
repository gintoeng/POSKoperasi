<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
 protected $table="produk";
protected $fillable=[
'kode',
'barcode',
'curr',
'disc',
'expired',
'ganti_harga',
'harga_beli',
'harga_jual',
'kategori',
'ket',
'nama',
'print_label',
'status',
'stok',
'classification',
'remark',
'unit',
'untung'
];
}
