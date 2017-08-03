<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Kolektif extends Model
{
    protected $table = 'simpanan_kolektif';

    protected $fillable = [
        'tipe',
        'id_simpanan',
        'nominal',
        'tanggal',
        'keterangan'
    ];

    public function simpananid() {
        return  $this->belongsTo('App\Model\Simpanan\Simpanan', 'id_simpanan');
    }
}
