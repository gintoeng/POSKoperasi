<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Katshuheader extends Model
{
    protected $table = 'kategori_shu_header';
    
    protected $fillable = ['kode','nama'];
    
    public function detailshu() {
        return $this->hasMany('App\Model\Master\Katshudetail', 'id_header');
    }
}
