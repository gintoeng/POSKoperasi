<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autowasheader extends Model
{
    protected $table = 'autodebet_waserda_header';
    
    protected $fillable = ['tanggal_proses', 'tanggal_awal', 'bulan', 'tahun', 'tanggal_akhir', 'keterangan', 'shunya'];
}
