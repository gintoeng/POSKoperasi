<?php

namespace App\Http\Controllers\Pos;

use App\Model\Pos\Hpp;
use App\Model\Pos\Mstok;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pos\Transaksisementara;
use App\Model\Master\Anggota;
use App\Model\Master\Cabang;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Produk;
use PDF;
use App\Model\Pengaturan\Profil;
use App\Model\Pengaturan\Nomor;
use App\Model\Inventory\LapBarangKeluar;


class BerhasilController extends Controller
{
    public function simpanexpired(Request $request)
    {

        foreach ($request->cbpilih as $key => $barangid){

            $ubah = Mstok::where('id_produk', $key)->first();

            $ubah->update([

                'tanggal_expired' => $request['tanggal'.$key]

            ]);

            $ubah->update();
        }

        return redirect(url('inventory/supplier/penerimaan'));
    }

    public function rekapjenisall()
    {
        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = 'Semua Jenis Transaksi';
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }



        $pdf = PDF::loadView('pos.laporanjenis', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('rekap_jenis_transaksi.pdf');

    }

    public function rekapjenis($jenis)
    {

        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = $jenis;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('type_pembayaran', $jenis)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }




        $pdf = PDF::loadView('pos.laporanjenis', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('rekap_jenis_transaksi.pdf');

    }

    public function rekapanggotaall()
    {

        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $cbnya				  = "Semua Cabang";
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        }

        


