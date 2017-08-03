<?php 
namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
protected $table="jenistransaksi";
protected $fillable=[
'jenis',
'aktif'
];
}
