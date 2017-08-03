<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminanemas extends Model
{
    protected $table = 'jaminan_emas';

    protected $fillable = [
        'nomor_sertifikat',
        'id_jaminan',
        'berat',
        'karat'
    ];
}
