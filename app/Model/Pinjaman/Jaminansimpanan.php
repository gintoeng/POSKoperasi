<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminansimpanan extends Model
{
    protected $table = 'jaminan_simpanan';

    protected $fillable = [
        'nomor_simpanan',
        'id_jaminan',
        'bank',
        'jumlah'
    ];
}
