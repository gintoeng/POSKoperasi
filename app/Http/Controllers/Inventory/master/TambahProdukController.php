<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

use App\Model\Inventory\TambahProduk;
use App\Http\Requests;
use App\Model\Inventory\MataUang;
use App\Http\Controllers\Controller;

class TambahProdukController extends Controller
{
    //
     public function index()
    {
    	$produk = TambahProduk::all(); 
    	return view('inventory.tambahproduk');
    }

    

     public function showCurr()
    {

    }

     public function create()
   {
      //
   }
   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
        
   }
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
  
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
      
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update($id)
   {
     
   }
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {

      TambahProduk::destroy($id);
      return redirect(url('/masterproduk'));
   }
}

