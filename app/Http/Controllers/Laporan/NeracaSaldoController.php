<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Profil;
use PDF;

class NeracaSaldoController extends Controller
{
    public function index(){
        $date = date('m/d/Y');

        return view('laporan.neracasaldo.index')->with('dari', $date)
                                                ->with('ke', $date);
    }

    public function cetak(Request $req)
    {
        $profil = Profil::findOrNew('1');
        $i = 1;
        $tanggal = $req->dari ." - ". $req->ke;
        $dari = date('Y-m-d', strtotime($req->dari));
        $ke = date('Y-m-d', strtotime($req->ke));

        $jurnal = JurnalHeader::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();

        $pdf = PDF::loadView('laporan.neracasaldo.neraca_saldo_cetak', ['jurnal'=>$jurnal, 'profil'=>$profil, 'tanggal' =>$tanggal, 'i'=>$i]);
        if ($req->print == "preview") {
            return $pdf->setPaper('a4', 'potrait')->stream('KAS-DETAIL.pdf');
        } else {
            return $pdf->setPaper('a4', 'potrait')->download('KAS-DETAIL.pdf');
        }
    }
}
