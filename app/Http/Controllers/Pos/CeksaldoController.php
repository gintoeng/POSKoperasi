<?php

namespace App\Http\Controllers\Pos;
use App\Http\Controllers\Inventory\laporan\LapBarangKeluarController;
use App\Model\Inventory\LapBarangKeluar;
use App\Model\Master\Cabang;
use App\Model\Pengaturan\Profil;
use App\Model\Pos\Produk;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pos\Transaksisementara;
use App\Model\Master\Anggota;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Akumulasi;
use Illuminate\Support\Facades\DB;
use Session;
use App\User;
use PDF;

class CeksaldoController extends Controller
{
    public function pdfstokallday($df, $dt, $cb, $jt)
    {
        $tanggalnya       = $df;
        $tanggalnya2      = $dt;
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        $namanya		  = 'Semua Jenis';
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb > 0) {
            if ($jt != "test") {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('id', 'desc')->paginate(8);
            } else {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('id_cabang', $cb)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            } else {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya            = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }

        $pdf = PDF::loadView('pos.fastslowprint', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'koperasi' => $koperasi, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporan_fastmoving_slowmoving.pdf');


    }
    public function pdfstokday($fastslow, $df, $dt, $cb, $jt)
    {
        $tanggalnya       = $df;
        $tanggalnya2      = $dt;
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        if($fastslow=="1")
        {
            $namanya		  = "Fast Moving";
        }
        else
        {
            $namanya		  = "Slow Moving";
        }
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if($fastslow=="1")
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            }

        }
        else
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'asc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                } else {


                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            }

        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya            = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }

        $pdf = PDF::loadView('pos.fastslowprint', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'koperasi' => $koperasi, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporan_fastmoving_slowmoving.pdf');


    }

    public function pdfstokallmonth($df, $dt, $cb, $jt)
    {
        $tahun            = date('Y');
        $tanggalnya       = $tahun.'-'.$df.'-01';
        $tanggalnya2      = $tahun.'-'.$dt.'-31';
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        $namanya		  = 'Semua Jenis';
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi = $koperasi->telepon;
        $jenis            = $jt;

        if ($cb > 0) {
            if ($jt != "test") {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('id', 'desc')->paginate(8);
            } else {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('id_cabang', $cb)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            } else {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya            = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }

        $pdf = PDF::loadView('pos.fastslowprint', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'koperasi' => $koperasi, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporan_fastmoving_slowmoving.pdf');


    }
    public function pdfstokmonth($fastslow, $df, $dt, $cb, $jt)
    {
        $tahun            = date('Y');
        $tanggalnya       = $tahun.'-'.$df.'-01';
        $tanggalnya2      = $tahun.'-'.$dt.'-31';
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        if($fastslow=="1")
        {
            $namanya		  = "Fast Moving";
        }
        else
        {
            $namanya		  = "Slow Moving";
        }
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi = $koperasi->telepon;
        $jenis            = $jt;

        if($fastslow=="1")
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);

                }
            }

        }
        else
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'asc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                } else {


                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            }

        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya            = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }

        $pdf = PDF::loadView('pos.fastslowprint', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'koperasi' => $koperasi, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporan_fastmoving_slowmoving.pdf');


    }

    public function pdfstokallyear($df, $dt, $cb, $jt)
    {

        $tanggalnya       = $df.'-01-01';
        $tanggalnya2      = $dt.'-12-31';
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        $namanya		  = 'Semua Jenis';
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi = $koperasi->telepon;
        $jenis            = $jt;

        if ($cb > 0) {
            if ($jt != "test") {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('id', 'desc')->paginate(8);
            } else {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('id_cabang', $cb)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            } else {
                $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya            = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }

        $pdf = PDF::loadView('pos.fastslowprint', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'koperasi' => $koperasi, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporan_fastmoving_slowmoving.pdf');


    }

    public function pdfstokyear($fastslow, $df, $dt, $cb, $jt)
    {

        $tanggalnya       = $df.'-01-01';
        $tanggalnya2      = $dt.'-12-31';
        $koperasi         = Profil::find(1);
        $df				  = $tanggalnya.'&nbsp;-&nbsp;'.$tanggalnya2;
        if($fastslow=="1")
        {
            $namanya		  = "Fast Moving";
        }
        else
        {
            $namanya		  = "Slow Moving";
        }

        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi = $koperasi->telepon;
        $jenis            = $jt;

        if($fastslow=="1")
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            }

        }
        else
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'asc')->paginate(8);
                } else {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                } else {


                    $pendapatan = LapBarangKeluar::select(DB::raw('jenis_pembayaran,expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $tanggalnya)->where('tanggal', '<=', $tanggalnya2)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            }

        }

        if ($cb==0) {
            $cbnya = "Semua Cabang";
        }
        else{
            $cabang           = Cabang::find($cb);
            $cabangnya        = $cabang->kode;
            $cbnya            = $cabangnya;
        }

        if ($jt=="test"){
            $jenis = "Semua Jenis";
        }

        $pdf = PDF::loadView('pos.fastslowprint', ['nama_koperasi'
        => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'koperasi' => $koperasi, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporan_fastmoving_slowmoving.pdf');


    }

    public function indexproduk()
    {
        $detail 	 = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->groupby('expired')->orderby('id','desc')->paginate(8);
        $jumlah      = Transaksiheader::all()->sum('jumlah');
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
        $isinya      = "";
        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cb', $cb)->with('jt', $jt)->with('cabang', $cabang)->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir)->with('tanggalnya', $tanggalnya)->with('kasirnya', $kasirnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function stokallday($df, $dt, $cb, $jt)
    {
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = "Semua Kasir";
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Hari";
        $jumlah         = "0";
        $isinya         = "";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('id', 'desc')->paginate(8);
            } else {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('id_cabang', $cb)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            } else {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function stokallmonth($df, $dt, $cb, $jt)
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
        $jumlah         = "0";
        $isinya         = "";

        if ($cb > 0) {
            if ($jt != "test") {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('id', 'desc')->paginate(8);
            } else {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('id_cabang', $cb)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            } else {
                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }
    public function stokallyear($df, $dt, $cb, $jt)
    {
        $olo            = $df.'-01-01';
        $olo2           = $dt.'-12-31';
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = "Semua Kasir";
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Tahun";
        $jumlah         = "0";
        $isinya         = "";

        if ($cb > 0) {
            if ($jt != "test") {

                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('id', 'desc')->paginate(8);
            } else {

                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('id_cabang', $cb)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        } else {
            if ($jt != "test") {

                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            } else {

                $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->groupby('expired')->orderBy('id', 'desc')->paginate(8);
            }
        }

        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public function stokyear($fastslow, $df, $dt, $cb, $jt)
    {
        $olo            = $df.'-01-01';
        $olo2           = $dt.'-12-31';
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = $fastslow;
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Tahun";
        $jumlah         = "0";
        $isinya         = $fastslow;

        if($fastslow=="1")
{
    if ($cb > 0) {
        if ($jt != "test") {

            $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'desc')->paginate(8);
        } else {

            $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
        }
    } else {
        if ($jt != "test") {

            $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
        } else {

            $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
        }
    }

}
        else
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'asc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                } else {


                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            }

        }

        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public function stokmonth($fastslow, $df, $dt, $cb, $jt)
    {
        $tahun          = date('Y');
        $olo            = $tahun.'-'.$df.'-01';
        $olo2           = $tahun.'-'.$dt.'-31';
        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = $fastslow;
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Bulan";
        $jumlah         = "0";
        $isinya         = $fastslow;

        if($fastslow=="1")
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            }

        }
        else
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'asc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                } else {


                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            }

        }

        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public function stokday($fastslow, $df, $dt, $cb, $jt)
    {

        $tanggalnya     = $df;
        $tanggalnya2    = $dt;
        $kasirnya       = $fastslow;
        $role_kasir     = '4';
        $kasir          = User::where('role_id', $role_kasir)->get();
        $cabang         = Cabang::all();
        $bzz            = "Hari";
        $jumlah         = "0";
        $isinya         = $fastslow;

        if($fastslow=="1")
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->groupby('expired')->orderBy('jumlah_qty', 'desc')->paginate(8);
                }
            }

        }
        else
        {
            if ($cb > 0) {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->where('id_cabang', $cb)->groupby('expired')->orderby('jumlah_qty', 'asc')->paginate(8);
                } else {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('id_cabang', $cb)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            } else {
                if ($jt != "test") {

                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('jenis_pembayaran', $jt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                } else {


                    $detail = LapBarangKeluar::select(DB::raw('expired,barcode,nama,harga_beli,sum(qty) as jumlah_qty'))->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->groupby('expired')->orderBy('jumlah_qty', 'asc')->paginate(8);
                }
            }

        }

        return view('pos.fastslow')->with('isinya', $isinya)->with('bzz', $bzz)->with('cabang', $cabang)->with('cb', $cb)->with('jt', $jt)->with('detail', $detail)->with('jumlah', $jumlah)->with('kasir', $kasir)->with('kasirnya', $kasirnya)->with('tanggalnya', $tanggalnya)->with('tanggalnya2', $tanggalnya2);

    }

    public function ceksaldo($kartu)
    {
    	 $getsaldo = Anggota::where('npk', $kartu)->first();
        //$potong = substr($getsaldo->nama,0);

//        dd($potong);
        if ($getsaldo == null)
        {
            $stat = "Fail";
            $saldo = "0";
            $kartu = "Tidak Ada";
            $totaltrs = "0";

        }
        else {
            $stat = "OK";
            $kartu = $getsaldo->npk;
            $totaltrs = Transaksiheader::where('no_kartu', $kartu)->sum('jumlah');
            if($totaltrs==null)
            {
                $totaltransaksi = "0";
            }
            else
            {
                $totaltransaksi = $totaltrs;
            }
            $saldo = 0;
            foreach ($getsaldo->simpananid as $simp) {
                $saldo += $simp->akumulasiid->saldo;

            }
        }


     $data[] = array(
      'stat'      => $stat,
      'saldo'     => $saldo,
      'nokartu'   => $kartu,
      'totaltrs'  => $totaltransaksi,
    );
    return json_encode($data);
    
    	   	
    }
      public function cekpw(Request $request)
    {

   $idsp 	     = '2';
   $getidsp    = User::where('role_id', $idsp)->where('password', $request->Epin)->first();
   $payment    = 'Payment';
   $detail 	   = Transaksiheader::where('status',$payment)->paginate(10);
   $jumlah     = Transaksiheader::all()->sum('jumlah');
   $today      = date('m-d-Y');
   $role_kasir = '4';
   $kasir      = User::where('role_id',$role_kasir)->get();
   
   return view('pos.kasir')->with('detail',$detail)->with('jumlah',$jumlah)->with('today',$today)->with('kasir',$kasir);

    	   	
    }

}
