<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $table = 'icon';

    protected $fillable = ['icon_name','type'];

}
