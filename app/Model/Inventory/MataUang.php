<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class MataUang extends Model
{
    protected $table = 'matauang';
    protected $fillable = [
    'id',
    'kode',
    'nama',
    'created_at',
    'updated_at',
    ];
}
