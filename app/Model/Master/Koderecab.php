<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Koderecab extends Model
{
    protected $table = 'kode_rekening_cab';

    protected $fillable = ['kode', 'nama'];
}
