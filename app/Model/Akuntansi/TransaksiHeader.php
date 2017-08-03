<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class TransaksiHeader extends Model
{
    protected $table = 'transaksi_header';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'jumlah',
        'account_card',
        'type_pembayaran',
        'kasir',
        'status'
    ];
}
