<?php namespace App\Http\Controllers\Inventory\stok;

use App\Model\Master\Cabang;
use App\Model\Pengaturan\Profil;
use App\Model\Pos\Mstok;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Inventory\MasterStok;
use DB;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StokMinimumController extends Controller
{

    public function showStok()
    {
		$maping = Cabang::find(Auth::user()->cabang);
		$stok_minimum = $maping->mappingproduk;

    	return view('inventory.stokminimum')->with('stok_minimum', $stok_minimum);
    }

	public function expired()
	{
		$date = date('Y-m-d');
		$stok = Mstok::where('tanggal_expired', '<=', $date)->where('cabang', Auth::user()->cabang)->paginate(20);

		return view('inventory.expired')->with('stok', $stok);
	}
	public function print_expired()
	{

		$profil = Profil::findOrNew('1');
		$i = 1;
		$date = date('Y-m-d');

		$transaksi_detail =  Mstok::where('tanggal_expired', '<=', $date)->where('cabang', Auth::user()->cabang)->get();

		$pdf = PDF::loadview('inventory.lapexpired', ['transaksi_detail'=>$transaksi_detail, 'profil'=>$profil, 'date' => $date] );
		return $pdf->stream('LaporanProdukExpired.pdf');
	}
	public function print_stok()
	{
		$profil = Profil::findOrNew('1');
		$i = 1;
		$date = date('Y-m-d');

		$maping = Cabang::find(Auth::user()->cabang);
		$transaksi_detail = $maping->mappingproduk;

		$pdf = PDF::loadview('inventory.lapstok', ['transaksi_detail'=>$transaksi_detail, 'profil'=>$profil, 'date' => $date] );
		return $pdf->stream('LaporanStokMinimum.pdf');
	}
}
