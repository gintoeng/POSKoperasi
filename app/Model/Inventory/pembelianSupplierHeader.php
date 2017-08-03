<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class pembelianSupplierHeader extends Model
{
    protected $table = "PembelianSupplierHeader";

    protected $fillable = [
        'id',
        'nopembelian',
        'id_cabang',
        'id_vendor',
        'status',
        'tanggal',
        'tipe',
        'nofaktur',
        'start',
        'invoice',
        'id_terima',
        'jenis_retur',
        'receive',
        'tanggal_kirim',
        'approved'
    ];

    public function detail(){
        return $this->hasMany('App\Model\Inventory\pembelianSupplierDetail', 'id_header');
    }

    public function vendor(){
        return $this->belongsto('App\Model\Master\Vendor', 'id_vendor');
    }

    public function cabang(){
        return $this->belongsto('App\Model\Master\Cabang', 'id_cabang');
    }

    public function terima(){
        return $this->belongsto('App\Model\Master\Cabang', 'id_terima');
    }
}
