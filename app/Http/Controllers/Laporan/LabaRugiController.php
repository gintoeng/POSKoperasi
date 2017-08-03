<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pengaturan\Profil;
use App\Model\Akuntansi\pengaturanAkuns;
use App\Model\Akuntansi\pengaturanAkunRelasi;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\Perkiraan;


use PDF;
class LabaRugiController extends Controller
{
    public function index(){
        $tahun = date('Y');

        return view('laporan.labarugi.index')->with('tahun', $tahun);
    }

    public function cetak(Request $req) {
        $profil = Profil::findOrNew('1');
        $i = 1;
        $periode = $req->periode;
        $tahun = $req->tahun;

        if($periode=="1"){
            $bulan = "Januari";
        } else if($periode=="2"){
            $bulan = "Februari";
        } else if($periode=="3"){
            $bulan = "Maret";
        } else if($periode=="4"){
            $bulan = "April";
        } else if($periode=="5"){
            $bulan = "Mei";
        } else if($periode=="6"){
            $bulan = "Juni";
        } else if($periode=="7"){
            $bulan = "Juli";
        } else if($periode=="8"){
            $bulan = "Agustus";
        } else if($periode=="9"){
            $bulan = "September";
        } else if($periode=="10"){
            $bulan = "Oktober";
        } else if($periode=="11"){
            $bulan = "November";
        } else if($periode=="12"){
            $bulan = "Desember";
        }

        $tanggal = $tahun."-".$periode;

        $pemasukan = pengaturanAkuns::where('caption', 'Pemasukan')->first();
        $pengeluaran = pengaturanAkuns::where('caption', 'Pengeluaran')->first();

        $idakunpemasukan = pengaturanAkunRelasi::where('id_detail', $pemasukan->id)->first();
        $idakunpengeluaran = pengaturanAkunRelasi::where('id_detail', $pengeluaran->id)->first();

        $akunpemasukan = Perkiraan::find($idakunpemasukan->id_akun);
        $akunpengeluaran = Perkiraan::find($idakunpengeluaran->id_akun);

        $pemasukancount = JurnalDetail::where('id_akun', $idakunpemasukan->id_akun)->whereHas('header', function($q) use($tanggal){
            $q->where('tanggal', 'like', '%'.$tanggal.'%');
        })->sum('kredit');

        $pengeluarancount = JurnalDetail::where('id_akun', $idakunpengeluaran->id_akun)->whereHas('header', function($q) use($tanggal){
            $q->where('tanggal', 'like', '%'.$tanggal.'%');
        })->sum('debet');

        $labarugi = $pemasukancount - $pengeluarancount;

        $pdf = PDF::loadView('laporan.labarugi.labarugi_cetak', ['profil'=>$profil, 'bulan' =>$bulan, 'tahun' => $tahun, 'i'=>$i, 'pengeluarancount' => $pengeluarancount, 'pemasukancount' => $pemasukancount, 'akunpemasukan' => $akunpemasukan, 'akunpengeluaran' => $akunpengeluaran, 'labarugi' => $labarugi]);
        if ($req->print == "preview") {
            return $pdf->stream('Data-Laba-Rugi.pdf');
        } else {
            return $pdf->download('Data-Laba-Rugi.pdf');
        }

   }
}
