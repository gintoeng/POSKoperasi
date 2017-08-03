<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminantanpa extends Model
{
    protected $table = 'jaminan_tanpa';

    protected $fillable = [
        'nomor',
        'id_jaminan'
    ];
}
