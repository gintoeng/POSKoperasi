<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class Curr extends Model
{
  	protected $table = "matauang";
    protected $fillable = [
    'kode',
    'nama',
    ];
}
