<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Model\Akuntansi\Kas;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pengaturan\Nomor;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Profil;

class KaslapController extends Controller
{
    public function kasawal() {
        $date = date('m/d/Y');
        return view('laporan.kas.kasawal')->with('dari', $date)
                                          ->with('ke', $date);
    }

    public function kascetak(Request $req){

        $profil = Profil::findOrNew('1');
        $i = 1;
        $tanggal = $req->dari ." - ". $req->ke;
        $dari = date('Y-m-d', strtotime($req->dari));
        $ke = date('Y-m-d', strtotime($req->ke));
        $kode = "";
        $jenis = "";

        if($req->jenis=="masuk"){
            $kodenomor = Nomor::where('modul', 'Kas Masuk')->first();
            $kode = $kodenomor->kode;
            $jenis = $kodenomor->kode;
        } else if($req->jenis=="keluar"){
            $kodenomor = Nomor::where('modul', 'Kas Keluar')->first();
            $kode = $kodenomor->kode;
            $jenis = $kodenomor->kode;
        } else if($req->jenis=="transfer"){
            $kodenomor = Nomor::where('modul', 'Kas Transfer')->first();
            $kode = $kodenomor->kode;
            $jenis = $kodenomor->kode;
        }

        if($req->pilih=="kasdetail"){
            $jurnalkas = JurnalHeader::where('kode_jurnal', 'like', '%'.$kode.'%')->where('tipe', 'KAS')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();

            $pdf = PDF::loadView('laporan.kas.kasdetail_cetak', ['jenis' => $jenis,'jurnalkas'=>$jurnalkas, 'profil'=>$profil, 'tanggal' =>$tanggal, 'i'=>$i]);
            if ($req->print == "preview") {
                return $pdf->setPaper('a4', 'potrait')->stream('KAS-DETAIL.pdf');
            } else {
                return $pdf->setPaper('a4', 'potrait')->download('KAS-DETAIL.pdf');
            }
        }

        else if($req->pilih=="kasrekap"){
            if($req->jenis=="masuk"){
                $kas = Kas::where('tipe', 'Masuk')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();
            } else if($req->jenis=="keluar"){
                $kas = Kas::where('tipe', 'keluar')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();
            } else {
                $kas = Kas::where('tipe', 'transfer')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();
            }

            $pdf = PDF::loadView('laporan.kas.kasrekap_cetak', ['jenis' => $jenis,'kas'=>$kas, 'profil'=>$profil, 'tanggal' =>$tanggal, 'i'=>$i]);
            if ($req->print == "preview") {
                return $pdf->setPaper('a4', 'potrait')->stream('KAS-REKAP.pdf');
            } else {
                return $pdf->setPaper('a4', 'potrait')->download('KAS-REKAP.pdf');
            }
        }

        else if($req->pilih=="kastipe"){
            if($req->jenis=="masuk"){
                $kas = KAS::groupby('tipe')->where('tipe', 'Masuk')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();
            } else if($req->jenis=="keluar"){
                $kas = KAS::groupby('tipe')->where('tipe', 'Keluar')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();
            } else {
                $kas = KAS::groupby('tipe')->where('tipe', 'Transfer')->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->get();
            }



            $pdf = PDF::loadView('laporan.kas.kastipe_cetak', ['jenis' => $jenis,'kas'=>$kas, 'profil'=>$profil, 'tanggal' =>$tanggal, 'i'=>$i]);
            if ($req->print == "preview") {
                return $pdf->setPaper('a4', 'potrait')->stream('KAS-TIPE.pdf');
            } else {
                return $pdf->setPaper('a4', 'potrait')->download('KAS-TIPE.pdf');
            }
        }


    }









    public function trankas() {
        return view('laporan.kas.kasmasuk');
    }

    public function trankas_cetak(request $requests){
        $dari = date("Y-m-d", strtotime($requests->dari));
        $ke = date("Y-m-d", strtotime($requests->ke));

        if($requests->urut=="tgl"){
            $kas = Kas::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->where('tipe', 'Masuk')->orderBy('id', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.kas.kasmasuk_print', ['kas' => $kas]);
        return $pdf->stream('Data Kas Masuk.pdf');
    }

    public function trankas_keluar() {
        return view('laporan.kas.kaskeluar');
    }

    public function trankaskeluar_cetak(request $requests){
        $dari = date("Y-m-d", strtotime($requests->dari));
        $ke = date("Y-m-d", strtotime($requests->ke));

        if($requests->urut=="tgl"){
            $kas = Kas::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->where('tipe', 'Keluar')->orderBy('tanggal', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.kas.kaskeluar_print', ['kas' => $kas]);
        return $pdf->stream('Data Kas Keluar.pdf');
    }

    public function trankas_transfer() {
        return view('laporan.kas.kastransfer');
    }

    public function trankastransfer_cetak(request $requests){
        $dari = date("Y-m-d", strtotime($requests->dari));
        $ke = date("Y-m-d", strtotime($requests->ke));

        if($requests->urut=="tgl"){
            $kas = Kas::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->where('tipe', 'Transfer')->orderBy('tanggal', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.kas.kastransfer_print', ['kas' => $kas]);
        return $pdf->stream('Data Kas Transfer.pdf');
    }
}
