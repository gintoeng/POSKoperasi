<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = "vendor";
    protected $fillable = [
    'id',
    'kode',    
    'nama_vendor',
    'nama_kontak',    
    'alamat_1',
    'alamat_2',    
    'phone',
    'fax',    
    'nomor_akun',
    'nama_akun',    
    'keterangan',
    ];    
}
