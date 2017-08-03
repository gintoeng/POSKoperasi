<?php

namespace App\Http\Controllers\Pos;

use App\Model\Master\Cabang;
use App\Model\Pos\Mstok;
use Illuminate\Http\Request;


use View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pos\Transaksisementara;
use App\Model\Pos\Produk;
use App\Model\Pos\Transaksiheader;
use App\Model\Pos\Transaksidetail;
use App\Model\Pengaturan\Profil;
use App\Model\Pengaturan\Nomor;
use App\Model\Master\Anggota;
use App\Model\Master\Mappingbarang;
use App\Model\Inventory\LapBarangKeluar;
use Illuminate\Support\Facades\Auth;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Akumulasi;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\pengaturanAkuns;
use App\Model\Akuntansi\pengaturanAkunRelasi;

class CashController extends Controller
{
  public function destro($id)
  {

      Transaksiheader::destroy($id);
      return redirect( url('pos/penjualan/hold'));

  }

  public function indexhold()
  {

    $hold      = "Hold";
    $indexhold = Transaksiheader::where('status', $hold)->orderBy('tanggal', 'asc')->paginate(6);
    return view('pos.hold')->with('hold', $hold)->with('indexhold', $indexhold);
  }

    public  function cektunda($kartu)
    {
        $anggota = Anggota::where('npk', $kartu)->first();

        if ($anggota == null)
        {
            $stat = "Fail";
            $id = "fail";
            $kartu = "faiil";
        }else{
            $stat = "OK";
            $anggota = Anggota::where('npk', $kartu)->first();
            $id = $anggota->id;

        }
        $data[] = array(
            'stat' => $stat,
            'kartu' => $kartu,
            'id' => $id
        );

        return json_encode($data);

    }
  public function tunda($kartu, $norefnya)
  {

   $i = 1;
   $idkasir       = Auth::user()->id;
   $cabangnya     = Auth::user()->cabang;
   $noref         = $norefnya;
   $total         = Transaksisementara::where('cabang', $cabangnya)->sum('sub_total');
   $no            = $i++;
   $tanggal       = date('Y-m-d');
   $sementara     = Transaksisementara::where('no_ref',$noref)->where('cabang', $cabangnya)->get();
   $totalhargabeli = 0;

    foreach ($sementara as $tunda) {

        $maping = Cabang::find(Auth::user()->cabang);
        $produkterpilih = $maping->mappingproduk->where('barcode', $tunda->barcode)->first();
        $mstok = Mstok::where('id_produk', $produkterpilih->id)->where('cabang', Auth::user()->cabang)->first();
        $totalhargabeli+=$produkterpilih->harga_beli;

       $kode_produk = $tunda->barcode;
       $harga       = $tunda->harga;
       $produk      = $tunda->produk;
       $qty         = $tunda->qty;
       $sub_total   = $tunda->sub_total;
       $no_ref      = $tunda->no_ref;
       $untung      = $tunda->untung;
       $harga_beli  = $tunda->harga_beli;
       $konsinyasi  = $tunda->konsinyasi;
       $diskon      = $tunda->diskon;



       Transaksidetail::create([
      'barcode'       => $kode_produk,
      'kasir'         => $idkasir,
      'harga'         => $harga,
      'produk'        => $produk,
      'no_ref'        => $no_ref,
      'qty'           => $qty,
      'tanggal'       => $tanggal,
      'sub_total'     => $sub_total,
      'cabang'        => $cabangnya,
      'untung'        => $untung,
      'konsinyasi'    => $konsinyasi,
      'diskon'        => $diskon,
      'harga_beli'    => $harga_beli

          ]);

        LapBarangKeluar::create([
            'barcode'         => $kode_produk,
            'nama'            => $produk,
            'tanggal'         => $tanggal,
            'harga_beli'      => $harga_beli,
            'qty'             => $qty,
            'sub_total'       => $sub_total,
            'expired'         => $mstok->tanggal_expired,
            'jenis_pembayaran' => 'tunda',
            'id_cabang'       => $cabangnya

        ]);



         $produk_sementara = Transaksisementara::where('barcode',$kode_produk)->where('cabang', $cabangnya)->get();
         foreach ($produk_sementara as $row) {

             $barcode_produk = $row->barcode;
             $maping         = Cabang::find(Auth::user()->cabang);
             $edit1          = $maping->mappingproduk->where('barcode', $barcode_produk)->first();
             $editqty        = Mappingbarang::where('id_produk', $edit1->id)->where('id_cabang', $maping->id)->first();
             $editqty2       = Mstok::where('id_produk', $edit1->id)->where('produk', $edit1->nama)->orderby('tanggal_expired','asc')->first();
             $qtyasal        = $editqty->stok;
             $qtyasal2       = $editqty2->stok_awal;
             $qtysisa        = $qtyasal - $qty;
             $qtysisa2       = $qtyasal2 - $qty;

             $editqty->update([

                 'stok' => $qtysisa

             ]);

             $editqty2->update([

                 'stok_awal' => $qtysisa2

             ]);
     }


   }

   ///masuk ke jurnal
   $pemasukan = pengaturanAkuns::where('caption', 'Pemasukan')->first();
   $pengeluaran = pengaturanAkuns::where('caption', 'Pengeluaran')->first();

   $idakunpemasukan = pengaturanAkunRelasi::where('id_detail', $pemasukan->id)->first();
   $idakunpengeluaran = pengaturanAkunRelasi::where('id_detail', $pengeluaran->id)->first();

   $akunpemasukan = Perkiraan::find($idakunpemasukan->id_akun);
   $akunpengeluaran = Perkiraan::find($idakunpengeluaran->id_akun);

      date_default_timezone_set('Asia/Jakarta');
      $header = JurnalHeader::create([
          'tipe' => "WASERDA",
          'kode_jurnal' => $this->_generatepos(),
          'tanggal' => date('Y-m-d H:i:s'),
          'keterangan' => 'Transaksi POS'
      ]);
      $cabang = Cabang::find(Auth::user()->cabang);

      $detail = JurnalDetail::create([
          'id_header' => $header->id,
          'id_akun' => $cabang->akun_piutang_wsd,
          'debet' => $total,
          'kredit' => "",
          'nominal' => $total
      ]);

      $detail2 = JurnalDetail::create([
          'id_header' => $header->id,
          'id_akun' => $cabang->akun_penjualan_wsd,
          'debet' => "",
          'kredit' => $total,
          'nominal' => $total
      ]);
//   $jurnal = new JurnalHeader;
//   $jurnal->kode_jurnal = $this->_generatepos();
//   $jurnal->tanggal = $tanggal;
//   $jurnal->keterangan = "Transaksi POS";
//   $jurnal->status = 'AKTIF';
//   $jurnal->tipe = 'TRANSAKSI';
//   $jurnal->save();
//
//   $JurnalDetailMasuk = new JurnalDetail;
//   $JurnalDetailMasuk->id_header = $jurnal->id;
//   $JurnalDetailMasuk->id_transaksi = '';
//   $JurnalDetailMasuk->id_akun = $idakunpemasukan->id_akun;
//   $JurnalDetailMasuk->debet = '0';
//   $JurnalDetailMasuk->kredit = $total;
//   $JurnalDetailMasuk->nominal = $total;
//   $JurnalDetailMasuk->save();
//
//   $JurnalDetailKeluar = new JurnalDetail;
//   $JurnalDetailKeluar->id_header = $jurnal->id;
//   $JurnalDetailKeluar->id_transaksi = '';
//   $JurnalDetailKeluar->id_akun = $idakunpengeluaran->id_akun;
//   $JurnalDetailKeluar->debet = $totalhargabeli;
//   $JurnalDetailKeluar->kredit = '0';
//   $JurnalDetailKeluar->nominal = $totalhargabeli;
//   $JurnalDetailKeluar->save();

   $nom = Nomor::where('modul', 'Jurnal Transaksi POS')->first();
   $format = Nomor::find($nom->id);
   $format->update(['nomor_now' => $nom->nomor_now + 1]);
   $diskonnya = Transaksisementara::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->sum('diskon');
   ///////

     Transaksiheader::create([
      'noref'              => $noref,
      'jumlah'             => $total,
      'tanggal'            => $tanggal,
      'type_pembayaran'    => 'tunda',
      'kasir'              => $idkasir,
      'kategori'           => 'belum dibayar',
      'status'             => 'Tunda',
      'no_kartu'           => $kartu,
      'diskon'             => $diskonnya,
      'cabang'             => $cabangnya

          ]);
      $trs_header = Transaksiheader::where('noref', $noref)->where('cabang', Auth::user()->cabang)->first();
      if($trs_header->diskon == 0)
      {
          $trs_header->update([
              'jumlah' => $total
          ]);

      }
      else
      {
          $trs_header->update([
              'jumlah' => $total - $diskonnya
          ]);
      }


      $maping          = Cabang::find(Auth::user()->cabang);
    $apus = Transaksisementara::where('cabang', $maping->id)->delete();

    $nom = Nomor::where('modul', 'POS')->first();
    $format = Nomor::find($nom->id);
    $format->update(['nomor_now' => $nom->nomor_now + 1]);



      $data[] = array(
      'kartu'       => $kartu,
      'noref'       => $noref,
      'total'       => $total
    );
    return json_encode($data);

  }


