<?php

namespace App\Http\Controllers\Pos;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Inventory\Retur;
use PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksisementara;
use App\Model\Pos\ReturDetail;
use App\Model\Pos\ReturHeader;
use App\Model\Pos\Produk;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pengaturan\Profil;
use App\Model\Pengaturan\Nomor;
use App\Model\Master\Anggota;
use App\Model\Pos\Iklan;
use App\Model\Master\Cabang;
use App\User;
use App\Model\Inventory\LapBarangKeluar;
use Illuminate\Support\Facades\Auth;


class HoldController extends Controller
{

    public function alltoallhari($olo, $dt, $cb, $jt)
    {
        $koperasi = Profil::find(1);
        $tunda = "Tunda";
        $df = $olo.'&nbsp;sd&nbsp;'.$dt;
        $nama_koperasi = $koperasi->nama_koperasi;
        $alamat_koperasi = $koperasi->alamat_koperasi;
        $telepon_koperasi = $koperasi->telepon;
        $payment = "Payment";

        if ($cb > 0) {
            if ($jt != "test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->count();
                $pendapatan = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)-where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('cabang', $cb)->count();
                $pendapatan = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)-where('cabang', $cb)->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->count();
                $pendapatan = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->orderBy('id', 'desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->count();
                $pendapatan = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->paginate(8);
            }
        }

        if ($cb == 0) {
            $cbnya = "Semua Cabang";
        } else {
            $cabang = Cabang::find($cb);
            $cabangnya = $cabang->kode;
            $cbnya = $cabangnya;
        }

        if ($jt == "test") {
            $jenis = "Semua Jenis";
        } else {
            $jenis = $jt;
        }

        $pdf = PDF::loadView('pos.laporanretur_print', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4', 'potrait');
        return $pdf->stream('laporanretur_print.pdf');
    }

    public function alltoallbulan($olo, $dt, $cb, $jt)
    {
        $tahun = date('Y');
        $tanggalnya = $tahun.'-'.$olo.'-01';
        $tanggalnya2 = $tahun.'-'.$dt.'-31';
        $koperasi         = Profil::find(1);
        $tunda 		        = "Tunda";
        $df				        = $tanggalnya.'&nbsp;sd&nbsp;'.$tanggalnya2;
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		      = "Payment";
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->orderBy('id','desc')->paginate(8);
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


        $pdf = PDF::loadView('pos.laporanretur_print', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporanretur_print.pdf');


    }

    public function alltoalltahun($olo, $dt, $cb, $jt)
    {

        $tanggalnya       = $olo.'-01-01';
        $tanggalnya2      = $dt.'-12-31';
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;sd&nbsp;'.$tanggalnya2;
        $tunda 		      = "Tunda";
        $tgl 			  = date('Y-m-d');
        $namanya		  = 'Semua kasir';
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		      = "Payment";
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->sum('sub_total');
                $pendapatan     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->orderBy('id','desc')->paginate(8);
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



        $pdf = PDF::loadView('pos.laporanretur_print', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporanretur_print.pdf');


    }

    public function hari($id, $olo, $dt, $cb, $jt)
    {

        $koperasi         = Profil::find(1);
        $df				  = $olo.'&nbsp;sd&nbsp'.$dt;
        $tgl 			  = date('Y-m-d');
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $olo)->where('tanggal', '<=', $dt)->orderBy('id','desc')->paginate(8);
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



        $pdf = PDF::loadView('pos.laporanretur_print', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporanretur_print.pdf');


    }

    public function bulan($id, $olo, $dt, $cb, $jt)
    {
        $tahun = date('Y');
        $tanggalnya = $olo;
        $tanggalnya2 = $dt;
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        $namanya		  = 'Semua kasir';
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->orderBy('id','desc')->paginate(8);
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

        $pdf = PDF::loadView('pos.laporanretur_print', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporanretur_print.pdf');


    }

    public function tahun($id, $olo, $dt, $cb, $jt)
    {
        $tanggalnya       = $olo;
        $tanggalnya2      = $dt;
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah         = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->sum('sub_total');
                $pendapatan     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->orderBy('id','desc')->paginate(8);
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


        $pdf = PDF::loadView('pos.laporanretur_print', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporanretur_print.pdf');


    }

    public function showall($id, $df, $dt, $cb, $jt)
    {
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya  = "Semua Kasir";
        $role_kasir = '4';
        $kasir   = User::where('role_id',$role_kasir)->get();
        $cabang = Cabang::all();
        $produk = $id;
        $bzzz = "Hari";

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->where('type_pembayaran', $jt)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('produk', 'like', '%'.$id.'%')->orderBy('id','desc')->paginate(8);
            }
        }


        return view('pos.lapretur')->with('bzzz', $bzzz)->with('produk', $produk)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }

    public function showtoday($id, $df, $dt, $cb, $jt)
    {
        $tahun = date('Y');
        $tanggalnya = $tahun.'-'.$df.'-01';
        $tanggalnya2 = $tahun.'-'.$dt.'-31';
        $kasirnya  = "Semua Kasir";
        $role_kasir = '4';
        $kasir   = User::where('role_id',$role_kasir)->get();
        $cabang = Cabang::all();
        $produk = $id;
        $bzzz = "Bulan";

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->orderBy('id','desc')->paginate(8);
            }
        }

        return view('pos.lapretur')->with('bzzz', $bzzz)->with('produk', $produk)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya2', $tanggalnya2)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya);

    }

