<?php namespace App\Http\Controllers\Inventory\stok;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Inventory\Retur;


class ReturController extends Controller
{
  public function index()
  {
    $produk = 'produk';
    $produk = DB::table('produk')->get();

    return view('inventory.retur', array('produk' => $produk ));
 }
}
