<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $fillable = [
        'nama',
        'kode'
    ];

}
