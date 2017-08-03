<?php namespace App\Http\Controllers\Pos;

namespace App\Http\Controllers\Pos;

use App\Model\Master\Anggota;
use App\Model\Master\Cabang;
use App\Model\Pos\Hpp;
use App\Model\Pos\Promodetail;
use App\Model\Pos\Promoheader;
use PDF;
use Illuminate\Http\Request;

use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksisementara;
use App\Model\Pos\Produk;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pos\Iklan;
use App\Model\Pengaturan\Profil;
use App\Model\Pengaturan\Nomor;
use App\User;
use Illuminate\Support\Facades\Auth;

class IklanController extends Controller
{
    public function allsearchday($df, $dt)
    {
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = "Semua Kasir";
        $role_kasir = '4';
        $kasir = User::where('role_id', $role_kasir)->get();
        $cabang = Cabang::all();
        $bzz = "Hari";
        $cb = "r";
        $jt = "jt";
        $id="";

                $jumlah = Hpp::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->sum('hpp_asli');
                $detail = Hpp::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->orderBy('id', 'desc')->paginate(8);


        return view('pos.hpp')->with('id', $id)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function allsearchmonth($df, $dt)
    {
        $tahun = date('Y');
        $olo = $tahun.'-'.$df.'-01';
        $olo2 = $tahun.'-'.$dt.'-31';
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = "Semua Kasir";
        $role_kasir = '4';
        $kasir = User::where('role_id', $role_kasir)->get();
        $cabang = Cabang::all();
        $bzz = "Bulan";
        $cb = "r";
        $jt = "jt";
        $id="";

        $jumlah = Hpp::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $detail = Hpp::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id', 'desc')->paginate(8);

        return view('pos.hpp')->with('id', $id)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public function allsearchyear($df, $dt)
    {
        $olo = $df.'-01-01';
        $olo2 = $dt.'-12-31';
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = "Semua Kasir";
        $role_kasir = '4';
        $kasir = User::where('role_id', $role_kasir)->get();
        $cabang = Cabang::all();
        $bzz = "Tahun";
        $id="";

        $cb = "r";
        $jt = "jt";

        $jumlah = Hpp::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $detail = Hpp::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id', 'desc')->paginate(8);


        return view('pos.hpp')->with('id', $id)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function searchday($id, $df, $dt)
    {
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = $id;
        $role_kasir = '4';
        $kasir = User::where('role_id', $role_kasir)->get();
        $cabang = Cabang::all();
        $bzz = "Hari";

        $cb = "r";
        $jt = "jt";



                $jumlah = Hpp::where('produk' , 'like', '%'.$id.'%')->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->sum('hpp_asli');
                $detail = Hpp::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->orderBy('id', 'desc')->paginate(8);

        return view('pos.hpp')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya)->with('id', $id);

    }

    public function searchmonth($id, $df, $dt)
    {
        $tahun = date('Y');
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $olo = $tahun.'-'.$df.'-01';
        $olo2 = $tahun.'-'.$dt.'-31';
        $kasirnya = $id;
        $role_kasir = '4';
        $kasir = User::where('role_id', $role_kasir)->get();
        $cabang = Cabang::all();
        $bzz = "Bulan";

        $cb = "r";
        $jt = "jt";



        $jumlah = Hpp::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $detail = Hpp::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id', 'desc')->paginate(8);

        return view('pos.hpp')->with('id', $id)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }

    public function searchyear($id, $df, $dt)
    {

        $olo = $df.'-01-01';
        $olo2 = $dt.'-12-31';
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = $id;
        $role_kasir = '4';
        $kasir = User::where('role_id', $role_kasir)->get();
        $cabang = Cabang::all();
        $bzz = "Tahun";

        $cb = "r";
        $jt = "jt";

        $jumlah = Hpp::where('produk',  'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $detail = Hpp::where('produk',  'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id', 'desc')->paginate(8);


        return view('pos.hpp')->with('id', $id)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }



    public function stokbarang()
    {
        $maping  = Cabang::find(Auth::user()->cabang);
        $detail  = $maping->mappingproduk()->paginate(8);
        $details  = $maping->mappingproduk;
        $isinya = "";
        return view('pos.stokbarang')->with('detail',$detail)->with('details', $details)->with('isinya', $isinya);
    }
    public function stok()
    {
        return view('pos.menustok');
    }
    public function caribarang($nama)
    {
        $maping  = Cabang::find(Auth::user()->cabang);
        $detail  = $maping->mappingproduk()->where('nama', 'like', '%'.$nama.'%')->paginate(8);
        $details = $maping->mappingproduk;
        $isinya  = $nama;
        return view('pos.stokbarang')->with('detail',$detail)->with('details', $details)->with('isinya', $isinya);
    }
    public function previewbarang($id)
    {
        $maping  = Cabang::find(Auth::user()->cabang);
        $detail  = $maping->mappingproduk()->where('barcode', $id);
        return view('pos.stokbarang')->with('detail',$detail);
    }
    public function pdfbarangid($nama)
    {
        $maping  = Cabang::find(Auth::user()->cabang);
        $detail  = $maping->mappingproduk()->where('nama','like','%'.$nama.'%')->get();
        $koperasi = Profil::find(1);
        $cbnya = $maping->nama;
        $pdf = PDF::loadView('pos.stokbarangpdf', ['detail'
        => $detail, 'koperasi' => $koperasi,'cbnya' => $cbnya])->setPaper('a4','potrait');
        return $pdf->stream('stok_barang_pdf.pdf');
    }
    
    public function get($search, $pilihan, $header)
    {
        $header2 = $header;

        if($pilihan=="1"){
            $produk = TambahProduk::where('barcode', $search)->get();
        } else if($pilihan=="2"){
            $produk = TambahProduk::where('nama', 'like', '%'.$search.'%')->get();
        } else if($pilihan=="3"){
            $produk = TambahProduk::all();
        }

        return view('inventory.tableprodukjs')->with('produk', $produk)
            ->with('header2', $header);
    }

    public function storebarang(Request $request)
    {
        $kode = $request->kode2;
        $header = Promoheader::find($kode);
        foreach ($request->cbpilih as $key => $barangid) {
            $detail = new Promodetail;
            $detail->id_header = $header->id;
            $detail->nama = $header->nama;
            $detail->qty = $request['qty'.$key];;
            $detail->produk = $key;
            $detail->save();
        }
//        $header->update(['total_sub' => $header->detail->SUM('sub_total')]);

        return redirect(url('pos/master/promo'));
    }

    public function promo()
    {
        $promo = Promoheader::paginate(6);
        return view('pos.promo')->with('promo', $promo);
    }
    public function promotambah()
    {
        return view('pos.promotambah');
    }
    public function saveheader(Request $request)
    {

        $mapcab = Cabang::find(Auth::user()->cabang);
        $mapcab2 = $mapcab->id;
        $datefrom2 = explode('/', $request->akhirpromo);
        $pembayaran    = $request->nominal;
        $pembayarann   = str_replace(",","",$pembayaran);
        $nominal   = str_replace(".00","",$pembayarann);

        $header = new Promoheader;
        $header->akhir_promo = $datefrom2[2].'-'.$datefrom2[0].'-'.$datefrom2[1];
        $header->keterangan = $request->Eket;
        $header->id_cabang = $mapcab2;
        $header->status = $request->anggota;
        $header->nama = $request->namapromo;
        $header->type = $request->type;
        $header->nominal = $nominal;
        $header->diskon = $request->diskon;
        $header->save();

        return redirect(url('pos/master/promo/tambah/pilih/produk/'.$header->id));
    }
    public function promobarang($id)
    {
        $promo = Promoheader::find($id);
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        return view('pos.promotambahh')->with('promo', $promo)->with('produk', $produk);
    }

    public function iklan(Request $request)
    {
        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/iklan/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "test.jpg";
        }

        $master = Iklan::find(1);
        $master->update([

            'title'   => $filename
        ]);

        return redirect( url('pos/master/iklan'));
        

    }

public function ohko($angka)
    {

        $master = Iklan::find(1);
        $master->update([
            'status'   => $angka
        ]);

        return redirect( url('pos/master/iklan'));

    }
    public function allcetakday($dk, $dt)
    {
        $koperasi         = Profil::find(1);
        $df				  = $dk.'&nbsp;sd&nbsp;'.$dt;
        $namanya		  = '';
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";
        $jenis            = "";
        $idnya = "";

                $jumlah         = Hpp::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->sum('hpp_asli');
                $pendapatan     = Hpp::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->get();

            $cbnya = "";

        $pdf = PDF::loadView('pos.hpplaporan', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'idnya' => $idnya , 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('hpplaporan.pdf');

    }

    public function allcetakmonth($dk, $dt)
    {
        $koperasi         = Profil::find(1);
        $tahun            = date('Y');
        $olo              = $tahun.'-'.$dk.'-01';
        $olo2             = $tahun.'-'.$dt.'-31';
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namanya		  = 'Semua Anggota';
        $npknya           = "0";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = "";
        $idnya = "";
        $jumlah           = Hpp::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $pendapatan       = Hpp::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->paginate(10000000);

        $cbnya = "Semua Cabang";


        $pdf = PDF::loadView('pos.hpplaporan', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'idnya' => $idnya , 'df' => $df, 'namanya' => $namanya, 'npknya' => $npknya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('hpplaporan.pdf');


    }
    public function allcetakyear($dk, $dt)
    {
        $koperasi         = Profil::find(1);
        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $df		          = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namanya		  = 'Semua Anggota';
        $npknya           = "0";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = "";
        $idnya = "";
        $jumlah           = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $pendapatan       = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->paginate(10000000);


        $cbnya = "";

        $pdf = PDF::loadView('pos.hpplaporan', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'idnya' => $idnya , 'df' => $df, 'namanya' => $namanya, 'npknya' => $npknya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('hpplaporan.pdf');


    }

    public function cetakday($idkasir, $dk, $dt)
    {
        $koperasi         = Profil::find(1);
        $df				  = $dk.'&nbsp;sd&nbsp;'.$dt;
        $namakasir        = Anggota::where('npk', $idkasir)->first();
        $namanya          = "";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = "";
        $idnya = "";
        $jumlah           = Hpp::where('produk', 'like', '%'.$idkasir.'%')->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->sum('hpp_asli');
        $pendapatan       = Hpp::where('produk', 'like', '%'.$idkasir.'%')->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->orderBy('id','desc')->paginate(10000000);

        $cbnya = "";


        $pdf = PDF::loadView('pos.hpplaporan', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'idnya' => $idnya,  'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('hpplaporan.pdf');


    }
    public function cetakmonth($idkasir, $dk, $dt)
    {
        $tahun            = date('Y');
        $koperasi         = Profil::find(1);
        $olo              = $tahun.'-'.$dk.'-01';
        $olo2             = $tahun.'-'.$dt.'-31';
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namakasir        = Anggota::where('npk', $idkasir)->first();
        $namanya          = "";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = "";
        $idnya = "";
        $jumlah           = Hpp::where('produk', 'like', '%'.$idkasir.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $pendapatan       = Hpp::where('produk', 'like', '%'.$idkasir.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id','desc')->paginate(10000000);

        $cbnya = "Semua Cabang";


        $pdf = PDF::loadView('pos.hpplaporan', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'idnya' => $idnya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('hpplaporan.pdf');


    }

    public function cetakyear($idkasir, $dk, $dt)
    {
        $koperasi         = Profil::find(1);
        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $df		          = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namakasir        = Anggota::where('npk', $idkasir)->first();
        $namanya          = "";
        $idnya = "";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = "";
        $idnya = "";
        $jumlah           = Hpp::where('produk', 'like', '%'.$idkasir.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('hpp_asli');
        $pendapatan       = Hpp::where('produk', 'like', '%'.$idkasir.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id','desc')->paginate(10000000);

        $cbnya = "Semua Cabang";

        $pdf = PDF::loadView('pos.hpplaporan', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'idnya' => $idnya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('hpplaporan.pdf');


    }
    
}
