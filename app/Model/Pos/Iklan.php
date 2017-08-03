<?php

namespace App\Model\Pos;

use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
protected $table="iklan";
protected $fillable=[
'title',
'status'
];
}
