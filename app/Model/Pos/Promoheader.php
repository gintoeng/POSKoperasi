<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Promoheader extends Model
{
    protected $table="promo_header";
    protected $fillable=[
        'type',
        'keterangan',
        'akhir_promo',
        'nama',
        'status',
        'nomdis',
        'id_cabang'
    ];
}
