<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Transaksiheader extends Model
{
protected $table="transaksi_header";
protected $fillable=[
'id',
'noref',
'jumlah',
'tanggal',
'type_pembayaran',
'kasir',
'status',
'kategori',
'diskon',
'no_kartu',
'cabang'
];

    public function cabangid()
    {
        return $this->belongsTo('App\Model\Master\Cabang','cabang');
    }

    public function anggotaid() {
        return $this->belongsTo('App\Model\Master\Anggota','no_kartu', 'npk');
    }
}
