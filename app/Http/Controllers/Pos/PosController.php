<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksisementara;
use App\Model\Pos\Produk;
use PDF;
use App\User;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pengaturan\Profil;
use App\Model\Pengaturan\Nomor;
use App\Model\Master\Anggota;
use App\Model\Master\Cabang;
use App\Model\Inventory\LapBarangKeluar;
use Illuminate\Support\Facades\Auth;


class PosController extends Controller
{
 public function __construct()
 {
 $this->middleware('auth');
 }
    public function invoice()
    {
        $pdf = PDF::loadView('pos.invoice')->setPaper('a4', 'potrait');
        return $pdf->stream('invoice.pdf');
    }
public function cetak()
{
    $rolenya = Auth::user()->role_id;
    return view('pos.cetak')->with('rolenya', $rolenya);
}
    public function laporanpenjualan()
    {
        $rolenya = Auth::user()->role_id;
        return view('pos.menulaporan')->with('rolenya', $rolenya);
    }
    public function transaksi()
    {
        $rolenya = Auth::user()->role_id;
        return view('pos.menupenjualan')->with('rolenya', $rolenya);
    }
    
public function import()
{
   return view('inventory.importproduk');
}

public function menukasir()
{
  return view('pos.menukasir');
}
public function index(){
$user = Auth::user()->cabang;
$cabang = Cabang::find($user);
return view('pos.index')->with('cabang', $cabang);

}
public function ceksaldo()
{
	return view('pos.ceksaldo');
}
public function cekretur()
{
	return view('pos.cekretur');
}
public function returbarang()
{
	return view('pos.returbarang');
}
public function saldonya($saldonya, $kartunya, $totaltrs)
{
    $getsaldo = Anggota::where('npk', $kartunya)->first();

	return view('pos.saldo')->with('kartunya', $kartunya)->with('saldonya', $saldonya)->with('totaltrs', $totaltrs)->with('getsaldo', $getsaldo);
}
public function pwsupervisor(){

	return view('pos.pwsupervisor');
}
public function hold()
{
	return view('pos.hold');
}
public function transaksiautodebet()
{
	return view('pos.transaksiautodebet');
}
public function cashtotal($total, $ck1, $ck2, $norefnya)
{
	return view('pos.cash')->with('total',$total)->with('ck1',$ck1)->with('ck2',$ck2)->with('norefnya', $norefnya);
}
public function tunda($total, $ck1, $ck2, $norefnya)
{
	return view('pos.tunda')->with('total',$total)->with('ck1',$ck1)->with('ck2',$ck2)->with('norefnya', $norefnya);
}
public function autodebet($total, $ck1, $ck2, $ck3, $norefnya)
{
	  return view('pos.autodebet')->with('total',$total)->with('ck1',$ck1)->with('ck2',$ck2)->with('ck3',$ck3)->with('norefnya', $norefnya);
}
public function totalkembali($pembayaran, $kembali, $noref)
{
	return view('pos.berhasil')->with('pembayaran',$pembayaran)->with('kembali',$kembali)->with('noref',$noref);
}
public function berhasildebet($sisasaldo, $kartu, $noref)
{
	return view('pos.berhasildebet')->with('sisasaldo',$sisasaldo)->with('kartu',$kartu)->with('noref',$noref);
}
public function berhasiltunda($kartu, $total, $noref)
{
	return view('pos.tundaberhasil')->with('kartu',$kartu)->with('total',$total)->with('noref',$noref);

}

