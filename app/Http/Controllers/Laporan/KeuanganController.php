<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\JurnalDetail;

class KeuanganController extends Controller
{
    public function lababln() {
        return view('laporan.keuangan.laba_bulanan');
    }

    public function labaytd() {
        return view('laporan.keuangan.laba_ytd');
    }


    public function neracaljr() {
        return view('laporan.keuangan.neraca_lajur');
    }

    public function neracasaldo() {
        return view('laporan.keuangan.neraca_saldo');
    }
}
