<?php

namespace App\Http\Controllers\Akuntansi\daftarkas;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Kas;
use App\Model\Pengaturan\Nomor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use narutimateum\Toastr\Facades\Toastr;

class KasTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function ceknomor()
     {
         $nom = Nomor::where('modul', 'Kas Transfer')->first();

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

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('m/d/Y');

        $kode = $this->_generate();

        $Perkiraan = Perkiraan::where('tipe_akun', 'detail')->get();

        return view('Akuntansi.daftarkas.kastransfer')->with('date', $date)
                                                        ->with('kode', $kode)
                                                        ->with('perkiraan', $Perkiraan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {

        $msg = "Berhasil! <br> Anda berhasil menambahkan data Kas Transfer";
        $alert = Toastr::success($msg, $title = "Tambah Kas Transfer", $options = []);


        $kaskeluar = new Kas;
        $kaskeluar->id_akun = $r->dariakun;
        $kaskeluar->keterangan = $r->keterangan;
        $kaskeluar->tanggal = date("Y-m-d", strtotime($r->tanggal));
        $kaskeluar->jumlah = str_replace(',', '', $r->jumlah);
        $kaskeluar->tipe = "Transfer";
        $kaskeluar->save();

        $jurnal = new JurnalHeader;
        $jurnal->kode_jurnal = $r->kode;
        $jurnal->tanggal = date("Y-m-d", strtotime($r->tanggal));
        $jurnal->keterangan = $r->keterangan;
        $jurnal->status = 'AKTIF';
        $jurnal->tipe = 'KAS';
        $jurnal->save();

        $JurnalDetailMasuk = new JurnalDetail;
        $JurnalDetailMasuk->id_header = $jurnal->id;
        $JurnalDetailMasuk->id_transaksi = '';
        $JurnalDetailMasuk->id_akun = $r->keakun;
        $JurnalDetailMasuk->debet = '0';
        $JurnalDetailMasuk->kredit = str_replace(',', '', $r->jumlah);
        $JurnalDetailMasuk->nominal = str_replace(',', '', $r->jumlah);
        $JurnalDetailMasuk->save();

        $JurnalDetailKeluar = new JurnalDetail;
        $JurnalDetailKeluar->id_header = $jurnal->id;
        $JurnalDetailKeluar->id_transaksi = '';
        $JurnalDetailKeluar->id_akun = $r->dariakun;
        $JurnalDetailKeluar->debet = str_replace(',', '', $r->jumlah);
        $JurnalDetailKeluar->kredit = '0';
        $JurnalDetailKeluar->nominal = str_replace(',', '', $r->jumlah);
        $JurnalDetailKeluar->save();

        $nom = Nomor::where('modul', 'Kas Transfer')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);
        return redirect(url('akuntansi/kastransfer'))
            ->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function _generate() {
        $nom = Nomor::where('modul', 'Kas Transfer')->first();

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

    public function formatnya($kode, $digit, $frmt) {
        date_default_timezone_set('Asia/Jakarta');
        if ($frmt == "kode") {
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
