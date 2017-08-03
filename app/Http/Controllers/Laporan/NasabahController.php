<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use App\Model\Master\Anggota;

use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NasabahController extends Controller
{
    public function index() {
        return view('laporan.master.data_anggota');
    }

    public function cetak(request $requests) {

        if($requests->urut=="nama"){
            $anggota = Anggota::where('jenis_nasabah', $requests->jenis_nasabah)->where('id', '>=', $requests->dari)->where('id', '<=', $requests->ke)->orderBy('nama', 'ASC')->get();
        } else if($requests->urut=="kode"){
            $anggota = Anggota::where('jenis_nasabah', $requests->jenis_nasabah)->where('id', '>=', $requests->dari)->where('id', '<=', $requests->ke)->orderBy('id', 'ASC')->get();
        } else if($requests->urut=="alamat"){
            $anggota = Anggota::where('jenis_nasabah', $requests->jenis_nasabah)->where('id', '>=', $requests->dari)->where('id', '<=', $requests->ke)->orderBy('alamat', 'ASC')->get();
        } else if($requests->urut=="kota"){
            $anggota = Anggota::where('jenis_nasabah', $requests->jenis_nasabah)->where('id', '>=', $requests->dari)->where('id', '<=', $requests->ke)->orderBy('kota', 'ASC')->get();
        } else if($requests->urut=="tgl_lahir"){
            $anggota = Anggota::where('jenis_nasabah', $requests->jenis_nasabah)->where('id', '>=', $requests->dari)->where('id', '<=', $requests->ke)->orderBy('tgl_lahir', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.master.data_anggota_print', ['anggota' => $anggota]);
        return $pdf->stream('Data Nasabah.pdf');

    }
}
