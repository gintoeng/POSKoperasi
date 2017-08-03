<?php

namespace App\Model\Pengaturan;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $table = 'profil';

    protected  $fillable = [
        'nama_koperasi',
        'alamat_koperasi',
        'keterangan',
        'telepon',
        'foto',
        'kode_pos',
        'nomor_rekening',
        'kode'
    ];
}
