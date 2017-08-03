<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;

class MasterStok extends Model
{
    protected $table = 'stok_minimum';
    protected $fillable = [
    'stok'];
}
