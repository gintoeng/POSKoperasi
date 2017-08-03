<?php namespace App\Http\Controllers\Inventory\master;

use App\Model\Inventory\LapBarangMasuk;
use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Barang;
use App\Model\Master\Cabang;
use App\Model\Pos\Transaksidetail;
use App\Model\Pos\Transaksisementara;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Model\Inventory\TambahProduk;
use App\Model\Inventory\Unit;
use App\Model\Inventory\Kategori;
use App\Model\Inventory\Vendor;
use App\Model\Inventory\Curr;
use App\Model\Inventory\MataUang;
use App\Model\Pengaturan\Profil;
use App\Model\Pos\Produk;

use Illuminate\Support\Facades\Auth;
use PDF;
use App\Http\Controllers\Controller;

class MasterProdukController extends Controller
{
    //
    public function index()
    {

        $maping = Cabang::find(Auth::user()->cabang);
        $masterp = Transaksidetail::all();
      return view('inventory.masterproduk2')->with('masterp', $masterp);

    }

   public function search(Request $req)
   {
       $keyword = $req->keyword;

       $masterp = Produk::where('nama', 'LIKE', '%'.$keyword.'%')->orWhere('barcode', 'LIKE', '%'.$keyword.'%')->paginate(20);

       return view('inventory.masterproduksearch')->with('produk', $masterp)
                                                ->with('keyword', $keyword);
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

       $hjual = str_replace(",","",$request->harga_jual);
        $harga_jual = str_replace(".00","",$hjual);

        $hbeli = str_replace(",","",$request->harga_beli);
        $harga_beli = str_replace(".00","",$hbeli);

        $huntung = str_replace(",","",$request->salary);
        $untung = str_replace(".00","",$huntung);

      if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/barang/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "avatar.jpg";
        }

