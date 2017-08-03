<?php

namespace App\Http\Controllers\Inventory\laporan;

use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Mappingbarang;
use Illuminate\Http\Request;
 use App\Model\Inventory\LapBarangMasuk;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LapBarangMasukController extends Controller
{
	public function showProdukIn()
	{
		$beli = LapBarangMasuk::where('cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.laporanbarangmasuk')->with('beli', $beli);
	}
}
