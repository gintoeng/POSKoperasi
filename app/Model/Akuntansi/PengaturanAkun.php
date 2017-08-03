<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class PengaturanAkun extends Model
{
    protected $table = 'pengaturan_akun';

    protected $fillable = [
        'laba_tahun_berjalan',
        'laba_tahun_sebelumnya',
        'dana_cadangan',
        'jasa_usaha',
        'jasa_modal',
        'dana_pengurus',
        'dana_karyawan',
        'dana_pendidikan',
        'dana_sosial',
        'dana_pembangunan',
        'dana_lain2',
        'tipe_akun'
    ];
}
