<?php

namespace App\Model\Pinjaman;

use Illuminate\Database\Eloquent\Model;

class Autodetail extends Model
{
    protected $table = 'autodebet_pinjaman_detail';

    protected $fillable = [
        'id_auto_header',
        'id_pinjaman',
        'id_bayar',
        'debet',
        'status'
    ];

    public function pinjamanid() {
        return $this->belongsTo('App\Model\Pinjaman\Pinjaman', 'id_pinjaman');
    }

    public function prosesid() {
        return $this->belongsTo('App\Model\Pinjaman\Autoheader', 'id_auto_header');
    }

    public function bayarid() {
        return $this->belongsTo('App\Model\Pinjaman\Pembayaran', 'id_bayar');
    }
}
