<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    protected $table = 'approvel';

    protected $fillable = ['id_for', 'for', 'lev1', 'lev2', 'lev3', 'release'];

    public function pinjamanid() {
        return $this->belongsTo('App\Model\Pinjaman\Pinjaman', 'id_for');
    }
    public function transimpid() {
        return $this->belongsTo('App\Model\Simpanan\Transaksi', 'id_for');
    }
    public function pembwasid() {
        return $this->belongsTo('App\Model\Inventory\pembelianSupplierHeader', 'id_for');
    }
}
