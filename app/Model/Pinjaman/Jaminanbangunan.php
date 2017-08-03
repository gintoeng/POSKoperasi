<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminanbangunan extends Model
{
    protected $table = 'jaminan_bangunan';

    protected $fillable = [
        'nomor_sertifikat',
        'id_jaminan',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'nib',
        'peruntukan',
        'ser_hak',
        'luas_tanah'
    ];
}
