<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
protected $table="profil";
protected $fillable=[
'nama_koperasi',
'alamat_koperasi',
'keterangan',
'telepon',
'kode_pos',
'foto'
];
}
