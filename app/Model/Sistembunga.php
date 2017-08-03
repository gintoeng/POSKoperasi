<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sistembunga extends Model
{
    protected $table = 'sistem_bunga';

    protected $fillable = [
        'sistem',
        'untuk'
    ];
}
