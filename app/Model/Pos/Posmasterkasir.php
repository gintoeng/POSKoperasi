<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Autodebet extends Model
{
protected $table="laporan_kasir";
protected $fillable=[
'nama',
'jumlah'
];
}
