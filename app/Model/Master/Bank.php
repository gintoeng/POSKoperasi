<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    protected $fillable = [
        'kode',
        'nama_bank',
        'mata_uang',
        'keterangan'
    ];

    public function matauang() {
        return $this->belongsTo('App\Model\Master\Matauang', 'mata_uang');
    }

}
