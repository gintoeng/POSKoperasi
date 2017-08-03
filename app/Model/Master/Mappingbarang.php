<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Mappingbarang extends Model
{
    protected $table = 'produk_mapping';
    
    protected $fillable = [
        'id_produk',
        'id_cabang',
        'stok'
    ];
    
    public function produkid() {
        return $this->belongsTo('App\Model\Master\Barang', 'id_produk');
    }
    
    public function cabangid() {
        return $this->belongsTo('App\Model\Master\Cabang', 'id_cabang');
    }
}
