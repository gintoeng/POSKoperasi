<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attach extends Model
{
    protected $table = 'attach_doc';

    protected $fillable = [
        'id_anggota',
        'id_pengaturan',
        'keterangan',
        'doc',
        'mime'
    ];

    public function anggotaid() {
        return $this->belongsTo('App\Master\Anggota', 'id_anggota');
    }

    public function pengaturanid() {
        return $this->belongsTo('App\Pinjaman\Pengaturan', 'id_pengaturan');
    }
}
