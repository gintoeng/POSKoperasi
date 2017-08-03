<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    protected $table = "masterstok";
    protected $fillable = [
    'stok_minimum'
    ];
}
