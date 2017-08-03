<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterKonfigurasi extends Model
{
     protected $table = "masterstok";
    protected $fillable = [
    'stok_minimum'
    ];
}
