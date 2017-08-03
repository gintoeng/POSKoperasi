<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Akumulasi extends Model
{
    protected $table = 'simpanan_akumulasi';

    protected $fillable = [
        'id_simpanan',
        'saldo',
        'outs'
    ];
}
