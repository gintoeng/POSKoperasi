<?php namespace App\Http\Controllers\Pos;

use App\Model\Master\Cabang;
use App\Model\Master\Mappingbarang;
use App\Model\Pos\Hpp;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksisementara;
use App\Model\Pos\Produk;
use App\Model\Pos\Mstok;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pengaturan\Profil;
use App\Model\Pengaturan\Nomor;
use App\Model\Pos\Iklan;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Inventory\pembelianSupplierDetail;
use App\User;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{


    public function destroy($id)
    {
       
        Transaksisementara::destroy($id);
        return redirect( url('pos/penjualan'));

    }
    public function hitunghpp()
    {

        $date = date('Y-m-d');
        $persediaan_akhir = Transaksidetail::where('tanggal', $date)->orderby('id','desc')->first();

        if ($persediaan_akhir == null)
        {
            $berhasil = "gagal";

        }
        else
        {
            $hppya = Hpp::where('tanggal', $date)->orderby('id', 'desc')->limit(1)->first();


            if($hppya == null)
            {


                $persediaan_akhir = Transaksidetail::where('tanggal', $date)->where('konsinyasi', "0")->orderby('id','desc')->get();
                foreach ($persediaan_akhir as $akhir)
                {
                    $maping = \App\Model\Master\Cabang::find(Auth::user()->cabang);
                    $produk = $maping->mappingproduk->where('nama', $akhir->produk)->first();
                    $detail = Transaksidetail::where('barcode', $produk->barcode)->where('tanggal', $date)->sum('qty');
                    $pers_akhir = $detail * $akhir->harga_beli; // PERSEDIAAN AKHIR
                    $awal = Mstok::where('id_produk', $produk->id)->first();
                    $pers_awal = ($awal->stok_awal + $detail) * $produk->harga_beli; //PERSEDIAAN AWAL

                    //pembelian
                    $pembeliandetail_total = pembelianSupplierDetail::where('id_barang', $produk->id)->where('tanggal', $date)->sum('sub_total'); //PEMBELIAN
                    $pembeliandetail_qty = pembelianSupplierDetail::where('id_barang', $produk->id)->where('tanggal', $date)->sum('qty'); //PEMBELIAN
                    $sumpembelian = $pembeliandetail_qty * $pembeliandetail_total;

                    if ($pembeliandetail_total == null&&$pembeliandetail_qty==null)
                    {
                        
                        $pembeliandetail_total2 = 0;
                        $pembeliandetail_qty2 = 0;
                    }
                    else
                    {
                        $pembeliandetail_total2 = $pembeliandetail_total;
                            $pembeliandetail_qty2 = $pembeliandetail_qty;
                    }


                    $akumulasi_pertama = $pers_awal + $pembeliandetail_total;
                    $akumulasi_kedua = ($awal->stok_awal + $detail) + $pembeliandetail_qty;
                    $hpp = $akumulasi_pertama / $akumulasi_kedua;
                    $hpp_asli = $hpp * $detail;

                    $hpp1 = Hpp::where('produk', $produk->nama)->where('tanggal', $date)->first();

                    if($hpp1==null)

                    {
                        Hpp::create([
                            'produk' => $produk->nama,
                            'id_produk' => $produk->id,
                            'persedian_awal' => $pers_awal,
                            'qty_persediaan' => $awal->stok_awal + $detail,
                            'pembelian' => $pembeliandetail_total2,
                            'qty_pembelian' => $pembeliandetail_qty2,
                            'hpp_unit' => $hpp,
                            'hpp_asli' => $hpp_asli,
                            'tanggal' => date('Y-m-d'),
                            'qty_penjualan' => $detail,
                            'penjualan' => $produk->harga_jual * $detail,
                            'stok_akhir' => $awal->stok_awal,
                            'cabang' => $maping->id

                        ]);

                    }
                    else{


                        $hpp1->update([

                            'produk' => $produk->nama,
                            'id_produk' => $produk->id,
                            'persedian_awal' => $pers_awal,
                            'qty_persediaan' => $awal->stok_awal + $detail,
                            'pembelian' => $pembeliandetail_total,
                            'qty_pembelian' => $pembeliandetail_qty,
                            'hpp_unit' => $hpp,
                            'hpp_asli' => $hpp_asli,
                            'tanggal' => date('Y-m-d'),
                            'qty_penjualan' => $detail,
                            'penjualan' => $produk->harga_jual * $detail,
                            'stok_akhir' => $awal->stok_awal,
                            'cabang' => $maping->id

                        ]);
                    }



//            $cekhpp = Hpp::where('id_produk', $produk->id)->where('tanggal', $date)->first();
//            $harga_beli = $cekhpp->persedian_awal / $cekhpp->qty_persediaan;


                }
                $berhasil = "berhasil";
            }
            else
            {
                $berhasil = "udahada";
            }
        }
        $data[] = array(
            'nama' => $berhasil
        );

        return json_encode($data);

        
    }
    public function ceksupervisor($username, $password)
    {
        $saveid = Auth::user()->id;

        $ff = "PP";
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            if (Auth::user()->roleid->akses != "kasir") {
                $ff = "GO";
            }
            Auth::logout();
            Auth::loginUsingId($saveid);
        }

        if ($ff=="PP")
        {
            $stat = "Fail";
        }
        else
        {
            $stat = "OK";
        }

        $data[] = array(
            'stat'    => $stat
        );

        return json_encode($data);
    }

    public function pwsupervisor()
    {
        return view('pos.pwsupervisor');
    }

    public function produk()
    {

//        $user = Auth::user()->cabang;
//        $produk = Produk::where('id_cabang','like','%'.$user.'%')->orderBy('id','desc')->paginate(8);
//

        $maping = \App\Model\Master\Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $produk2 = $maping->mappingproduk;
//jangan lupa paginate
//        $data[] = array(
//        $data[] = array(
//            'stat' => $produk
//        );
//
//
//        return json_encode($data);
        return view ('pos.dataproduk')->with('produk', $produk)->with('produk2', $produk2);

    }

    public function cariproduk($barang)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk->where('barcode', $barang)->first();
        $produk2 = $maping->mappingproduk;
        return view('pos.dataproduk')->with('produk', $produk)->with('produk2', $produk2);


    }

    public function cekproduk($id)
    {
        $produk = Produk::find($id);
        $barcode = $produk->barcode;
        $nama = $produk->nama;

        $data[] = array(
            'barcode' => $barcode,
            'nama' => $nama
        );

        return json_encode($data);

    }

    public function index()

    {
        $ceknomor = Nomor::where('modul', 'POS')->first();

         if ($ceknomor==null)
         {

              return redirect( url('pengaturan/nomor'));
         }
         else
         {
             $cbnya = Auth::user()->cabang;
             $cabangz = Cabang::find($cbnya);
             $cabangnyo = $cabangz->nama;
         $iklan = Iklan::find(1);
         $status = $iklan->status;
         $rolenya = Auth::user()->role_id;
         $sementara = Transaksisementara::where('cabang', $cbnya)->get();
         $idkasir = Auth::user()->id;
         $namakasir = Auth::user()->username;
         $noref = $this->_generatenoref();
         $total = Transaksisementara::where('cabang', $cbnya)->sum('sub_total');
         $totaltranskasi = Transaksisementara::where('cabang', $cbnya)->count('no_ref');
             $maping = $maping = Cabang::find(Auth::user()->cabang);
             $produk = $maping->mappingproduk;
        return view('pos.penjualan')->with('produk', $produk)->with('cabangnyo', $cabangnyo)->with('iklan',$iklan)->with('sementara',$sementara)->with('total', $total)->with('noref',$noref)->with('totaltranskasi', $totaltranskasi)->with('idkasir',$idkasir)->with('namakasir',$namakasir)->with('status', $status)->with('rolenya', $rolenya);

    }


    }

    public function cek(){
        $nom = Nomor::where('modul', 'POS')->first();

        if($nom == null){
            $stat = "kosong";
        } else {
            $stat = "ada";
        }

        $data[] = array(
            'stat' => $stat
        );

        return json_encode($data);


    }


    public function create()
    {

    	 $sementara = Transaksisementara::all();
         $noref = $this->_generatenoref();
        return view('pos.penjualan')->with('sementara',$sementara)->with('noref',$noref);
    }

    public function store($barcode)
    {
     $maping = Cabang::find(Auth::user()->cabang);
     $produk = $maping->mappingproduk->where('barcode', $barcode)->first();
     $norefnya = $this->_generatenoref();
     $msg = " ";
     $msgclass = "Produk tidak ditemukan";

        if ($produk==null)
        {
          return redirect(url('pos/penjualan'))
            ->with('msgclass', $msgclass)
            ->with('msg', $msg);
        }

        else
        {
            $ceksementara = Transaksisementara::where('barcode', $barcode)->where('cabang', Auth::user()->cabang)->first();
            if($ceksementara==null)
            {
                $produk = $maping->mappingproduk->where('barcode', $barcode)->first();
if($produk->disc_tipe == "nominal")
{
    $cekdiskon = $produk->disc_nominal;
    $kalkulasi = ($produk->harga_jual - $cekdiskon) - $produk->harga_beli;
    Transaksisementara::create([
        'barcode' 		=> $produk->barcode,
        'harga' 		=> $produk->harga_jual,
        'produk'	    => $produk->nama,
        'no_ref' 		=> $norefnya,
        'qty'		    => '1',
        'sub_total'     => $produk->harga_jual,
        'harga_beli'    => $produk->harga_beli,
        'untung'        => $kalkulasi,
        'diskon'        => $produk->disc_nominal,
        'konsinyasi'    => $produk->konsinyasi,
        'cabang'        => $maping->id

    ]);

}
else if($produk->disc_tipe== "percent")
{
    $cekdiskon = $produk->disc;
    $replace = str_replace(".00","",$cekdiskon);
    $kalkulasi2 = $replace/100 * $produk->harga_jual;
    $kalkulasi = $produk->harga_jual - $produk->harga_beli - $kalkulasi2;

    Transaksisementara::create([
        'barcode' 		=> $produk->barcode,
        'harga' 		=> $produk->harga_jual,
        'produk'	    => $produk->nama,
        'no_ref' 		=> $norefnya,
        'qty'		    => '1',
        'sub_total'     => $produk->harga_jual,
        'harga_beli'    => $produk->harga_beli,
        'untung'        => $kalkulasi,
        'diskon'        => $kalkulasi2,
        'konsinyasi'    => $produk->konsinyasi,
        'cabang'        => $maping->id

    ]);

}
else
{

    Transaksisementara::create([
        'barcode' 		=> $produk->barcode,
        'harga' 		=> $produk->harga_jual,
        'produk'	    => $produk->nama,
        'no_ref' 		=> $norefnya,
        'qty'		    => '1',
        'sub_total'     => $produk->harga_jual,
        'harga_beli'    => $produk->harga_beli,
        'untung'        => $produk->untung,
        'konsinyasi'    => $produk->konsinyasi,
        'diskon'        => "0",
        'cabang'        => $maping->id

    ]);
}
            }
            else{
                $ubah =  Transaksisementara::where('barcode', $barcode)->where('cabang', Auth::user()->cabang)->first();

                $maping  = Cabang::find(Auth::user()->cabang);
                $produk = $maping->mappingproduk->where('nama', $ubah->produk)->first();
                $qtyawal = $ubah->qty;
                $qtyakhir = $qtyawal + 1;
                $ubah->qty = $qtyakhir;
                $ubah->sub_total = $ubah->harga * $qtyakhir;
                $ubah->untung = $ubah->untung * $qtyakhir;
                $ubah->diskon = $ubah->diskon * $qtyakhir;
                $ubah->harga_beli = $ubah->harga_beli * $qtyakhir;
                $ubah->save();
            }



        return redirect( url('pos/penjualan'));

    }


    }



    public function void()
    {
        $cabang = Auth::user()->cabang;
       $voidapus = Transaksisementara::where('cabang', $cabang)->delete();
       return redirect( url('pos/penjualan'));
    }


    public function edit(Request $request, $barcode, $qtt)
    {
     if ($qtt=="0")
     {

     }
     else
     {
        $barcode_qty  =  $barcode;
        $ubahqty      =  Transaksisementara::where('barcode',$barcode_qty)->first();
        $editqty      =  Transaksisementara::find($ubahqty->id);


        $editqty->update([
            'sub_total' => $ubahqty->harga * $qtt,
            'untung'    => $ubahqty->untung * $qtt,
            'harga_beli' => $ubahqty->harga_beli * $qtt,
            'qty'       => $qtt

            ]);

             $data[] = array(
            'nama' => $editqty->qty
        );

        return json_encode($data);

    }
}


      public function _generatenoref() {
        $nom = Nomor::where('modul', 'POS')->first();

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
}
