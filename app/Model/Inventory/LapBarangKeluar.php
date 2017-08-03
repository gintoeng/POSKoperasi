<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class LapBarangKeluar extends Model
{
protected $table="produkout";
protected $fillable=[
'barcode',
'nama',
'harga_beli',
'tanggal',
'expired',
'id_cabang',
'jenis_pembayaran',
'qty',
'sub_total'
];
}
