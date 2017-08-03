<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    protected $fillable = [
    'nama',
    'kode',    
    ];
}
