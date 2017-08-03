<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Matauang extends Model
{
    protected $table = 'matauang';
    protected $fillable = [
        'kode',
        'nama',
        'def'
    ];

}
