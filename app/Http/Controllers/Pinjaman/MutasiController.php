<?php

namespace App\Http\Controllers\Pinjaman;

use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pinjaman;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pinjaman = Pinjaman::where('status_realisasi', 'Y')->get();
        return view('pinjaman.mutasi_pinjaman')->with('pinjaman', $pinjaman);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax($idp) {
        $pinjaman = Pinjaman::find($idp);

        $data[] = array(
            'nama'          => $pinjaman->anggotaid->nama,
            'alamat'        => $pinjaman->anggotaid->alamat.", ".$pinjaman->anggotaid->kota,", ".$pinjaman->anggotaid->provinsi,
            'tglrealisasi'  => $pinjaman->realisasiid->tanggal_realisasi,
            'realisasi'     => number_format($pinjaman->realisasiid->realisasi, 2, '.', ',')
        );

        return json_encode($data);
    }

    public function ajaxtable($idp) {
        $pinjaman = Pinjaman::find($idp);
        $pembayaran = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->get();

        echo'<table class="table table-bordered table-striped mg-t editable-datatable" id="table">';
        echo '<thead>';
        echo '<tr class="bg-color">';
        echo '<th class="text-center">No</th>';
        echo '<th class="text-center">No.Transaksi</th>';
        echo '<th class="text-center">Tanggal</th>';
        echo '<th class="text-center">NPK</th>';
        echo '<th class="text-center">Kode Anggota</th>';
        echo '<th class="text-center">Tipe</th>';
        echo '<th class="text-center">Keterangan</th>';
        echo '<th class="text-right">Pokok</th>';
        echo '<th class="text-right">Bunga</th>';
        echo '<th class="text-right">Denda</th>';
        echo '<th class="text-right">Saldo</th>';
        echo '</tr>';
        echo '</thead>';
        $i = 1;
        echo '<tbody>';
        foreach ($pembayaran as $tampil) {
            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            echo '<td>'.$tampil->nomor_transaksi.'</td>';
            echo '<td class="text-center">'.$tampil->tanggal.'</td>';
            echo '<td>'.$tampil->pinjamanid->anggotaid->npk.'</td>';
            echo '<td>'.$tampil->pinjamanid->anggotaid->kode.'</td>';
            echo '<td class="text-center">'.$tampil->tipe.'</td>';
            echo '<td>'.$tampil->keterangan.'</td>';
            echo '<td align="right">'.number_format($tampil->pokok, 2, '.', ',').'</td>';
            echo '<td align="right">'.number_format($tampil->bunga, 2, '.', ',').'</td>';
            echo '<td align="right">'.number_format($tampil->denda, 2, '.', ',').'</td>';
            echo '<td align="right">'.number_format($tampil->saldo, 2, '.', ',').'</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function ajaxtable2($idp) {
        $pinjaman = Pinjaman::find($idp);
        $pembayaran = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->count();
        echo '<div class="pull-right" id="jml">Total data ditemukan : '.$pembayaran.'</div>';
    }

    public function cetak($idp, $ctk) {

        $mutasi = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->get();
        $tpokok = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->sum('pokok');
        $tbunga = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->sum('bunga');
        $tdenda = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->sum('denda');
        $tsaldo = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->sum('saldo');
        $pinjaman = Pinjaman::find($idp);
        $pdf = PDF::loadView('pinjaman.mutasi_pinjaman_print', ['mutasi' => $mutasi, 'pinjaman' => $pinjaman, 'tpokok' => $tpokok, 'tbunga' => $tbunga, 'tdenda' => $tdenda, 'tsaldo' => $tsaldo]);

        if ($ctk == "print") {
            return $pdf->download('Mutasi-Pinjaman.pdf');
        } else {
            return $pdf->stream('Mutasi-Pinjaman.pdf');
        }
    }
}
