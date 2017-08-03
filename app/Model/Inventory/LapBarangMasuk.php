<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class LapBarangMasuk extends Model
{
    protected $table = 'produkin';
    protected $fillable=[
        'barcode',
        'nama',
        'merk',
        'tanggal',
        'expired',
        'qty',
        'harga',
        'sub_harga',
        'cabang'
    ];
}
