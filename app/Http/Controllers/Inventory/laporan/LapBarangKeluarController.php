<?php

namespace App\Http\Controllers\Inventory\laporan;

use Illuminate\Http\Request;
// use App\Model\Inventory\LapBarangKeluar;
use PDF;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\Model\Pengaturan\Profil;

class LapBarangKeluarController extends Controller
{
	public function showProdukOut(Request $req)
    {
    	$profil = Profil::findOrNew('1');
    	$i = 1;
        $tanggal = $req->dari ." - ". $req->ke;

    	$transaksi_detail = 'transaksi_detail';
    	$transaksi_detail = DB::table('transaksi_detail')->get();
    	$date = date('y-m-d');

    	return view('inventory.lapbarangkeluar', array('profil'=>$profil, 'tanggal' => $date,'transaksi_detail' => $transaksi_detail ));
    }

}
