<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "unit";
    protected $fillable = [
    'nama',
    'kode',
    ];
}
