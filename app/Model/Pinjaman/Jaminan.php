<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jaminan extends Model
{
    protected $table = 'jaminan_pinjaman';

    protected $fillable = [
        'id_pinjaman',
        'jenis_jaminan',
        'ikatan_hukum',
        'nama_pemilik',
        'alamat_pemilik',
        'nilai',
        'nomor_arsip',
        'keterangan',
        'foto',
        'foto2'
    ];

    public function pinjamanid() {
        return $this->belongsTo('App\Model\Pinjaman\Pinjaman', 'id_pinjaman');
    }

    public function jenisid() {
        return $this->belongsTo('App\Model\Pinjaman\Jenisjaminan', 'jenis_jaminan');
    }
}
