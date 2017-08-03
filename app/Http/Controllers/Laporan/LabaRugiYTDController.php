<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LabaRugiYTDController extends Controller
{
    public function index(){
        $date = date('m/d/Y');

        return view('laporan.labarugiytd.index')->with('date', $date);
    }

    public function cetak(){

    }
}
