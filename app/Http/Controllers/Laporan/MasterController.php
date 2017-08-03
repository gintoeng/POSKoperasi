<?php

namespace App\Http\Controllers\Laporan;

use App\Model\Master\Anggota;
use App\Model\Simpanan\Simpanan;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    public function dtanggota() {
        $customer = Anggota::all();
        return view('laporan.master.data_anggota')->with('customer', $customer);
    }

    public function cetak(Request $request) {
        $jenis = $request->jenis_customer;
        $csdari = $request->csdari;
        $cske = $request->cske;

        if ($jenis == "") {
            if($csdari > 0 && $cske > 0) {
                $cs1 = Anggota::find($csdari);
                $cs2 = Anggota::find($cske);
                $kode = $cs1->kode." - ".$cs2->kode;
                $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->orderBy($request->urut, $request->urutan)->get();
            } else {
                $kode = " - ";
                $customer = Anggota::orderBy($request->urut, $request->urutan)->get();
            }
        } else {
            if($csdari > 0 && $cske > 0) {
                $cs1 = Anggota::find($csdari);
                $cs2 = Anggota::find($cske);
                $kode = $cs1->kode." - ".$cs2->kode;
                $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jenis)->orderBy($request->urut, $request->urutan)->get();
            } else {
                $kode = " - ";
                $customer = Anggota::where('jenis_nasabah', $jenis)->orderBy($request->urut, $request->urutan)->get();
            }
        }
        $pdf = PDF::loadView('laporan.master.data_anggota_print', ['customer' => $customer, 'jenis' => $jenis, 'kode' => $kode]);

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Customer.pdf');
        } else {
            return $pdf->download('Daftar-Customer.pdf');
        }
    }
}
