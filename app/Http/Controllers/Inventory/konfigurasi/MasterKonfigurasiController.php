<?php

namespace App\Http\Controllers\Inventory\konfigurasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


use DB;
use App\Model\Inventory\Konfigurasi;
use App\Model\Inventory\MasterStok;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MasterKonfigurasiController extends Controller
{
     public function index()
    {
        $produk= MasterStok::find(1);
        return view('inventory.masterkonfigurasi')->with('produk', $produk);
    }

    public function store(Request $request)
    {
        $produk= MasterStok::find(1);
    	$produk->update([
            'stok' => $request->stokmin
        ]);
        return redirect(url('/stokminimum'));
    }
}
