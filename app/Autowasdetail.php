<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autowasdetail extends Model
{
    protected $table = 'autodebet_waserda_detail';

    protected $fillable = ['id_auto_header', 'id_transaksi_detail', 'debet', 'status'];

    public function trandetailid() {
        return $this->belongsTo('App\Model\Pos\Transaksidetail', 'id_transaksi_detail');
    }

    public function prosesid() {
        return $this->belongsTo('App\Autowasheader', 'id_auto_header');
    }
}
