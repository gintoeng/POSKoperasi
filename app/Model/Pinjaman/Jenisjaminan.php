<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Jenisjaminan extends Model
{
    protected $table = 'jenis_jaminan';

    protected $fillable = [
        'jenis',
        'tabel'
    ];
}