        $pdf = PDF::loadView('pos.laporananggota', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'cbnya' => $cbnya])->setPaper('a4','potrait');
        return $pdf->stream('rekap_cabang.pdf');

    }

    public function rekapanggota($anggota)
    {

        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = $anggota;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('cabang', $anggota)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        }

            $cabang           = Cabang::find($anggota);
            $cabangnya        = $cabang->nama;
            $cbnya =         $cabangnya;



        $pdf = PDF::loadView('pos.laporananggota', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya])->setPaper('a4','potrait');
        return $pdf->stream('rekap_cabang.pdf');

    }
    public function alldate()
    {


        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = "";
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;


        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->paginate(10000000);
            } else {

                $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->paginate(10000000);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }



        $pdf = PDF::loadView('pos.rekaphari', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('rekap_periode.pdf');

    }
    public function hari($dk, $dt)
    {

        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  =  $dk.'&nbsp;sd&nbsp;'.$dt;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;


        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }



        $pdf = PDF::loadView('pos.rekaphari', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('rekap_periode.pdf');

    }
    public function bulan($oo1, $oo2)
    {
        $tahun            = date('Y');
        $olo              = $tahun.'-'.$oo1.'-01';
        $olo2             = $tahun.'-'.$oo2.'-31';
        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;


        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {

                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }



        $pdf = PDF::loadView('pos.rekaphari', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('rekap_periode.pdf');

    }
    public function tahun($dk, $dt)
    {

        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;


        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {

                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }
        
        
        

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }



        $pdf = PDF::loadView('pos.rekaphari', ['koperasi'
        => $koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('rekap_periode.pdf');

    }

    public function pdfbarangall()
    {
        $maping   = Cabang::find(Auth::user()->cabang);
        $detail   = $maping->mappingproduk;
        $koperasi = Profil::find(1);
        
        $cbnya = $maping->nama;
        $pdf = PDF::loadView('pos.stokbarangpdf', ['detail'
        => $detail, 'koperasi' => $koperasi, 'cbnya' => $cbnya])->setPaper('a4','potrait');
        return $pdf->stream('stok_barang_pdf.pdf');
    }
    public function anggota()
    {

        $detail 	    = Transaksiheader::where('status', '!=', 'Hold')->where('type_pembayaran', '!=', 'cash')->orderBy('id','desc')->paginate(8);
        $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->where('type_pembayaran', '!=', 'cash')->sum('jumlah');
        $today          = date('Y-m-d');
        $tanggalnya     = $today;
        $tanggalnya2    = $today;
        $kasirnya       = "Semua Kasir";
        $bzz            = "Hari";
        $cb             = "JKT";
        $jt             = "Semua Jenis";
        $kasir          = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang         = Cabang::all();
        return view('pos.anggotalaporan')->with('cb', $cb)->with('bzz', $bzz)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function anggotadetail($noreff, $npk)
    {

        $detail 	    = Transaksidetail::where('no_ref', $noreff)->orderBy('id','desc')->paginate(8);
        $jumlah         = Transaksidetail::where('no_ref', $noreff)->sum('sub_total');
        $today          = date('Y-m-d');
        $anggota        = Anggota::where('npk', $npk)->first();
        $tanggalnya     = $today;
        $tanggalnya2    = $today;
        $kasirnya       = "Semua Kasir";
        $cb             = "JKT";
        $bzz            = "Hari";
        $jt             = "Semua Jenis";
        $role_kasir     = Transaksiheader::where('noref', $noreff)->first();
        $kasirnya       = $role_kasir->kasir;
        $kasir          = User::find($kasirnya);
        $cabang         = Cabang::all();
        return view('pos.anggotalaporandetail')->with('anggota', $anggota)->with('npk', $npk)->with('role_kasir', $role_kasir)->with('noreff', $noreff)->with('bzz', $bzz)->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function hpp()
    {

        $detail 	    = Hpp::orderBy('id','desc')->paginate(8);
        $jumlah         = Hpp::all()->sum('hpp_asli');
        $today          = date('Y-m-d');
        $tanggalnya     = $today;
        $tanggalnya2    = $today;
        $kasirnya       = "Semua Kasir";
        $bzz            = "Hari";
        $cb             = "JKT";
        $id             ="";
        $maping         = Cabang::find(Auth::user()->cabang);
        $produk         = $maping->mappingproduk;
        $jt             = "Semua Jenis";
        $cabang         = Cabang::all();
        return view('pos.hpp')->with('id', $id)->with('produk', $produk)->with('cb', $cb)->with('bzz', $bzz)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function rekap()
    {
        $cabang = Cabang::all();
        return view('pos.rekap')->with('cabang', $cabang);

    }
    public function qtyenter(Request $request)
    {

        foreach ($request->cbpilih as $key => $barangid){

            $ubah = Transaksisementara::find($key);

            $maping  = Cabang::find(Auth::user()->cabang);
            $produk = $maping->mappingproduk->where('nama', $ubah->produk)->first();
            $qtyawal = $ubah->qty;
            $qtyakhir = $request['Eqty'.$key];
            $ubah->qty = $qtyakhir;
            $ubah->sub_total = $ubah->harga * $qtyakhir;
            $ubah->untung = $ubah->untung * $qtyakhir;
            $ubah->harga_beli = $ubah->harga_beli * $request['Esqty'.$key];;
            $ubah->save();
        }

return redirect(url('pos/penjualan'));
    }

    public function qtytambah($id)
{

    $ubah = Transaksisementara::find($id);
    $qtyawal = $ubah->qty;
    $qtyakhir = $qtyawal + 1;
    $ubah->qty = $qtyakhir;
    $ubah->sub_total = $ubah->harga * $qtyakhir;
    $ubah->untung = $ubah->untung * $qtyakhir;
    $ubah->harga_beli = $ubah->harga_beli * $qtyakhir;
    $ubah->save();

    $data[] = array(
        'kartu' => "Sukses",
    );
    return json_encode($data);


}
    public function qtykurang($id)
    {
        $ubah = Transaksisementara::find($id);
        $qtyawal = $ubah->qty;
        $qtyakhir = $qtyawal - 1;
        $ubah->qty = $qtyakhir;
        $ubah->sub_total = $ubah->harga * $qtyakhir;
        $ubah->untung = $ubah->untung * $qtyakhir;
        $ubah->harga_beli = $ubah->harga_beli * $qtyakhir;
        $ubah->save();

        $data[] = array(
            'kartu' => "Sukses",
        );
        return json_encode($data);


    }

    public function cetaknow($kasir)
    {

        $koperasi         = Profil::find(1);
        $cb               = "0";
        $jt               = "test";
        $df				  = 'Hari Ini';
        $tunda 		      = "Tunda";
        $tgl 			  = date('Y-m-d');
        $namakasir        = User::where('id', $kasir)->first();
        $namanya		  = $namakasir->username;
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $kasir)->where('tanggal', $tgl)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }



        $pdf = PDF::loadView('pos.laporankasirtahun', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporankasirtahun.pdf');

    }
    public function laporan()
    {
        $tunda       = 'Tunda';
        $payment     = "Payment";
        $detail 	 = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(8);
        $jumlah      = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
        $today       = date('Y-m-d');
        $tanggalnya  = $today;
        $tanggalnya2 = $today;
        $kasirnya    = "Semua Kasir";
        $cb          = "JKT";
        $bzz         = "Hari";
        $jt          = "Semua Jenis";
        $role_kasir  = '4';
        $kasir       = User::where('role_id',$role_kasir)->get();
        $cabang      = Cabang::all();
        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function laporandetail($noreff)
    {

        $detail 	    = Transaksidetail::where('no_ref', $noreff)->orderBy('id','desc')->paginate(8);
        $jumlah         = Transaksidetail::where('no_ref', $noreff)->sum('sub_total');
        $today          = date('Y-m-d');
        $tanggalnya     = $today;
        $tanggalnya2    = $today;
        $cb             = "JKT";
        $bzz            = "Hari";
        $jt             = "Semua Jenis";
        $role_kasir     = Transaksiheader::where('noref', $noreff)->first();
        $kasirnya       = $role_kasir->kasir;
        $kasir          = User::find($kasirnya);
        $cabang         = Cabang::all();
        return view('pos.kasirlaporandetail')->with('role_kasir', $role_kasir)->with('noreff', $noreff)->with('bzz', $bzz)->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function allrangeday($df, $dt, $cb, $jt)
    {
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = "Semua Kasir";
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Hari";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function allrangemonth($df, $dt, $cb, $jt)
    {
        $tahun          = date('Y');
        $olo            = $tahun.'-'.$df.'-01';
        $olo2           = $tahun.'-'.$dt.'-31';
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = "Semua Kasir";
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Bulan";
        $isinya = "";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function allrangeyear($df, $dt, $cb, $jt)
    {
        $olo         = $df.'-01-01';
        $olo2        = $dt.'-12-31';
        $tanggalnya  = $df;
        $tanggalnya2 = $dt;
        $kasirnya    = "Semua Kasir";
        $role_kasir  = '4';
        $kasir       = User::where('role_id', $role_kasir)->get();
        $cabang      = Cabang::all();
        $bzz         = "Tahun";
        $isinya = "";
        
        if ($cb > 0) {
            if ($jt != "test") {
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function kasirrangeday($id, $df, $dt, $cb, $jt)
    {
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = $id;
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Hari";


        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }


    public function kasirrangemonth($id, $df, $dt, $cb, $jt)
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


        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }


    public function kasirrangeyear($id, $df, $dt, $cb, $jt)
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


        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('kasir', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.kasirlaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





    public function allanggotarangeday($df, $dt, $cb, $jt)
    {
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = "Semua Anggota";
        $kasir   = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang = Cabang::all();
        $bzz = "Hari";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.anggotalaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function allanggotarangemonth($df, $dt, $cb, $jt)
    {
        $tahun = date('Y');
        $olo = $tahun.'-'.$df.'-01';
        $olo2 = $tahun.'-'.$dt.'-31';
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = "Semua Anggota";
        $kasir   = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang = Cabang::all();
        $bzz = "Bulan";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.anggotalaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function allanggotarangeyear($df, $dt, $cb, $jt)
    {
        $olo = $df.'-01-01';
        $olo2 = $dt.'-12-31';
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = "Semua Anggota";
        $kasir   = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang = Cabang::all();
        $bzz = "Tahun";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.anggotalaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }


    public function anggotarangeday($id, $df, $dt, $cb, $jt)
    {
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = $id;
        $kasir   = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang = Cabang::all();
        $bzz = "Hari";


        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.anggotalaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }


    public function anggotarangemonth($id, $df, $dt, $cb, $jt)
    {
        $tahun = date('Y');
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $olo = $tahun.'-'.$df.'-01';
        $olo2 = $tahun.'-'.$dt.'-31';
        $kasirnya = $id;
        $kasir   = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang = Cabang::all();
        $bzz = "Bulan";


        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.anggotalaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }


    public function anggotarangeyear($id, $df, $dt, $cb, $jt)
    {

        $olo = $df.'-01-01';
        $olo2 = $dt.'-12-31';
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya = $id;
        $kasir   = Anggota::where('jenis_nasabah', 'ANGGOTA')->get();
        $cabang = Cabang::all();
        $bzz = "Tahun";


        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $detail = Transaksiheader::where('no_kartu', $id)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.anggotalaporan')->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }

}