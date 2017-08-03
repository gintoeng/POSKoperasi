<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Profil;
use PDF;
use App\Model\Akuntansi\Perkiraan;

class NeracaLajurController extends Controller
{
    public function index(){
        $date = date('m/d/Y');

        return view('laporan.neracalajur.index')->with('dari', $date)
                                                ->with('ke', $date);
    }

    public function cetak(Request $req)
    {
        $profil = Profil::findOrNew('1');
        $i = 1;
        $tanggal = $req->dari ." - ". $req->ke;
        $dari = date('Y-m-d', strtotime($req->dari));
        $ke = date('Y-m-d', strtotime($req->ke));

        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->get();

        $pdf = PDF::loadView('laporan.neracalajur.neracalajur_cetak', ['profil' => $profil, 'perkiraan' => $perkiraan, 'tanggal' => $tanggal, 'i' => $i, 'dari' => $dari, 'ke' => $ke]);
        $customPaper = array(0,0,950,950);
        if ($req->print == "preview") {
            return $pdf->setPaper($customPaper, 'landscape')->stream('Cetak-Neraca-Lajur.pdf');
        } else {
            return $pdf->setPaper($customPaper, 'landscape')->download('Cetak-Neraca-Lajur.pdf');
        }
    }
}