    public function hold($norefnya)
    {
      $noref = $this->_generatenoref();
      $ceksementara = Transaksisementara::where('no_ref', $noref)->first();


      if ($ceksementara==null) {

        $hold      = "Hold";
        $indexhold = Transaksiheader::where('status', $hold)->orderBy('tanggal', 'asc')->get();
        return redirect(url('pos/penjualan/hold'))
            ->with('indexhold', $indexhold)
            ->with('hold', $hold);

      }

      else
      {

     $i = 1;
     $idkasir       = Auth::user()->id;
     $cabangnya     = Auth::user()->cabang;
     $noref         = $this->_generatenoref();
     $total         = Transaksisementara::all()->sum('sub_total');
     $no            = $i++;
     $tanggal       = date('Y-m-d');
     $sementara     = Transaksisementara::where('no_ref',$noref)->get();

      foreach ($sementara as $hold) {
         $kode_produk = $hold->barcode;
         $harga       = $hold->harga;
         $produk      = $hold->produk;
         $qty         = $hold->qty;
         $sub_total   = $hold->sub_total;
         $no_ref      = $hold->no_ref;
         $untung      = $hold->untung;
         $harga_beli  = $hold->harga_beli;



         Transaksidetail::create([
        'barcode'       => $kode_produk,
        'kasir'         => $idkasir,
        'harga'         => $harga,
        'produk'        => $produk,
        'no_ref'        => $no_ref,
        'qty'           => $qty,
        'tanggal'       => $tanggal,
        'sub_total'     => $sub_total,
        'cabang'        => $cabangnya,
        'untung'        => $untung,
        'harga_beli'    => $harga_beli

            ]);
     }

       Transaksiheader::create([
        'noref'             => $noref,
        'jumlah'             => $total,
        'tanggal'            => $tanggal,
        'type_pembayaran'    => 'hold',
        'kasir'              => $idkasir,
        'kategori'           => 'belum dibayar',
        'status'             => 'Hold',
        'no_kartu'           => '000',
        'cabang'             => $cabangnya

            ]);



        $apus = Transaksisementara::all();
       foreach ($apus as $apuss)
       {
        Transaksisementara::destroy($apuss->id);
       }


    }

    $nom = Nomor::where('modul', 'POS')->first();
    $format = Nomor::find($nom->id);
    $format->update(['nomor_now' => $nom->nomor_now + 1]);


      return redirect( url('pos/penjualan'));

    }