    public function showrange($id, $df, $dt, $cb, $jt)
    {
        $tanggalnya = $df.'-01-01';
        $tanggalnya2 = $dt.'-12-31';
        $kasirnya  = "Semua Kasir";
        $role_kasir = '4';
        $kasir   = User::where('role_id',$role_kasir)->get();
        $cabang = Cabang::all();
        $produk = $id;
        $bzzz = "Tahun";


        if ($cb>0) {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->sum('sub_total');
                $detail     = ReturDetail::where('produk', 'like', '%'.$id.'%')->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->orderBy('id','desc')->paginate(8);
            }
        }

        return view('pos.lapretur')->with('bzzz', $bzzz)->with('produk', $produk)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('detail', $detail)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2)->with('kasirnya', $kasirnya);

    }

    public function allkasirall($df, $dt, $cb, $jt)
    {
        $tanggalnya = $df;
        $tanggalnya2 = $dt;
        $kasirnya  = "Semua Kasir";
        $role_kasir = '4';
        $kasir   = User::where('role_id',$role_kasir)->get();
        $cabang = Cabang::all();
        $produk = "";
        $bzzz = "Hari";

        if ($cb>0) {
            if ($jt!="test") {
                $detail     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
                $jumlah     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->paginate(8);
            }
        }


        return view('pos.lapretur')->with('bzzz', $bzzz)->with('produk', $produk)->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function allkasirtoday($df, $dt, $cb, $jt)
    {
        $tahun = date('Y');
        $olo = $tahun.'-'.$df.'-01';
        $olo2 = $tahun.'-'.$dt.'-31';
        $kasirnya = "Semua Kasir";
        $role_kasir = '4';
        $kasir   = User::where('role_id',$role_kasir)->get();
        $today = date('Y-m-d');
        $date     = date('Y-m-d');
        $tanggalnya = $today;
        $tanggalnya2 = "Hari Ini";
        $cabang = Cabang::all();
        $produk = "";
        $bzzz = "Bulan";

        if ($cb>0) {
            if ($jt!="test") {
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id','desc')->paginate(8);
            }
        }
        return view('pos.lapretur')->with('bzzz', $bzzz)->with('produk', $produk)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('kasir', $kasir)->with('jumlah', $jumlah)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public function allkasirrange($df, $dt, $cb, $jt)
    {
        $olo = $df.'-01-01';
        $olo2 = $dt.'-12-31';
        $tanggalnya  = $df;
        $tanggalnya2 = $dt;
        $kasirnya    = "Semua Kasir";
        $role_kasir  = '4';
        $kasir       = User::where('role_id',$role_kasir)->get();
        $cabang      = Cabang::all();
        $produk         = "";
        $bzzz = "Tahun";

        if ($cb>0) {
            if ($jt!="test") {
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->sum('sub_total');
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->orderBy('id','desc')->paginate(8);
            }
        } else {
            if ($jt!="test") {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->orderBy('id','desc')->paginate(8);
            } else {
                $jumlah     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->sum('sub_total');
                $detail     = ReturDetail::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->orderBy('id','desc')->paginate(8);
            }
        }

        return view('pos.lapretur')->with('bzzz', $bzzz)->with('produk', $produk)->with('cabang', $cabang)->with('cb',$cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir',$kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public  function lapretur()
    {

        $detail 	= ReturDetail::orderBy('id','desc')->paginate(8);
        $jumlah  = ReturDetail::sum('sub_total');
        $today   = date('Y-m-d');
        $tanggalnya = $today;
        $tanggalnya2 = $today;
        $kasirnya = "Semua Kasir";
        $bzz = "Hari";
        $cb = "JKT";
        $id="";
        $bzzz = "";
        $maping  = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $jt = "Semua Jenis";
        $cabang = Cabang::all();
        return view('pos.lapretur')->with('bzzz', $bzzz)->with('id', $id)->with('produk', $produk)->with('cb', $cb)->with('bzz', $bzz)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function returnow(Request $request)
    {
        $norefnya   = $request->nomor;
        $trsheader  = Transaksiheader::where('noref', $norefnya)->first();
        $gettanggal = $trsheader->tanggal;
        $cabang     = $trsheader->cabang;
        $kasir      = $trsheader->kasir;
        $status     = $trsheader->status;
        $kartu      = $trsheader->no_kartu;
        $jumlahnya  = $trsheader->jumlah;



        foreach ($request->cbpilih as $key => $barangid) {

            $barang = Transaksidetail::find($key);

            $detail = new ReturDetail;
            $detail->produk = $barang->produk;
            $detail->barcode = $barang->barcode;
            $detail->no_ref = $request->nomor;
            $detail->type_pembayaran = $request->type;
            $detail->kasir = $barang->kasir;
            $detail->harga = $barang->harga;
            $detail->tanggal = date('Y-m-d');
            $detail->cabang = $barang->cabang;
            $detail->qty = $request['qty'.$key];
            $total = $request['qty'.$key] * $barang->harga;
            $detail->sub_total = $total;
            $detail->save();
        }

        $returbarang  = ReturDetail::where('no_ref', $norefnya)->get();
        $koperasi = Profil::find(1);
        $nama_koperasi = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $jumlah = ReturDetail::where('no_ref', $norefnya)->sum('sub_total');

        date_default_timezone_set('Asia/Jakarta');

        $header = JurnalHeader::create([
            'tipe' => "WASERDA",
            'kode_jurnal' => $this->_generatepos(),
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Retur POS'
        ]);
        $cabang = Cabang::find(Auth::user()->cabang);

        if ($trsheader->type = "cash") {
            $detail = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $cabang->akun_penjualan_wsd,
                'debet' => $jumlah,
                'kredit' => "",
                'nominal' => $jumlah
            ]);

            $detail2 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $cabang->akun_kas,
                'debet' => "",
                'kredit' => $jumlah,
                'nominal' => $jumlah
            ]);
        } else {
            $detail = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $cabang->akun_penjualan_wsd,
                'debet' => $jumlah,
                'kredit' => "",
                'nominal' => $jumlah
            ]);

            $detail2 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $cabang->akun_piutang_wsd,
                'debet' => "",
                'kredit' => $jumlah,
                'nominal' => $jumlah
            ]);
        }

        $nom = Nomor::where('modul', 'Jurnal Transaksi POS')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        $pdf = PDF::loadView('pos.strukretur',['returbarang' => $returbarang, 'kartu' => $kartu , 'jumlah' => $jumlah , 'alamat_koperasi' => $alamat_koperasi, 'kasir' => $kasir, 'nama_koperasi' => $nama_koperasi, 'norefnya' => $norefnya])->setPaper([0, 0, 250, 270], 'potrait');
        return $pdf->stream('strukretur.pdf');


    }
    public function test()
    {
        return view ('pos.test');
    }
    public function cekbarang($nomor)
    {
        $getheader = Transaksiheader::where('noref', $nomor)->where('cabang', Auth::user()->cabang)->first();
        if($getheader==null)
        {
            $stat = "FAIL";
            $jenis_pembayaran = "Tidak Ada";
            $nomornya = $nomor;

            $data[] = array(
                'stat' => $stat,
                'jenis_pembayaran' => $jenis_pembayaran,
                'noref' => $nomornya
            );
        }
        else {
            $stat = "OK";
            $getheader = Transaksiheader::where('noref', $nomor)->where('cabang', Auth::user()->cabang)->first();
            $jenis_pembayaran = $getheader->type_pembayaran;

            $data[] = array(
                'stat' => $stat,
                'jenis_pembayaran' => $jenis_pembayaran,
                'noref' => $nomor
            );
        }

        return json_encode($data);
    }
    public function retur($nomor, $jenis_pembayaran)
    {
        $produk = Transaksidetail::where('no_ref', $nomor)->get();
        return view('pos.returbarang')->with('produk', $produk)->with('nomor', $nomor)->with('jenis_pembayaran', $jenis_pembayaran);

    }
    public function backholding($noref, $id)
    {


       $rolenya        = Auth::user()->role_id;
       $iklan          = Iklan::find(1);
       $status         = $iklan->status;
	   $idkasir        = Auth::user()->id;
	   $namakasir      = Auth::user()->username;
        $maping    = \App\Model\Master\Cabang::find(Auth::user()->cabang);
        $cabangnyo = $maping->nama;
	  $sementaras         = Transaksidetail::where('no_ref',$noref)->where('cabang', $maping->id)->get();
	 foreach ($sementaras as $key)
	 {

            Transaksisementara::create([
            'barcode' 		=> $key->barcode,
            'harga' 		=> $key->harga,
            'produk'	    => $key->produk,
            'no_ref' 		=> $noref,
            'qty'		    => $key->qty,
            'konsinyasi'	=> $key->konsinyasi,
            'cabang'	    => $key->cabang,
            'sub_total'     => $key->sub_total

            ]);
         }


     $apusdetail =  Transaksidetail::where('no_ref', $noref)->delete();
     Transaksiheader::destroy($id);

     $total          = Transaksisementara::where('cabang', $maping->id)->sum('sub_total');
     $totaltranskasi = Transaksisementara::where('cabang', $maping->id)->count('no_ref');
     $produk 	     = Transaksisementara::where('cabang', $maping->id)->get();
     $sementara 	 = Transaksisementara::where('cabang', $maping->id)->get();

        return view('pos.penjualan')->with('sementara', $sementara)->with('cabangnyo', $cabangnyo)->with('iklan',$iklan)->with('produk',$produk)->with('total', $total)->with('noref',$noref)->with('totaltranskasi', $totaltranskasi)->with('idkasir',$idkasir)->with('namakasir',$namakasir)->with('status', $status)->with('rolenya', $rolenya);


    }

    public function formatnya($kode, $digit, $frmt) {
        date_default_timezone_set('Asia/Jakarta');
        $cabang = Cabang::find(Auth::user()->cabang);

        if ($frmt == "kdcab") {
            $format = $cabang->kode;
        } else if ($frmt == "kode") {
            $format = $kode;
        } else if ($frmt == "digit") {
            $format = $digit;
        } else if ($frmt == "bulan") {
            $format = date('m');
        } else if ($frmt == "tahun") {
            $format = date('Y');
        } else if ($frmt == "bulantahun") {
            $format = date('mY');
        } else if ($frmt == "tahunbulan") {
            $format = date('Ym');
        } else {
            $format = "";
        }

        return $format;
    }

    public function _generatepos() {
        $nom = Nomor::where('modul', 'Jurnal Transaksi POS')->first();

        if($nom==null){
            $kode = "Kode Belum Disetting";
            return $kode;
        } else {

            $last_data = $nom->nomor_now;
            $last_digit = $nom->nomor_akhir;
            $last_length = 0;
            $l = 1;

            if($last_data > 0){
                $last_digit = (int) $last_data;
                $last_length = strlen($last_digit);
                $l = 0;
            }

            if ($last_digit == 9 || $last_digit == 99 || $last_digit == 999 || $last_digit == 9999 || $last_digit == 99999) {
                $jml_digit = $nom->jumlah_digit - 1;
            } else if ($last_digit == 999999 || $last_digit == 9999999 || $last_digit == 99999999 || $last_digit == 999999999) {
                $jml_digit = $nom->jumlah_digit - 1;
            } else {
                $jml_digit = $nom->jumlah_digit;
            }

            $digit = "";
            for ($i=$l; $i < $jml_digit - $last_length; $i++) {
                $digit .= '0';
            }

            $digit .= intval($last_digit) + 1;
            $f = $this->formatnya($nom->kode, $digit, $nom->kode_awal);
            $f2 = $this->formatnya($nom->kode, $digit, $nom->kode_awal2);
            $f3 = $this->formatnya($nom->kode, $digit, $nom->kode_awal3);
            $f4 = $this->formatnya($nom->kode, $digit, $nom->kode_awal4);
            $kode = $f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

            return $kode;
        }

    }
}
