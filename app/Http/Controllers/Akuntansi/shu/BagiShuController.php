<?php

namespace App\Http\Controllers\Akuntansi\shu;

use App\Model\Master\Anggota;
use App\Model\Akuntansi\TransaksiHeader;
use App\Model\Akuntansi\PengaturanSHU;
use App\Model\Akuntansi\SimpananTransaksi;
use App\Model\Simpanan\Transaksi;
use PDF;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BagiShuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Akuntansi.SHU.hitung_shu');
    }



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

        $shu = PengaturanSHU::find($id);

        $idvalidasi = $id;

        $periode = $shu->tahun;
        $tanggal = $shu->tanggal_pembagian;
        $jasa_usaha_persen = $shu->jasa_usaha;
        $jasa_modal_persen = $shu->jasa_modal;
        $jumlahshu = $shu->jumlah_shulabarugi;
        $shuanggota = $jumlahshu * $shu->shu_anggota /100;

        $jasa_usaha = $shuanggota * $jasa_usaha_persen /100;
        $jasa_modal = $shuanggota * $jasa_modal_persen /100;

        //total jasa modal
        //$total_jasamodal = Transaksi::where('tipe', 'SETOR')->where('tanggal', 'LIKE', '%'.$periode.'-%')->sum('kredit');
        $total_jasamodal = '200000';
        //total jasa usaha
        //$total_jasausaha = TransaksiHeader::where('tanggal', 'LIKE', '%'.$periode.'-%')->sum('jumlah');
        $total_jasausaha = '48000000';

        //per rupiah
        $perrupiah_jasamodal = $jasa_modal/$total_jasamodal;
        $perrupiah_jasausaha = $jasa_usaha/$total_jasausaha;

        $anggota = Anggota::all();

        $simpananwajib = 5000000;

        return view('Akuntansi.SHU.bagi_shu')->with('periode', $periode)
                                            ->with('tanggal', $tanggal)
                                            ->with('idvalidasi', $idvalidasi)
                                            ->with('jasa_usaha', $jasa_usaha)
                                            ->with('jasa_modal', $jasa_modal)
                                            ->with('total_jasamodal', $total_jasamodal)
                                            ->with('total_jasausaha', $total_jasausaha)
                                            ->with('perrupiah_jasamodal', $perrupiah_jasamodal)
                                            ->with('perrupiah_jasausaha', $perrupiah_jasausaha)
                                            ->with('simpananwajib', $simpananwajib)
                                            ->with('anggota', $anggota);
    }

    public function cetak(Request $request){
        /*$id = $request->idvalidasi;

        $shu = PengaturanSHUSimpan::find($id);

        $idvalidasi = $id;

        $periode = $shu->tahun;
        $tanggal = $shu->tanggal_pembagian;
        $jasa_usaha = $shu->jasa_usaha;
        $jasa_modal = $shu->jasa_modal;

        //total jasa modal
        $tabunganawal = TabunganTransaksi::sum('saldo_awal');
        $tabungandebet = TabunganTransaksi::sum('debet');
        $tabungankredit = TabunganTransaksi::sum('kredit');

        $total_jasamodal = $tabunganawal - $tabungandebet + $tabungankredit;

        //total jasa usaha
        $nominaljurnal = JurnalHeader::where('tanggal', 'like', '%'.$periode.'%' )->get();
        $nominal2 = "";
        foreach ($nominaljurnal as $row) {
            $nominaljurnaldetail = JurnalDetail::where('id_header', $row->id)->sum('nominal');
            $nominal2+=$nominaljurnaldetail;
        }

        $nominalPOS = TransaksiHeader::where('tanggal', 'like', '%'.$periode.'%' )->where('status', 'Payment')->where('type_pembayaran', 'Kartu')->sum('jumlah');

        $total_jasausaha = $nominal2 + $nominalPOS;

        //per rupiah

        $perrupiah_jasamodal = $jasa_modal/$total_jasamodal;
        $perrupiah_jasausaha = $jasa_usaha/$total_jasausaha;

        $anggota = Anggota::take(100)->skip(100)->get();

        $simpananwajib = 5000000;

        $pdf = PDF::loadView('Akuntansi.SHU.bagi_shu_cetak', ['perrupiah_jasamodal' => $perrupiah_jasamodal, 'perrupiah_jasausaha' => $perrupiah_jasausaha, 'periode' => $periode, 'tanggal' => $tanggal,'idvalidasi' => $idvalidasi, 'jasa_usaha' => $jasa_usaha,'jasa_modal' => $jasa_modal, 'total_jasamodal' => $total_jasamodal, 'total_jasausaha' => $total_jasausaha, 'simpananwajib' => $simpananwajib, 'anggota' => $anggota ]);
        return $pdf->stream('Bagi SHU.pdf');*/
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
