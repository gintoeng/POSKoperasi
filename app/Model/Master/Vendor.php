<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendor';
    protected $fillable = [
        'kode',
        'nama_vendor',
        'nama_kontak',
        'alamat_1',
        'alamat_2',
        'phone',
        'fax',
        'mata_uang',
        'bank',
        'nomor_akun',
        'nama_akun',
        'keterangan'
    ];

    public function bankid() {
        return $this->belongsTo('App\Model\Master\Bank', 'bank');
    }

    public function matauang() {
        return $this->belongsTo('App\Model\Master\Matauang', 'mata_uang');
    }
}
