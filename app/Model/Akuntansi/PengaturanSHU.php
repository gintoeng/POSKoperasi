<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class PengaturanSHU extends Model
{
    protected $table = 'pengaturan_shu';

    protected $fillable = [
        'dana_cadangan',
        'shu_anggota',
        'dana_pengurus',
        'dana_karyawan',
        'dana_pendidikan',
        'dana_sosial',
        'dana_pembangunan',
        'dana_lain2',
        'jasa_usaha',
        'jasa_modal',
        'tahun',
        'jumlah_shulabarugi',
        'tanggal_pembagian'
    ];
}
