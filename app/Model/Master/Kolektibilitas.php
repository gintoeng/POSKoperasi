<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Kolektibilitas extends Model
{
    protected $table = 'kolektibilitas';
    protected $fillable = [
        'kode',
        'keterangan',
        'batas_hari'
    ];
}
