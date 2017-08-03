<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class PengaturanSHUSimpan extends Model
{
    protected $table = 'pengaturanshu_simpan';

    protected $fillable = [
        'tahun',
        'jumlah_shu',
        'tanggal_pembagian',
        'dana_cadangan',
        'shu_anggota',
        'dana_pengurus',
        'dana_karyawan',
        'dana_pendidikan',
        'dana_sosial',
        'jasa_usaha',
        'jasa_modal'
    ];
}
