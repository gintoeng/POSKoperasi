<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminanelektronik extends Model
{
    protected $table = 'jaminan_elektronik';

    protected $fillable = [
        'nomor_serial',
        'id_jaminan',
        'tipe',
        'merek'
    ];
}