    public function cash($total, $eds, $norefnya)
    {
      $i = 1;

     $idkasir       = Auth::user()->id;
     $noref         = $norefnya;
     $cabangnya     = Auth::user()->cabang;
     $total         = Transaksisementara::where('cabang', $cabangnya)->sum('sub_total');
     $no            = $i++;
     $tanggal       = date('Y-m-d');
     $sementara     = Transaksisementara::where('no_ref',$noref)->get();
     //replace currency
     $pembayaran    = $eds;
     $pembayarann   = str_replace(",","",$pembayaran);
     $pembayarann   = str_replace(".00","",$pembayarann);

     $totalhargabeli = 0;

     if ($pembayarann < $total)
     {
      $stat = "Fail";
      $kembali = "Tidak Ada";
      $pembayarann = "Tidak Ada";
      $noref = "Tidak Ada";
     }
     else
     {
         $stat = "OK";

         foreach ($sementara as $cash) {

            $maping          = Cabang::find(Auth::user()->cabang);
            $produkterpilih  = $maping->mappingproduk->where('barcode', $cash->barcode)->first();
            $mstok = Mstok::where('id_produk', $produkterpilih->id)->where('cabang', Auth::user()->cabang)->first();
            $totalhargabeli+=$produkterpilih->harga_beli;

         $kode_produk = $cash->barcode;
         $harga       = $cash->harga;
         $produk      = $cash->produk;
         $qty         = $cash->qty;
         $sub_total   = $cash->sub_total;
         $no_ref      = $cash->no_ref;
         $untung      = $cash->untung;
         $harga_beli  = $cash->harga_beli;
         $konsinyasi  = $cash->konsinyasi;
         $diskon      = $cash->diskon;



         Transaksidetail::create([
        'barcode'       => $kode_produk,
        'kasir'         => $idkasir,
        'harga'         => $harga,
        'produk'        => $produk,
        'no_ref'        => $no_ref,
        'qty'           => $qty,
        'tanggal'       => $tanggal,
        'sub_total'     => $sub_total,
        'cabang'        => $cabangnya,
        'harga_beli'    => $harga_beli,
        'konsinyasi'    => $konsinyasi,
        'untung'        => $untung,
        'diskon'        => $diskon,
        'bayarstat'     => 1

            ]);

         LapBarangKeluar::create([
        'barcode'         => $kode_produk,
        'nama'            => $produk,
        'tanggal'         => $tanggal,
        'harga_beli'      => $harga_beli,
        'qty'             => $qty,
        'expired'         => $mstok->tanggal_expired,
        'sub_total'       => $sub_total,
        'jenis_pembayaran' => 'cash',
        'id_cabang'       => $cabangnya

            ]);



                $produk_sementara = Transaksisementara::where('barcode',$kode_produk)->where('cabang', $cabangnya)->get();
                foreach ($produk_sementara as $row) {

           $barcode_produk = $row->barcode;
           $maping         = Cabang::find(Auth::user()->cabang);
           $edit1          = $maping->mappingproduk->where('barcode', $barcode_produk)->first();
           $editqty        = Mappingbarang::where('id_produk', $edit1->id)->where('id_cabang', $maping->id)->first();
           $editqty2       = Mstok::where('id_produk', $edit1->id)->where('produk', $edit1->nama)->orderby('tanggal_expired','asc')->first();
           $qtyasal        = $editqty->stok;
           $qtyasal2        = $editqty2->stok_awal;
           $qtysisa        = $qtyasal - $qty;
           $qtysisa2        = $qtyasal2 - $qty;

                    $editqty->update([

            'stok' => $qtysisa

            ]);

                    $editqty2->update([

                        'stok_awal' => $qtysisa2

                    ]);
       }
     }

         ///masuk ke jurnal
         $pemasukan = pengaturanAkuns::where('caption', 'Pemasukan')->first();
         $pengeluaran = pengaturanAkuns::where('caption', 'Pengeluaran')->first();

         $idakunpemasukan = pengaturanAkunRelasi::where('id_detail', $pemasukan->id)->first();
         $idakunpengeluaran = pengaturanAkunRelasi::where('id_detail', $pengeluaran->id)->first();

         $akunpemasukan = Perkiraan::find($idakunpemasukan->id_akun);
         $akunpengeluaran = Perkiraan::find($idakunpengeluaran->id_akun);

         date_default_timezone_set('Asia/Jakarta');
         $header = JurnalHeader::create([
             'tipe' => "WASERDA",
             'kode_jurnal' => $this->_generatepos(),
             'tanggal' => date('Y-m-d H:i:s'),
             'keterangan' => 'Transaksi POS'
         ]);
         $cabang = Cabang::find(Auth::user()->cabang);

         $detail = JurnalDetail::create([
             'id_header' => $header->id,
             'id_akun' => $cabang->akun_kas,
             'debet' => $total,
             'kredit' => "",
             'nominal' => $total
         ]);

         $detail2 = JurnalDetail::create([
             'id_header' => $header->id,
             'id_akun' => $cabang->akun_penjualan_wsd,
             'debet' => "",
             'kredit' => $total,
             'nominal' => $total
         ]);

//         $jurnal = new JurnalHeader;
//         $jurnal->kode_jurnal = $this->_generatepos();
//         $jurnal->tanggal = $tanggal;
//         $jurnal->keterangan = "Transaksi POS";
//         $jurnal->status = 'AKTIF';
//         $jurnal->tipe = 'TRANSAKSI';
//         $jurnal->save();
//
//         $JurnalDetailMasuk = new JurnalDetail;
//         $JurnalDetailMasuk->id_header = $jurnal->id;
//         $JurnalDetailMasuk->id_transaksi = '';
//         $JurnalDetailMasuk->id_akun = $idakunpemasukan->id_akun;
//         $JurnalDetailMasuk->debet = '0';
//         $JurnalDetailMasuk->kredit = $total;
//         $JurnalDetailMasuk->nominal = $total;
//         $JurnalDetailMasuk->save();
//
//         $JurnalDetailKeluar = new JurnalDetail;
//         $JurnalDetailKeluar->id_header = $jurnal->id;
//         $JurnalDetailKeluar->id_transaksi = '';
//         $JurnalDetailKeluar->id_akun = $idakunpengeluaran->id_akun;
//         $JurnalDetailKeluar->debet = $totalhargabeli;
//         $JurnalDetailKeluar->kredit = '0';
//         $JurnalDetailKeluar->nominal = $totalhargabeli;
//         $JurnalDetailKeluar->save();

         $nom = Nomor::where('modul', 'Jurnal Transaksi POS')->first();
         $format = Nomor::find($nom->id);
         $format->update(['nomor_now' => $nom->nomor_now + 1]);

         $diskonnya = Transaksisementara::where('no_ref', $noref)->where('cabang', Auth::user()->cabang)->sum('diskon');
         ///////

         Transaksiheader::create([
             'noref'              => $noref,
             'jumlah'             => $total,
             'tanggal'            => $tanggal,
             'type_pembayaran'    => 'cash',
             'kasir'              => $idkasir,
             'kategori'           => 'cash',
             'status'             => 'Cash',
             'no_kartu'           => '0',
             'diskon'             => $diskonnya,
             'cabang'             => $cabangnya

         ]);

         $trs_header = Transaksiheader::where('noref', $noref)->where('cabang', Auth::user()->cabang)->first();
         if($trs_header->diskon == 0)
         {
             $trs_header->update([
                 'jumlah' => $total
             ]);

         }
         else
         {
             $trs_header->update([
                 'jumlah' => $total - $diskonnya
             ]);
         }

            $maping     = Cabang::find(Auth::user()->cabang);
            $total      = Transaksisementara::where('cabang', $maping->id)->sum('sub_total');
            $kembali    = $pembayarann - $total;

       $apus = Transaksisementara::where('cabang', $cabangnya)->get();
       foreach ($apus as $apuss)
       {
        Transaksisementara::destroy($apuss->id);
       }

    }

    $nom = Nomor::where('modul', 'POS')->first();
    $format = Nomor::find($nom->id);
    $format->update(['nomor_now' => $nom->nomor_now + 1]);



    $data[] = array(
      'total'       => $pembayarann,
      'noref'       => $noref,
      'stat'       => $stat,
      'uangkembali' => $kembali
    );
    return json_encode($data);

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

      public function ceksaldo($kartu, $pin, $norefnya)
    {

        $getsaldo     = Anggota::where('account_card', $kartu)->where('pin', $pin)->first();
        if($getsaldo == null)
        {
            $stat = "Fail";
            $norefnya = "null";
            $kartu = "nill";
            $saldo="null";

        }else{
            $stat = "ok";
            $kartu = $getsaldo->account_card;
            $saldo = 0;
            foreach ($getsaldo->simpananid as $simp) {
             $saldo+=$simp->akumulasiid->saldo;
            }
        }


          $data[] = array(
              'stat'         => $stat,
              'saldo'         => $saldo,
              'norefnya'      => $norefnya,
              'kartu'         => $kartu
          );
          return json_encode($data);



      }


    public function autodebet($kartu, $norefnya)
    {
     $i = 1;
     $cabangnya     = Auth::user()->cabang;
     $idkasir       = Auth::user()->id;
     $noref         = $norefnya;
     $total         = Transaksisementara::all()->sum('sub_total');
     $no            = $i++;
     $tanggal       = date('Y-m-d');
     $sementara     = Transaksisementara::where('no_ref',$noref)->get();

//     $pembayaran    = $saldo;
//     $pembayarann   = str_replace(",","",$pembayaran);
//     $pembayarann   = str_replace(".00","",$pembayarann);

        $totalhargabeli = 0;


         foreach ($sementara as $autodebett) {

             $produkterpilih = Produk::where('barcode', $autodebett->barcode)->first();
             $totalhargabeli+=$produkterpilih->harga_beli;

         $kode_produk = $autodebett->barcode;
         $harga       = $autodebett->harga;
         $produk      = $autodebett->produk;
         $qty         = $autodebett->qty;
         $sub_total   = $autodebett->sub_total;
         $no_ref      = $autodebett->no_ref;
         $untung      = $autodebett->untung;
         $harga_beli  = $autodebett->harga_beli;



         Transaksidetail::create([
        'barcode'       => $kode_produk,
        'kasir'         => $idkasir,
        'harga'         => $harga,
        'produk'        => $produk,
        'no_ref'        => $no_ref,
        'qty'           => $qty,
        'tanggal'       => $tanggal,
        'sub_total'     => $sub_total,
        'cabang'        => $cabangnya,
        'untung'        => $untung,
        'harga_beli'    => $harga_beli

         ]);

            LapBarangKeluar::create([
           'barcode'        => $kode_produk,
           'nama'           => $produk,
           'jumlah'         => $qty,
           'tanggal'        => $tanggal,
           'id_koperasi'    => '1',
           'kasir'          => $idkasir,
           'sub_harga'      => $sub_total,
           'cabang'        => $cabangnya

               ]);

           $produk_sementara = Transaksisementara::where('barcode',$kode_produk)->get();
           foreach ($produk_sementara as $row) {

           $barcode_produk = $row->barcode;
           $editqty        = Produk::where('barcode', $barcode_produk)->first();
           $qtyasal        = $editqty->stok;
           $qtysisa        = $qtyasal - $qty;

           $editqty->update([

            'stok' => $qtysisa

            ]);
       }
     }

     ///masuk ke jurnal
     $pemasukan = pengaturanAkuns::where('caption', 'Pemasukan')->first();
     $pengeluaran = pengaturanAkuns::where('caption', 'Pengeluaran')->first();

     $idakunpemasukan = pengaturanAkunRelasi::where('id_detail', $pemasukan->id)->first();
     $idakunpengeluaran = pengaturanAkunRelasi::where('id_detail', $pengeluaran->id)->first();

     $akunpemasukan = Perkiraan::find($idakunpemasukan->id_akun);
     $akunpengeluaran = Perkiraan::find($idakunpengeluaran->id_akun);

     $jurnal = new JurnalHeader;
     $jurnal->kode_jurnal = $this->_generatepos();
     $jurnal->tanggal = $tanggal;
     $jurnal->keterangan = "Transaksi POS";
     $jurnal->status = 'AKTIF';
     $jurnal->tipe = 'TRANSAKSI';
     $jurnal->save();

     $JurnalDetailMasuk = new JurnalDetail;
     $JurnalDetailMasuk->id_header = $jurnal->id;
     $JurnalDetailMasuk->id_transaksi = '';
     $JurnalDetailMasuk->id_akun = $idakunpemasukan->id_akun;
     $JurnalDetailMasuk->debet = '0';
     $JurnalDetailMasuk->kredit = $total;
     $JurnalDetailMasuk->nominal = $total;
     $JurnalDetailMasuk->save();

     $JurnalDetailKeluar = new JurnalDetail;
     $JurnalDetailKeluar->id_header = $jurnal->id;
     $JurnalDetailKeluar->id_transaksi = '';
     $JurnalDetailKeluar->id_akun = $idakunpengeluaran->id_akun;
     $JurnalDetailKeluar->debet = $totalhargabeli;
     $JurnalDetailKeluar->kredit = '0';
     $JurnalDetailKeluar->nominal = $totalhargabeli;
     $JurnalDetailKeluar->save();

     $nom = Nomor::where('modul', 'Jurnal Transaksi POS')->first();
     $format = Nomor::find($nom->id);
     $format->update(['nomor_now' => $nom->nomor_now + 1]);

     ///////

        Transaksiheader::create([
        'noref'             =>   $noref,
        'jumlah'             =>  $total,
        'tanggal'            =>  $tanggal,
        'type_pembayaran'    =>  'kartu',
        'kasir'              =>  $idkasir,
        'kategori'           =>  'kartu',
        'status'             =>  'Autodebet',
        'no_kartu'           =>  $kartu,
        'cabang'             =>  $cabangnya

            ]);


           $total      = Transaksisementara::all()->sum('sub_total');

          //Ganti Saldo Kartu
         $saldo = 0;
         $getsaldo = Anggota::where('account_card', $kartu)->first();
         $getidanggota = $getsaldo->id;
         $getsimpanan = Simpanan::where('anggota', $getidanggota)->orderBy('id', 'desc')->first();
         $saldonya  = $getsimpanan->akumulasiid->saldo;
         $saldosisa = $saldonya - $total;


        $akumulasi = Akumulasi::where('id_simpanan', $getsimpanan->id)->first();
        $findakumulasi = Akumulasi::find($akumulasi->id);

        $findakumulasi->update([

            'saldo' => $saldosisa
        ]);

        $getupdatesaldo = Anggota::where('account_card', $kartu)->first();
        $saldoawal = 0;

        foreach ($getupdatesaldo->simpananid as $simp) {
            $saldoawal += $simp->akumulasiid->saldo;

        }


       $apus = Transaksisementara::all();
       foreach ($apus as $apuss)
       {
        Transaksisementara::destroy($apuss->id);
       }

       $nom = Nomor::where('modul', 'POS')->first();
       $format = Nomor::find($nom->id);
       $format->update(['nomor_now' => $nom->nomor_now + 1]);


      $data[] = array(
        'sisasaldo' => $saldosisa,
        'kartu'     => $kartu,
        'norefnya'  => $norefnya,
        'saldoawal' => $saldoawal,
        'total'     => $total

      );
      return json_encode($data);

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
