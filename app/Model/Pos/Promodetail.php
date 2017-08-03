<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Promodetail extends Model
{
    protected $table="promo_detail";
    protected $fillable=[
        'no_promo',
        'produk',
        'qty',
        'keterangan'
    ];
}
