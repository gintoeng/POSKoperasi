<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Pengaturan\Profil;

use PDF;

class PerkiraanController extends Controller
{
    public function index() {
        $kelompok = Perkiraan::where('tipe_akun', 'header')->where('parent', '0')->get();

        return view('laporan.perkiraan.index')->with('kelompok', $kelompok);
    }

    public function cetak(Request $req) {
        $profil = Profil::findOrNew('1');
        $i = 1;

        if($req->kelompok=="all"){
            $kelompok = Perkiraan::where('parent', '0')->where('tipe_akun', 'header')->orderBy($req->urut,$req->urutan)->get();
            $tipe = "Semua Kelompok";
        } else {
            $kelompok = Perkiraan::find($req->kelompok);
            $tipe = "Kelompok";
        }

        $pdf = PDF::loadView('laporan.perkiraan.cetak', ['profil' => $profil, 'kelompok' => $kelompok, 'i' => $i, 'tipe' => $tipe, 'urut' => $req->urut, 'urutan' => $req->urutan]);

        if ($req->print == "preview") {
            return $pdf->stream('Daftar-Akun-Perkiraan.pdf');
        } else {
            return $pdf->download('Daftar-Akun-Perkiraan.pdf');
        }
    }
}