    public function cekberhasiltunda($kartu, $id, $norefnya)
    {
        $totaltrs = Transaksiheader::where('no_kartu', $kartu)->sum('jumlah');
        $anggota = Anggota::find($id);
        $namanya = $anggota->jenis_nasabah;
        $status = $anggota->status;
        return view('pos.admin')->with('status', $status)->with('totaltrs', $totaltrs)->with('kartu',$kartu)->with('anggota',$anggota)->with('norefnya', $norefnya)->with('namanya', $namanya);
    }

public function totalsaldo($total, $kartu, $norefnya)
{
	return view('pos.autodebets')->with('total',$total)->with('kartu',$kartu)->with('norefnya', $norefnya);
}
public function paymenttotal($total, $ck1, $ck2, $norefnya)
{
	 return view('pos.payment')->with('total',$total)->with('ck1',$ck1)->with('ck2',$ck2)->with('norefnya', $norefnya);
}
    public function printsaldo($kartu)
    {
        $koperasi        = Profil::find(1);
        $getsaldo        = Anggota::where('npk', $kartu)->first();
        $totaltrs = Transaksiheader::where('no_kartu', $kartu)->sum('jumlah');
        $saldo           = 0;
        foreach ($getsaldo->simpananid as $simp) {
            $saldo += $simp->akumulasiid->saldo;

        }
        $pdf = PDF::loadView('pos.printsaldo', ['koperasi' => $koperasi, 'getsaldo' => $getsaldo ,'saldo' => $saldo , 'kartu' => $kartu, 'totaltrs' => $totaltrs])->setPaper([0, 0, 250, 270], 'potrait');;
        return $pdf->stream('printsaldo.pdf');
    }
public function printcash($noref, $bayaran, $balian)
{

	$koperasi        = Profil::find(1);
	$namakasir       = Auth::user()->username;
	$nama_koperasi   = $koperasi->nama_koperasi;
	$alamat_koperasi = $koperasi->alamat_koperasi;
	$barangnya       = Transaksiheader::where('noref', $noref)->where('cabang', Auth::user()->cabang)->first();
	$produk			 = Transaksidetail::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->get();
    $diskon          = Transaksidetail::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->sum('diskon');
	$totalnya		 = Transaksidetail::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->sum('sub_total');
    if($diskon == 0)
    {
        $total_bersih = $totalnya;
        $kembalian = $balian;
    }
    else
    {
        $total_bersih = $totalnya - $diskon;
        $kembalian    = $bayaran - $total_bersih;
    }

	//return view('pos.printcash')->with('nama_koperasi', $nama_koperasi)->with('namakasir', $namakasir)->with('alamat_koperasi', $alamat_koperasi)->with('noref', $noref)->with('bayaran', $bayaran)->with('balian', $balian)->with('totalnya', $totalnya)->with('produk', $produk);

	 $pdf = PDF::loadView('pos.printcash', ['nama_koperasi' => $nama_koperasi, 'total_bersih' => $total_bersih , 'diskon' => $diskon, 'namakasir' => $namakasir, 'alamat_koperasi' => $alamat_koperasi, 'noref' => $noref, 'bayaran' => $bayaran, 'kembalian' => $kembalian, 'totalnya' => $totalnya, 'produk' => $produk])->setPaper([0, 0, 250, 270], 'potrait');
     return $pdf->stream('printcash.pdf');
}
public function printkartu($noref, $saldonya, $sisasal)
{
	$koperasi        = Profil::find(1);
	$namakasir       = Auth::user()->username;
	$nama_koperasi   = $koperasi->nama_koperasi;
	$alamat_koperasi = $koperasi->alamat_koperasi;
	$barangnya       = Transaksiheader::where('noref', $noref)->first();
	$produk			 = Transaksidetail::where('no_ref', $noref)->get();
	$totalnya		 = $barangnya->jumlah;
	$totaaaal		 = $barangnya->jumlah;

//	return view('pos.printkartu')->with('namakasir',$namakasir)->with('nama_koperasi',$nama_koperasi)->with('alamat_koperasi',$alamat_koperasi)->with('totalnya',$totalnya)->with('produk',$produk)->with('noref', $noref)->with('saldonya', $saldonya)->with('sisasal',$sisasal);
	$pdf = PDF::loadView('pos.printkartu', ['nama_koperasi' => $nama_koperasi, 'namakasir' => $namakasir, 'alamat_koperasi' => $alamat_koperasi, 'noref' => $noref, 'saldonya' => $saldonya, 'sisasal' => $sisasal, 'totalnya' => $totalnya, 'produk' => $produk])->setPaper([0, 0, 250, 270], 'potrait');;
    return $pdf->stream('printkartu.pdf');

}

public function printunda($kartu, $total, $noref)
{
	$koperasi        = Profil::find(1);
	$namakasir       = Auth::user()->username;
	$barangnya       = Transaksiheader::where('noref', $noref)->where('cabang', Auth::user()->cabang)->first();
	$produk			 = Transaksidetail::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->get();
    $diskon			 = Transaksidetail::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->sum('diskon');
    $totaltrs		 = Transaksiheader::where('no_kartu', $kartu)->where('cabang', Auth::user()->cabang)->sum('jumlah');
	$totalnya		 = Transaksidetail::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->sum('sub_total');
    $getanggota      = Anggota::where('npk', $kartu)->first();

    if($diskon == 0)
    {
        $total_bersih = $totaltrs;
    }
    else
    {
        $total_bersih = $totaltrs;
    }


    $pdf = PDF::loadView('pos.printtunda', ['total_bersih' => $total_bersih, 'diskon' => $diskon, 'namakasir' => $namakasir, 'koperasi' => $koperasi, 'noref' => $noref, 'totalnya' => $totalnya, 'produk' => $produk, 'getanggota' => $getanggota])->setPaper([0, 0, 250, 270], 'potrait');;
    return $pdf->stream('printkartu.pdf');

}

public function kasirtahunan()
{
	 return view('pos.kasirtahunan');
}

public function pdftodayall($df, $cb, $jt)
{


	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$namanya          = "Semua Kasir";
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

          if ($cb>0) {
            if ($jt!="test") {
              $jumlah         = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
              $pendapatan     = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
            } else {
              $jumlah         = Transaksiheader::where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
              $pendapatan     = Transaksiheader::where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
            }
          } else {
            if ($jt!="test") {
              $jumlah         = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
              $pendapatan     = Transaksiheader::where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
            } else {
              $jumlah         = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->sum('jumlah');
              $pendapatan     = Transaksiheader::where('tanggal', $df)->where('status', '!=', 'Hold')->orderBy('id','desc');
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


    $pdf = PDF::loadView('pos.laporankasir', ['nama_koperasi' => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan' => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasir.pdf');


}
public function pdftoday($idkasir, $df, $cb, $jt)
{

    $koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$namakasir        = User::where('id', $idkasir)->first();
	$namanya		  = $namakasir->username;
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $df)->where('status', '!=', 'Hold')->orderBy('id','desc');
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

    $pdf = PDF::loadView('pos.laporankasir', ['nama_koperasi' => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan' => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasir.pdf');


}
public function pdfbulanall($df, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$namanya          = "Semua Kasir";
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc');
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


    $pdf = PDF::loadView('pos.laporankasirbulan', ['nama_koperasi' => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan' => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirbulan.pdf');


}
public function pdfbulan($idkasir, $df, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$namakasir        = User::where('id', $idkasir)->first();
	$namanya		  = $namakasir->username;
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', '%-'.$df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc');
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

    $pdf = PDF::loadView('pos.laporankasirbulan', ['nama_koperasi' => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan' => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirbulan.pdf');


}
public function pdftahun($idkasir, $df, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$namakasir        = User::where('id', $idkasir)->first();
	$namanya		  = $namakasir->username;
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc');
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

    $pdf = PDF::loadView('pos.laporankasirtahun', ['nama_koperasi' => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan' => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirtahun.pdf');


}
public function pdftahunall($df, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$namanya		  = 'Semua kasir';
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', 'like', $df.'-%')->where('status', '!=', 'Hold')->orderBy('id','desc');
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

    $pdf = PDF::loadView('pos.laporankasirtahun', ['nama_koperasi' => $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan' => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirtahun.pdf');


}

public function alltoall($cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$df				  = 'ALL DAY';
	$namanya		  = 'Semua Kasir';
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('status', '!=', 'Hold')->orderBy('id','desc');
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

    $pdf = PDF::loadView('pos.laporankasirperiodik', ['nama_koperasi'
    	=> $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
     => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirperiodik.pdf');


}

public function allto($idkasir, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$df				  = 'ALL DAY';
	$namakasir        = User::where('id', $idkasir)->first();
	$namanya		  = $namakasir->username;
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('status', '!=', 'Hold')->orderBy('id','desc');
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
    return $pdf->stream('laporankasirperiodik.pdf');


}

public function todaytoall($cb, $jt)
{
	$koperasi           = Profil::find(1);
	$df				    = 'Hari Ini';
	$tunda 		        = "Tunda";
	$tgl 			    = date('Y-m-d');
	$namanya		    = 'Semua Kasir';
	$nama_koperasi      = $koperasi->nama_koperasi;
	$alamat_koperasi    = $koperasi->alamat_koperasi;
	$telepon_koperasi   =  $koperasi->telepon;
	$payment 		    = "Payment";
    $jenis              = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('tanggal', $tgl)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', $tgl)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('tanggal', $tgl)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('tanggal', $tgl)->where('status', '!=', 'Hold')->orderBy('id','desc');
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



    $pdf = PDF::loadView('pos.laporankasirperiodik', ['nama_koperasi'
    	=> $nama_koperasi, 'alamat_koperasi' => $alamat_koperasi, 'jumlah' => $jumlah, 'pendapatan'
     => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirperiodik.pdf');


}

public function todayto($idkasir, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$df				  = 'Hari Ini';
	$tunda 		      = "Tunda";
	$tgl 			  = date('Y-m-d');
	$namakasir        = User::where('id', $idkasir)->first();
	$namanya		  = $namakasir->username;
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc');
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc');
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', $tgl)->where('status', '!=', 'Hold')->orderBy('id','desc');
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
    return $pdf->stream('laporankasirperiodik.pdf');


}

public function rangetoall($dk, $dt, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$df				  = $dk.'&nbsp;sd&nbsp;'.$dt;
	$namanya		  = 'Semua Kasir';
	$tunda 		      = "Tunda";
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
    } else {
      $jumlah         = Transaksiheader::where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->paginate(10000000);
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

    $pdf = PDF::loadView('pos.laporankasirperiodik', ['koperasi'
    	=> $koperasi, 'jumlah' => $jumlah, 'pendapatan'
     => $pendapatan, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirperiodik.pdf');


}

    public function rangetoallbln($dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $tahun            = date('Y');
        $tanggalnya       = $dk;
        $tanggalnya2      = $dt;
        $olo              = $tahun.'-'.$dk.'-01';
        $olo2             = $tahun.'-'.$dt.'-31';
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namanya		  = 'Semua Kasir';
        $tunda 		      = "Tunda";
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->paginate(10000000);
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

        $pdf = PDF::loadView('pos.laporankasirperiodik', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporankasirperiodik.pdf');


    }
    public function rangetoallthn($dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $df		          = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namanya		  = 'Semua Kasir';
        $tunda 		      = "Tunda";
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->paginate(10000000);
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

        $pdf = PDF::loadView('pos.laporankasirperiodik', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporankasirperiodik.pdf');


    }
    ///////////////////////////////////////

    public function anggotatoall($dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $df				  = $dk.'&nbsp;sd&nbsp;'.$dt;
        $namanya		  = 'Semua Anggota';
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";
        $jenis            = $jt;
        $idkasir          = "0";
        
        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->get();
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->get();
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->get();
            } else {

                $jumlah         = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->get();
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

        $pdf = PDF::loadView('pos.anggotalaporannya', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'idkasir' => $idkasir , 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('anggotalaporannya.pdf');

    }

    public function anggotatoallbln($dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $tahun            = date('Y');
        $olo              = $tahun.'-'.$dk.'-01';
        $olo2             = $tahun.'-'.$dt.'-31';
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namanya		  = 'Semua Anggota';
        $npknya           = "0";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->paginate(10000000);
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

        $pdf = PDF::loadView('pos.anggotalaporannya', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'npknya' => $npknya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('anggotalaporannya.pdf');


    }
    public function anggotatoallthn($dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $df		          = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namanya		  = 'Semua Anggota';
        $npknya           = "0";
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->paginate(10000000);
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

        $pdf = PDF::loadView('pos.anggotalaporannya', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'npknya' => $npknya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('anggotalaporannya.pdf');


    }

public function rangeto($idkasir, $dk, $dt, $cb, $jt)
{
	$koperasi         = Profil::find(1);
	$tunda 		      = "Tunda";
	$df				  = $dk.'&nbsp;sd&nbsp;'.$dt;
	$tgl 			  = date('Y-m-d');
	$namakasir        = User::where('id', $idkasir)->first();
	$namanya		  = $namakasir->username;
	$nama_koperasi    = $koperasi->nama_koperasi;
	$alamat_koperasi  = $koperasi->alamat_koperasi;
	$telepon_koperasi =  $koperasi->telepon;
	$payment 		  = "Payment";
	$tunda 		      = "Tunda";
    $jenis            = $jt;

  if ($cb>0) {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
    }
  } else {
    if ($jt!="test") {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
    } else {
      $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
      $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
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


    $pdf = PDF::loadView('pos.laporankasirperiodik', ['koperasi'
    	=> $koperasi, 'jumlah' => $jumlah, 'pendapatan'
     => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
    return $pdf->stream('laporankasirperiodik.pdf');


}
    public function rangetobln($idkasir, $dk, $dt, $cb, $jt)
    {
        $tahun            = date('Y');
        $koperasi         = Profil::find(1);
        $tunda 		      = "Tunda";
        $tanggalnya       = $dk;
        $tanggalnya2      = $dt;
        $olo              = $tahun.'-'.$dk.'-01';
        $olo2             = $tahun.'-'.$dt.'-31';
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $tgl 			  = date('Y-m-d');
        $namakasir        = User::where('id', $idkasir)->first();
        $namanya		  = $namakasir->username;
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";
        $tunda 		      = "Tunda";
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
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


        $pdf = PDF::loadView('pos.laporankasirperiodik', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporankasirperiodik.pdf');


    }

    public function rangetothn($idkasir, $dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $tunda 		      = "Tunda";
        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $df		          = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $tgl 			  = date('Y-m-d');
        $namakasir        = User::where('id', $idkasir)->first();
        $namanya		  = $namakasir->username;
        $nama_koperasi    = $koperasi->nama_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $alamat_koperasi  = $koperasi->alamat_koperasi;
        $telepon_koperasi =  $koperasi->telepon;
        $payment 		  = "Payment";
        $tunda 		      = "Tunda";
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('kasir', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
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


        $pdf = PDF::loadView('pos.laporankasirperiodik', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('laporankasirperiodik.pdf');


    }

    public function anggotato($idkasir, $dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $df				  = $dk.'&nbsp;sd&nbsp;'.$dt;
        $namakasir        = Anggota::where('npk', $idkasir)->first();
        $namanya          = $namakasir->nama;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $dk)->where('tanggal', '<=', $dt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
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


        $pdf = PDF::loadView('pos.anggotalaporannya', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'idkasir' => $idkasir,  'namanya' => $namanya, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('anggotalaporannya.pdf');


    }
    public function anggotatobln($idkasir, $dk, $dt, $cb, $jt)
    {
        $tahun            = date('Y');
        $koperasi         = Profil::find(1);
        $olo              = $tahun.'-'.$dk.'-01';
        $olo2             = $tahun.'-'.$dt.'-31';
        $df				  = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namakasir        = Anggota::where('npk', $idkasir)->first();
        $namanya          = $namakasir->nama;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
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


        $pdf = PDF::loadView('pos.anggotalaporannya', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'idkasir' => $idkasir, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('anggotalaporannya.pdf');


    }

    public function anggotatothn($idkasir, $dk, $dt, $cb, $jt)
    {
        $koperasi         = Profil::find(1);
        $olo              = $dk.'-01-01';
        $olo2             = $dt.'-12-31';
        $df		          = $olo.'&nbsp;sd&nbsp;'.$olo2;
        $namakasir        = Anggota::where('npk', $idkasir)->first();
        $namanya          = $namakasir->nama;
        $telepon_koperasi =  $koperasi->telepon;
        $jenis            = $jt;

        if ($cb>0) {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('cabang', $cb)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            }
        } else {
            if ($jt!="test") {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('type_pembayaran', $jt)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
            } else {
                $jumlah         = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->sum('jumlah');
                $pendapatan     = Transaksiheader::where('no_kartu', $idkasir)->where('tanggal', '>=', $olo)->where('tanggal', '<=', $olo2)->where('status', '!=', 'Hold')->orderBy('id','desc')->paginate(10000000);
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


        $pdf = PDF::loadView('pos.anggotalaporannya', ['koperasi'
        => $koperasi, 'jumlah' => $jumlah, 'pendapatan'
        => $pendapatan, 'telepon_koperasi' => $telepon_koperasi, 'df' => $df, 'namanya' => $namanya, 'idkasir' => $idkasir, 'cbnya' => $cbnya, 'jenis' => $jenis])->setPaper('a4','potrait');
        return $pdf->stream('anggotalaporannya.pdf');


    }

}
