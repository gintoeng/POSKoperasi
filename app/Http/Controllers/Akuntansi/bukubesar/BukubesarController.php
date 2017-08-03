<?php

namespace App\Http\Controllers\Akuntansi\bukubesar;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Pengaturan\Profil;

use PDF;

class BukubesarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function history($id)
    {
        $jurnalterpilih = JurnalDetail::find($id);
        $jurnalsemua = JurnalDetail::where('id_header', $jurnalterpilih->id_header)->get();

        foreach ($jurnalsemua as $row) {
            echo '<tr>';
            echo '<td>'.$row->perkiraan['kode_akun'].'</td>';
            echo '<td>'.$row->perkiraan['nama_akun'].'</td>';
            echo '<td>'.$row->keterangan.'</td>';
            echo '<td class="text-right">Rp. '.number_format($row->debet, "2").'</td>';
            echo '<td class="text-right">Rp. '.number_format($row->kredit, "2").'</td>';
            echo '</tr>';
        }
    }

    public function history2($id)
    {
        $jurnalterpilih = JurnalDetail::find($id);
        $jurnalsemua = JurnalDetail::where('id_header', $jurnalterpilih->id_header)->get();

        $data[] = array(
            'notrans' => $jurnalterpilih->header->kode_jurnal,
            'ket' => $jurnalterpilih->header->keterangan,
            'tgl' => substr($jurnalterpilih->header->tanggal, 0,10)
        );

        return json_encode($data);

    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');

        $cekindexawal = "awal";

        $nama = "";
        $kode_perkiraan = "";

        $JurnalDetailCount = "0";

        $akun = Perkiraan::where('tipe_akun', 'detail')->get();

        return view('Akuntansi.bukubesar.bukubesar_index')->with('date1', $date1)
                                                          ->with('date2', $date2)
                                                          ->with('nama', $nama)
                                                          ->with('kode_perkiraan', $kode_perkiraan)
                                                          ->with('akun', $akun)
                                                          ->with('JurnalDetailCount', $JurnalDetailCount)
                                                          ->with('cekindexawal', $cekindexawal);
    }

    public function getnama($id)
    {
        $akun = Perkiraan::find($id);

        echo '<input type="text" name="nama_akun" class="form-control" placeholder="Nama" value="'.$akun->nama_akun.'">';
    }

    public function search(Request $request)
    {
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $cekindexawal = "cari";

        $date1 = $request->input('datefrom');
        $date2 = $request->input('dateto');
        $kode_perkiraan = $request->input('kode_perkiraan');

        if($kode_perkiraan=="all"){
            $JurnalDetail = JurnalDetail::where('created_at', '>=', $date1." 00:00:00")->where('created_at', '<=', $date2." 23:59:00")->where('posting', '1')->orderBy('id', 'DESC')->paginate(10);
            $JurnalDetailCount = JurnalDetail::where('created_at', '>=', $date1." 00:00:00")->where('created_at', '<=', $date2." 23:59:00")->where('posting', '1')->orderBy('id', 'DESC')->count();
        } else {
            $JurnalDetail = JurnalDetail::where('id_akun', $kode_perkiraan)->where('created_at', '>=', $date1." 00:00:00")->where('created_at', '<=', $date2." 23:59:00")->where('posting', '1')->orderBy('id', 'DESC')->paginate(10);
            $JurnalDetailCount = JurnalDetail::where('id_akun', $kode_perkiraan)->where('created_at', '>=', $date1." 00:00:00")->where('created_at', '<=', $date2." 23:59:00")->where('posting', '1')->orderBy('id', 'DESC')->count();
        }



        return view('Akuntansi.bukubesar.bukubesar_index')->with('akun', $akun)
                                                          ->with('kode_perkiraan', $kode_perkiraan)
                                                          ->with('cekindexawal', $cekindexawal)
                                                          ->with('date1', $date1)
                                                          ->with('date2', $date2)
                                                          ->with('JurnalDetailCount', $JurnalDetailCount)
                                                          ->with('JurnalDetail', $JurnalDetail);
    }

    public function cetak(Request $request)
    {
        $profil = Profil::findOrNew('1');
        $i = 1;
        $date1 = $request->input('datefrom');
        $date2 = $request->input('dateto');
        $kode_perkiraan = $request->input('kode_perkiraan');
        if($kode_perkiraan=="all"){
            $JurnalDetail = JurnalDetail::where('posting', '1')->where('created_at', '>=', $request->datefrom." 00:00:00")->where('created_at', '<=', $request->dateto." 23:59:00")->orderBy('id', 'DESC')->get();
        } else {
            $JurnalDetail = JurnalDetail::where('posting', '1')->where('id_akun', $request->kode_perkiraan)->where('created_at', '>=', $request->datefrom." 00:00:00")->where('created_at', '<=', $request->dateto." 23:59:00")->orderBy('id', 'DESC')->get();
        }
        $akun_perkiraan = Perkiraan::find($request->kode_perkiraan);
        $pdf = PDF::loadView('Akuntansi.bukubesar.bukubesar_cetak', ['id_akun' => $request->kode_perkiraan,'profil' => $profil, 'JurnalDetail' => $JurnalDetail, 'akun_perkiraan' => $akun_perkiraan]);
        $customPaper = array(0,0,950,950);
        return $pdf->setPaper($customPaper, 'landscape')->stream('Cetak-Jurnal.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

}
