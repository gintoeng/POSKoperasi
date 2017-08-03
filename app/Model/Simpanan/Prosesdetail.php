<?php

namespace App\Model\Simpanan;

use Illuminate\Database\Eloquent\Model;

class Prosesdetail extends Model
{
    protected $table = 'proses_simpanan_detail';

    protected $fillable = [
        'id_proses_header',
        'id_simpanan',
        'bunga',
        'pajak',
        'diterima',
        'kena_pajak',
        'autodebet',
        'debet'
    ];

    public function simpananid() {
        return $this->belongsTo('App\Model\Simpanan\Simpanan', 'id_simpanan');
    }

    public function prosesid() {
        return $this->belongsTo('App\Model\Simpanan\Prosesheader', 'id_proses_header');
    }
}
