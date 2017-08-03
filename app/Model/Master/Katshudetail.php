<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Katshudetail extends Model
{
    protected $table = 'kategori_shu_detail';

    protected $fillable = [
        'id_header',
        'nama',
        'masuk_shu',
        'percent',
        'fieldnya'
    ];

    public function headershu() {
        return $this->belongsTo('App\Model\Master\Katshuheader', 'id_header');
    }
}
