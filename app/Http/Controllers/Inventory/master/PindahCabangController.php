<?php

namespace App\Http\Controllers\Inventory\master;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Inventory\TambahProduk;
use App\Model\Master\Cabang;

class PindahCabangController extends Controller
{
    public function index()
    {
        $cabang = Cabang::all();
        $produk = TambahProduk::all();
        return view('inventory.pindahcabang')->with('produk', $produk)
                                            ->with('cabang', $cabang);
    }


    public function store(Request $request)
    {
        foreach ($request->cbpilih as $key => $barangid) {
                $barang = TambahProduk::find($key);
                $barang->id_cabang = $request->cabang;
                $barang->save();
		}
        return redirect(url('inventory/cabang/pindah'));
    }
}
