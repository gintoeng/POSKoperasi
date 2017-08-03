<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Pengaturan\Profil;

use PDF;

class NeracaController extends Controller
{
    public function index() {

        $date = date('m/d/Y');

        return view('laporan.neraca.index')->with('date', $date);
    }

    public function cetak(Request $req) {
        date_default_timezone_set('Asia/Jakarta');
        $profil = Profil::findOrNew('1');
        $i = 1;
        $tanggal = date('Y-m-d',strtotime($req->tgl));

        $akunheader = Perkiraan::orderBy('id', 'ASC')->where('parent', 0)->get();

//        return view('laporan.neraca.neraca_print', ['akunheader'=>$akunheader, 'profil'=>$profil, 'tanggal' =>$tanggal, 'i'=>$i]);
        $pdf = PDF::loadView('laporan.neraca.neraca_print', ['akunheader'=>$akunheader, 'profil'=>$profil, 'tanggal' =>$tanggal, 'i'=>$i]);
        $customPaper = array(0,0,950,950);
        if ($req->print == "preview") {
            return $pdf->setPaper($customPaper, 'landscape')->stream('Data-Neraca.pdf');
        } else {
            return $pdf->setPaper($customPaper, 'landscape')->download('Data-Neraca.pdf');
        }

   }

    // public function cetak() {
    //     $akunheader = Perkiraan::orderBy('id', 'ASC')->where('parent', 0)->get();
    //     $akunheaders = $this->_treeMenu($akunheader);
    //
    //     $jurnalsumdeb = JurnalDetail::sum("debet");
    //     $jurnalsumkre = JurnalDetail::sum("kredit");
    //     $jurnalsum = $jurnalsumkre - $jurnalsumdeb;
    //
    //     $pdf = PDF::loadView('laporan.keuangan.neraca.neraca_print', ['akunheaders' => $akunheaders, 'akunheaders2' => $jurnalsum]);
    //     return $pdf->stream('Data Neraca');
    //
    // }
    //
    // private function _treeMenu($arr, $parent = 0)
    // {
    //     $trees = '';
    //
	//     foreach($arr as $row){
	//         	$children = Perkiraan::where('parent', $row->id)->get();
    //             $trees .= '<ul><li style="list-style-type:none;">';
    //             if($row->tipe_akun=="detail"){
    //                 $jurnal = JurnalDetail::where('id_akun', $row->id)->get();
    //                 if(!$jurnal->isEmpty()){
    //                     $jurnalsumdeb = JurnalDetail::where('id_akun', $row->id)->sum("debet");
    //                     $jurnalsumkre = JurnalDetail::where('id_akun', $row->id)->sum("kredit");
    //                     $jurnalsum = $jurnalsumkre - $jurnalsumdeb;
    //                     $trees .=  $row['kode_akun'] ." - ". $row['nama_akun'] . "<b style='margin-left:20%'>" .number_format($jurnalsum, '2') ."</b>";
    //                 }
    //             } else if($row->tipe_akun=="header"){
    //                 $trees .=  $row['kode_akun'] ." - ". $row['nama_akun'];
    //             }
	//             $trees .=  $this->_treeMenu($children);
	//             $trees .= '</li></ul>';
	//     }
    //
    //     return $trees;
    // }




}
