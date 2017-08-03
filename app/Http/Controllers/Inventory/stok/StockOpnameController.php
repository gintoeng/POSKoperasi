<?php 
namespace App\Http\Controllers\Inventory\stok; 

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Inventory;
use App\Model\Inventory\TambahProduk;
use App\Model\Pos\Produk;
use App\Model\Pos;
use App\Model\Master\Barang;
use App\Http\Controllers\Controller;
use DB;

class StockOpnameController extends Controller
{
    //
    public function index()
    {
      $produk = 'produk';
      $produk = DB::table('produk')->get();
      $kategori = DB:: table('kategori')->get();

      return view('inventory.stockopname', array('produk' => $produk, 'kategori'=>$kategori));      
   }

   public function cari($barang)
   {    
     $kategori = DB:: table('kategori')->get();
    $produk = Produk::where('nama','like','%'.$barang.'%')->orderBy('id','desc')->paginate(20);
    return view('inventory.stockopname')->with('produk',$produk)->with('kategori',$kategori);
   }

   public function cek($id)
   {
   		$produk = TambahProduk::find($id);   		
   		return view('inventory.opname' , array('produk' => $produk));
   }

   public function store($id, $selisih)
   {
    $produk= Barang::find($id);
    $produk->update([
            'adjust' => $selisih
        ]);
   }


}
