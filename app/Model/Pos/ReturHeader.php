<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class ReturHeader extends Model
{
    protected $table="retur_header";
    protected $fillable=[
        'id',
        'noref',
        'jumlah',
        'tanggal',
        'type_pembayaran',
        'kasir',
        'status',
        'kategori',
        'no_kartu',
        'cabang'
    ];
}
