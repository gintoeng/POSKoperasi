<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Akuntansi\Perkiraan;
use PDF;
use App\Model\Pengaturan\Profil;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\JurnalDetail;

class JurnalController extends Controller
{
    public function index() {
        $date = date('m/d/Y');
        $kelompok = Perkiraan::where('parent', '0')->where('tipe_akun', 'header')->get();

        return view('laporan.jurnal.index')->with('dari', $date)
                                           ->with('ke', $date)
                                           ->with('kelompok', $kelompok);
    }

    public function cetak(Request $req) {
        $profil = Profil::findOrNew('1');
        $i = 1;
        $Debetsum = '0';
        $Kreditsum = '0';

        $jenis = $req->kelompok;
        $tanggal = $req->dari ." - ". $req->ke;

        if($jenis=="SEMUA"){
            $jenis = "Semua Jenis Transaksi";
            $Jurnalheader = JurnalHeader::where('tanggal', '>=', date("Y-m-d", strtotime($req->dari))." 00:00:00")->Where('tanggal', '<=', date("Y-m-d", strtotime($req->ke))." 23:59:00")->orderBy($req->urut,$req->urutan)->get();
            foreach ($Jurnalheader as $row) {
                $Debetsum += JurnalDetail::where('id_header', $row->id)->sum('debet');
                $Kreditsum += JurnalDetail::where('id_header', $row->id)->sum('kredit');
            }
        } else {
            $jenis = $req->kelompok;
            $Jurnalheader = JurnalHeader::where('tanggal', '>=', date("Y-m-d", strtotime($req->dari))." 00:00:00")->Where('tanggal', '<=', date("Y-m-d", strtotime($req->ke))." 23:59:00")->where('tipe', $req->kelompok)->orderBy($req->urut,$req->urutan)->get();
            foreach ($Jurnalheader as $row) {
                $Debetsum += JurnalDetail::where('id_header', $row->id)->sum('debet');
                $Kreditsum += JurnalDetail::where('id_header', $row->id)->sum('kredit');
            }
        }

        $pdf = PDF::loadView('laporan.jurnal.cetak', ['jenis' => $jenis, 'tanggal' => $tanggal, 'profil' => $profil, 'i' => $i, 'Jurnalheader' => $Jurnalheader, 'Debetsum' => $Debetsum, 'Kreditsum' => $Kreditsum ]);
        if ($req->print == "preview") {
            return $pdf->stream('Laporan-jurnal.pdf');
        } else {
            return $pdf->download('Laporan-jurnal.pdf');
        }
    }
}
