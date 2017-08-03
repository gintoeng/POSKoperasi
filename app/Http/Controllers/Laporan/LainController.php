<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Kas;
use App\Model\Akuntansi\TransaksiHeader;
use App\Model\Akuntansi\Tabungan;
use App\Model\Akuntansi\TabunganTransaksi;
use App\Model\Akuntansi\Perkiraan;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LainController extends Controller
{
    public function dtrakun() {
        return view('laporan.lain.daftar_akun');
    }

    public function dtakun_cetak(request $requests){
    	if($requests->urut=="nama"){
            $perkiraan = Perkiraan::where('tipe_akun', 'detail')->where('kelompok', $requests->kelompok_akun)->orderBy('nama', 'ASC')->get();
        } else if($requests->urut=="kode"){
            $perkiraan = Perkiraan::where('tipe_akun', 'detail')->where('kelompok', $requests->kelompok_akun)->orderBy('id', 'ASC')->get();
        }

        $kelompok = Perkiraan::find($requests->kelompok_akun);

        $kelompok = $kelompok->nama_akun;

        $pdf = PDF::loadView('laporan.lain.daftar_akun_print', ['perkiraan' => $perkiraan, 'kelompok' => $kelompok]);
        return $pdf->stream('Data Akun Perkiraan.pdf');
    }

    public function dtrjrl() {
        return view('laporan.lain.daftar_jurnal');
    }

    public function dtjurnal_cetak(request $requests){
    	$dari = date("Y-m-d", strtotime($requests->dari));
    	$ke = date("Y-m-d", strtotime($requests->ke));

    	if($requests->urut=="no_transaksi"){
            $jurnalheader = Jurnalheader::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->where('tipe', $requests->jenis_transaksi)->orderBy('id', 'ASC')->get();
        } else if($requests->urut=="tgl"){
            $jurnalheader = Jurnalheader::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->where('tipe', $requests->jenis_transaksi)->orderBy('tanggal', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.lain.daftar_jurnal_print', ['jurnalheader' => $jurnalheader]);
        return $pdf->stream('Data Jurnal.pdf');
    }



    public function pos() {
        return view('laporan.lain.pos');
    }

    public function pos_cetak(request $requests){
    	$dari = date("Y-m-d", strtotime($requests->dari));
    	$ke = date("Y-m-d", strtotime($requests->ke));

    	if($requests->urut=="tgl"){
            $transaksi = TransaksiHeader::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->orderBy('tanggal', 'ASC')->get();
        } else if($requests->urut=="no_transaksi"){
            $transaksi = TransaksiHeader::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->orderBy('no', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.lain.pos_print', ['transaksi' => $transaksi]);
        return $pdf->stream('Data Kas Transfer.pdf');
    }


    public function tabungan() {
        return view('laporan.lain.tabungan');
    }

    public function tabungan_cetak(request $requests){
    	$dari = date("Y-m-d", strtotime($requests->dari));
    	$ke = date("Y-m-d", strtotime($requests->ke));

    	if($requests->urut=="tgl"){
            $tabungan = Tabungan::where('tanggal_pembuatan', '>=', $dari." 00:00:00")->where('tanggal_pembuatan', '<=', $ke." 23:59:00")->orderBy('tanggal_pembuatan', 'ASC')->get();
        } else if($requests->urut=="no_transaksi"){
            $tabungan = Tabungan::where('tanggal_pembuatan', '>=', $dari." 00:00:00")->where('tanggal_pembuatan', '<=', $ke." 23:59:00")->orderBy('id', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.lain.tabungan_print', ['tabungan' => $tabungan]);
        return $pdf->stream('Data Tabungan.pdf');
    }

    public function tabungantrans() {
        return view('laporan.lain.tabungantrans');
    }

    public function tabungantrans_cetak(request $requests){
    	$dari = date("Y-m-d", strtotime($requests->dari));
    	$ke = date("Y-m-d", strtotime($requests->ke));

    	if($requests->urut=="tgl"){
            $tabungan = TabunganTransaksi::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->orderBy('tanggal', 'ASC')->get();
        } else if($requests->urut=="no_transaksi"){
            $tabungan = TabunganTransaksi::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->orderBy('id', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.lain.tabungantrans_print', ['tabungan' => $tabungan]);
        return $pdf->stream('Data Tabungan Transaksi.pdf');
    }

    public function neracasaldo() {
        return view('laporan.lain.neracasaldo');
    }

    public function neracasaldo_cetak(request $requests){
    	$dari = date("Y-m-d", strtotime($requests->dari));
    	$ke = date("Y-m-d", strtotime($requests->ke));

    	if($requests->urut=="tgl"){
            $tabungan = TabunganTransaksi::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->orderBy('tanggal', 'ASC')->get();
        } else if($requests->urut=="no_transaksi"){
            $tabungan = TabunganTransaksi::where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00")->orderBy('id', 'ASC')->get();
        }

        $pdf = PDF::loadView('laporan.lain.neracasaldo_print', ['tabungan' => $tabungan]);
        return $pdf->stream('Data Neraca Saldo.pdf');
    }
}
