<?php

namespace App\Http\Controllers\Akuntansi\saldoawal;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Nomor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use narutimateum\Toastr\Facades\Toastr;

class SaldoAwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function ceknomor()
     {
         $nom = Nomor::where('modul', 'Saldo Awal Akuntansi')->first();

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
        $activa = Perkiraan::where('tipe_akun', 'detail')->where('kelompok', '1')->get();
        $kewajiban = Perkiraan::where('tipe_akun', 'detail')->where('kelompok', '3')->get();

        $kode = $this->_generate();

        $akun = Perkiraan::where('tipe_akun', 'header')->where('parent','0')->get();

        return view('Akuntansi.saldoawal.saldoawal')->with('activa', $activa)
                                                    ->with('kewajiban', $kewajiban)
                                                    ->with('akun', $akun)
                                                    ->with('kode', $kode);
    }

    public function getperkiraanpertama($id)
    {
        $Perkiraan = Perkiraan::where('tipe_akun', 'detail')->where('kelompok', $id)->get();
        return view('Akuntansi.saldoawal.pertama')->with('perkiraan', $Perkiraan);
    }

    public function getperkiraankedua($id)
    {
        $Perkiraan = Perkiraan::where('tipe_akun', 'detail')->where('kelompok', $id)->get();
        return view('Akuntansi.saldoawal.kedua')->with('perkiraan', $Perkiraan);
    }

    public function search(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = "Berhasil! <br> Anda berhasil menambahkan data Saldo Awal Akuntansi";
        $alert = Toastr::success($msg, $title = "Tambah Saldo Awal Akuntansi", $options = []);



        $header = new JurnalHeader;

        $header->tipe = 'MANUAL';
        $header->kode_jurnal = $request->kode;
        $header->tanggal = date('Y-m-d');
        $header->keterangan = 'Saldo awal akuntansi';
        $header->save();
        $idheader = $header->id;

            for ($i=0; $i < count($request['kode_akun_activa']); $i++) {
                if($request['jumlahactiva'][$i]!=0){
                    $detail = new JurnalDetail;
                    $detail->id_header = $idheader;
                    $detail->id_akun = $request['kode_akun_activa'][$i];
                    $detail->debet = str_replace(',', '', $request['jumlahactiva'][$i]);
                    $detail->kredit = '';
                    $detail->nominal = str_replace(',', '', $request['jumlahactiva'][$i]);
                    $detail->save();
                }
            }

            for ($i=0; $i < count($request['kode_akun_kewajiban']); $i++) {
                if($request['jumlahkewajiban'][$i]!=0){
                    $detail = new JurnalDetail;
                    $detail->id_header = $idheader;
                    $detail->id_akun = $request['kode_akun_kewajiban'][$i];
                    $detail->debet = '';
                    $detail->kredit = str_replace(',', '', $request['jumlahkewajiban'][$i]);
                    $detail->nominal = str_replace(',', '', $request['jumlahkewajiban'][$i]);
                    $detail->save();
                }
            }

        $nom = Nomor::where('modul', 'Saldo Awal Akuntansi')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('akuntansi/saldoawal'))
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
        $nom = Nomor::where('modul', 'Saldo Awal Akuntansi')->first();

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