        $produk = TambahProduk::create([
            'nama'            => $request->nama_produk,
            'classification'  => $request->keterangan,
            'unit'            => $request->unit,
            'curr'            => $request->curr,
            'harga_jual'      => $harga_jual,
            'harga_beli'      => $harga_beli,
            'disc'            => $request->disc,
            'stok'            => $request->stok,
            'barcode'         => $request->barcode,
            'remark'          => $request->remark,
            'status'          => $request->status,
            'kategori'        => $request->kategori,
            'id_koperasi'     => $request->id_koperasi,
            'untung'          => $untung,
            'foto'            => $filename,
            'id_cabang'       => Auth::user()->cabang,
            'no_faktur'       => $request->no_faktur,
            'id_vendor'       => $request->vendor
        ]);
//        return redirect(url('/tambahproduk'));
       if ($request->redd == 0) {
           return redirect(url('/masterproduk'));
       } else {
           $header = pembelianSupplierHeader::find($request->redd);
           $prod = TambahProduk::find($produk->id);
           $prod->update([
               'id_cabang' => $header->id_cabang,
               'id_vendor' => $header->id_vendor,
               'proc' => 1
           ]);

           $detail = new pembelianSupplierDetail;
           $detail->id_header = $request->redd;
           $detail->id_barang = $produk->id;
           $detail->qty = $request->stok;
           $total = $request->stok * $harga_beli;
           $detail->sub_total = $total;
           $detail->save();
           return redirect(url('inventory/supplier/pembelian/editheader/'.$request->redd));
       }
   }
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show()
   {
   }
   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */

   public function liat($id)
   {
     $produk = Barang::find($id);
      return view('inventory.detail' , array('produk' => $produk));
   }

   public function showUnit()
    {
      $curr = MataUang::all();
      $unit = DB:: table('unit')->get();
      $kategori = DB:: table('kategori')->get();
      $vendor = DB::table('vendor')->get();
      $cabang = DB::table('cabang')->get();
      return view('inventory.tambahproduk', array('cabang' => $cabang, 'unit'=>$unit,'curr'=>$curr, 'kategori'=>$kategori, 'vendor'=>$vendor, 'idh'=>'0'));
    }

    public function showUnit2($idh)
    {
        $curr = MataUang::all();
        $unit = DB:: table('unit')->get();
        $kategori = DB:: table('kategori')->get();
        $vendor = DB::table('vendor')->get();
        $cabang = DB::table('cabang')->get();
        return view('inventory.tambahproduk', array('cabang' => $cabang, 'unit'=>$unit,'curr'=>$curr, 'kategori'=>$kategori, 'vendor'=>$vendor, 'idh'=>$idh));
    }

   public function edit($id)
   {
      $curr = MataUang::all();
      $unit = DB:: table('unit')->get();
      $kategori = DB:: table('kategori')->get();
      $produk = TambahProduk::find($id);
      $vendor = DB::table('vendor')->get();
      $cabang = DB::table('cabang')->get();
      return view('inventory.ubahproduk', array('cabang' => $cabang, 'unit'=>$unit,'curr'=>$curr, 'kategori'=>$kategori, 'produk'=>$produk, 'vendor'=>$vendor));
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {
      if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/barang/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "avatar.jpg";
        }

      $produk = TambahProduk::findOrNew($id);
      $produk->update([
            'barcode'         => $request->barcode,
            'harga_beli'      => $request->harga_beli,
            'nama'            => $request->nama_produk,
            'harga_jual'      => $request->harga_jual,
            'stok'            => $request->stok,
             'disc'            => $request->disc,
            'kategori'        => $request->kategori,
            'classification'  => $request->keterangan,
            'curr'            => $request->curr,
            'unit'            => $request->unit,
            'updated_at'      => $request->datepicker,
            'foto'            => $filename,
            'untung'          => $request->salary,
            'id_cabang'       => Auth::user()->cabang,
            'remark'          => $request->remark,
            'status'          => $request->status,
            'no_faktur'       => $request->no_faktur,
            'id_vendor'       => $request->vendor

      ]);
        return redirect(url('/masterproduk'));
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

   public function jumpdf(Request $req)
   {
    $profil = Profil::findOrNew('1');
    $i = 1;
    $tanggal = $req->dari ." - ". $req->ke;

    $produk = LapBarangMasuk::where('cabang', Auth::user()->cabang)->get();
    $date = date('Y-m-d');

    $pdf = PDF::loadview('inventory.lapproduk', ['produk'=>$produk, 'profil'=>$profil, 'tanggal' => $date] );
    return $pdf->stream('LaporanBarangMasuk.pdf');
  }

  public function jumpdf2(Request $req)
   {
    $profil = Profil::findOrNew('1');
    $i = 1;
    $tanggal = $req->dari ." - ". $req->ke;

    $transaksi_detail = DB::table('transaksi_detail')->get();
    $date = date('d-m-y');

    $pdf = PDF::loadview('inventory.lapkeluar', ['transaksi_detail'=>$transaksi_detail, 'profil'=>$profil, 'tanggal' => $date] );
    return $pdf->stream('LaporanBarangKeluar.pdf');
  }

  public function cari($barang)
  {
    $produk = Produk::where('nama','like','%'.$barang.'%')->orderBy('id','desc')->paginate(20);
    return view('inventory.masterproduk2')->with('produk',$produk)->with('barang',$barang);
  }

  public function untung($j, $b)
  {
        $hjual = str_replace(",","",$j);
        $hj = str_replace(".00","",$hjual);

        $hbeli = str_replace(",","",$b);
        $hb = str_replace(".00","",$hbeli);

        $untung = $hj - $hb;

        $data[] = array(
            'untung' => number_format($untung, 2, '.', ',')
        );

        return json_encode($data);
  }

   public function disc($hargajual, $disc)
   {
       $hjual = str_replace(",","",$hargajual);
       $hj = str_replace(".00","",$hjual);


       $fixjual = $hj/100*$disc;
       $fixbanget = $hj-$fixjual;
       $data[] = array(

           'fixjual' => number_format($fixbanget, 2, '.', ',')
       );

       return json_encode($data);
   }

}
