<?php

namespace App\Model\Akuntansi;

use Illuminate\Database\Eloquent\Model;

class Penyusutandetail extends Model
{
    protected $table = 'penyusutan_detail';
    
    protected $fillable = [
        'id_penyusutan',
        'bulan_ke',
        'penyusutan',
        'sisa',
        'stat',
        'tanggal'
    ];
    
    public function asetid() {
        return $this->belongsTo('App\Model\Akuntansi\Penyusutanaset', 'id_penyusutan');
    }
}
