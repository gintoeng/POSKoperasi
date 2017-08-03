<?php

namespace App\Http\Controllers\Laporan;

use App\Model\Master\Anggota;
use App\Model\Simpanan\Pengaturan;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SimpananController extends Controller
{
    public function dtsimp() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $simpanan = Simpanan::all();
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        return view('laporan.simpanan.data_simpanan')->with('today', $today)
            ->with('simpanan', $simpanan)
            ->with('pengaturan', $pengaturan)
            ->with('customer', $customer);
    }

    public function cetakdtsimp(Request $request) {

        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
//            $df = explode('/', $request->dari);
//            $dt = explode('/', $request->ke);
//            $dfrom = $df[2] . '-' . $df[0] . '-' . $df[1];
//            $dto = $dt[2] . '-' . $dt[0] . '-' . $dt[1];
        } else {
            $dfrom = "";
            $dto = "";
        }


        $datenya = $dfrom." s/d ".$dto;

        $csdari = $request->csdari;
        $cske = $request->cske;
        $darisimp = $request->darisimp;
        $kesimp = $request->kesimp;

        $js = $request->jenis_simpanan;
        $jc = $request->jenis_customer;

        if($js > 0) {
            $pengaturan = Pengaturan::find($js);
            $jsnya = $pengaturan->jenis_simpanan;
            if($darisimp > 0 && $kesimp > 0) {
                $s1 = Simpanan::find($darisimp);
                $s2 = Simpanan::find($kesimp);
                $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                if($jc != "") {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc);
                        })->where('id', '>=',$darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->where('id', '>=',$darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $simpnya = "-";
                if($jc != "") {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc);
                        })->where('jenis_simpanan', $js)->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->where('jenis_simpanan', $js)->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->where('jenis_simpanan', $js)->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::where('jenis_simpanan', $js)->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        } else {
            $jsnya = "";
            if($darisimp > 0 && $kesimp > 0) {
                $s1 = Simpanan::find($darisimp);
                $s2 = Simpanan::find($kesimp);
                $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                if($jc != "") {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc);
                        })->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::where('id', '>=', $darisimp)->where('id', '<=', $kesimp)
                            ->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)
                            ->orderBy($request->urut, $request->urutan)->get();
                    }
                }

            } else {
                $simpnya = "-";
                if($jc != "") {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc);
                        })->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    if($csdari > 0 && $cske > 0) {
                        $cs1 = Anggota::find($csdari);
                        $cs2 = Anggota::find($cske);
                        $csnya = $cs1->kode." - ".$cs2->kode;
                        $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $csnya = "-";
                        $simp = Simpanan::where('tanggal_pembuatan', '>=', $dfrom)->where('tanggal_pembuatan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        }

        $simpanan = $this->_fornya($simp);

        $pdf = PDF::loadView('laporan.simpanan.data_simpanan_print', ['simpanan' => $simpanan, 'simpnya' => $simpnya, 'csnya' => $csnya, 'jc' => $jc, 'jsnya' => $jsnya, 'datenya' => $datenya]);

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Simpanan.pdf');
        } else {
            return $pdf->download('Daftar-Simpanan.pdf');
        }

    }


    public function _fornya($simp) {

        if ($simp->count() > 0) {
            foreach ($simp as $get2) {
                $data[] = array(
                    'nosimp' => $get2->nomor_simpanan,
                    'nama' => $get2->anggotaid->nama,
                    'tgllahir' => $get2->anggotaid->tanggal_lahir,
                    'alamat' => $get2->anggotaid->alamat,
                    'telp' => $get2->anggotaid->telepon,
                    'jsimp' => $get2->pengaturanid->jenis_simpanan,
                    'kelamin' => $get2->anggotaid->jenis_kelamin
                );
            }
        }else {
            $data[] = array(
                'nosimp' => "",
                'nama' => "",
                'tgllahir' => "",
                'alamat' => "",
                'telp' => "",
                'jsimp' => "",
                'kelamin' => ""
            );
        }

        return $data;
    }







    public function saldosimp() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $simpanan = Simpanan::all();
        $pengaturan = Pengaturan::all();
        return view('laporan.simpanan.saldo_simpanan')->with('today', $today)
            ->with('simpanan', $simpanan)
            ->with('pengaturan', $pengaturan);
    }

    public function cetaksaldosimp(Request $request) {

        if ($request->tgl != "") {
            $dper = date("Y-m-d", strtotime($request->tgl));
//            $df = explode('/', $request->tgl);
//            $dper = $df[2] . '-' . $df[0] . '-' . $df[1];
        } else {
            $dper = "";
        }

        $darisimp = $request->darisimp;
        $kesimp = $request->kesimp;

        $js = $request->jenis_simpanan;
        $jc = $request->jenis_customer;


        if($js != "") {
            $pengaturan = Pengaturan::find($js);
            $jsnya = $pengaturan->jenis_simpanan;
            if($darisimp > 0 && $kesimp > 0) {
                $s1 = Simpanan::find($darisimp);
                $s2 = Simpanan::find($kesimp);
                $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                if($jc != 0) {
                    $simp = Simpanan::whereHas('anggotaid', function ($query) use ($jc) {
                        $query->where('jenis_nasabah', $jc);
                    })->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)->orderBy($request->urut, $request->urutan)->get();
                } else {
                    $simp = Simpanan::where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)->orderBy($request->urut, $request->urutan)->get();
                }
            } else {
                $simpnya = "-";
                if($jc != 0) {
                    $simp = Simpanan::whereHas('anggotaid', function ($query) use ($jc) {
                        $query->where('jenis_nasabah', $jc);
                    })->where('jenis_simpanan', $js)->orderBy($request->urut, $request->urutan)->get();
                } else {
                    $simp = Simpanan::where('jenis_simpanan', $js)->orderBy($request->urut, $request->urutan)->get();
                }
            }
        } else {
            $jsnya = "";
            if($darisimp > 0 && $kesimp > 0) {
                $s1 = Simpanan::find($darisimp);
                $s2 = Simpanan::find($kesimp);
                $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                if($jc != 0) {
                    $simp = Simpanan::whereHas('anggotaid', function ($query) use ($jc) {
                        $query->where('jenis_nasabah', $jc);
                    })->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->orderBy($request->urut, $request->urutan)->get();
                } else {
                    $simp = Simpanan::where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->orderBy($request->urut, $request->urutan)->get();
                }
            } else {
                $simpnya = "-";
                if($jc != 0) {
                    $simp = Simpanan::whereHas('anggotaid', function ($query) use ($jc) {
                        $query->where('jenis_nasabah', $jc);
                    })->orderBy($request->urut, $request->urutan)->get();
                } else {
                    $simp = Simpanan::orderBy($request->urut, $request->urutan)->get();
                }
            }
        }
        $simpanan = $this->_fornyasaldo($simp, $dper);

        if($request->pilih == "sld") {
            $pdf = PDF::loadView('laporan.simpanan.saldo_simpanan_print', ['simpanan' => $simpanan, 'simpnya' => $simpnya, 'jc' => $jc, 'jsnya' => $jsnya, 'dper' => $dper]);
        } else {
            if($js != "") {
                $pengaturan = Pengaturan::where('id', $js)->get();
            } else {
                $pengaturan = Pengaturan::all();
            }

            foreach($pengaturan as $item) {
                $data[] = array(
                    'idp'   => $item->id,
                    'idj'   => $item->id,
                    'jenis'   => $item->jenis_simpanan
                );
            }
            $aturan = $data;
            $pdf = PDF::loadView('laporan.simpanan.saldo_simpanan_print2', ['aturan' => $aturan, 'simpanan' => $simpanan, 'simpnya' => $simpnya, 'jc' => $jc, 'jsnya' => $jsnya, 'dper' => $dper]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Saldo-Simpanan.pdf');
        } else {
            return $pdf->download('Daftar-Saldo-Simpanan.pdf');
        }
    }

    public function _fornyasaldo($simp, $dper) {
        $i = 0;
        if ($simp->count() > 0) {
            foreach ($simp as $get2) {
                $transaksi = Transaksi::where('id_simpanan', $get2->id)->where('tanggal', '<=', $dper)->orderBy('id', 'asc')->get();
                $idt = 0;
                foreach ($transaksi as $get3) {
                    $idt = $get3->id;
                }
                $tran = Transaksi::find($idt);
                $tcount = Transaksi::where('id_simpanan', $get2->id)->where('tanggal', '<=', $dper)->orderBy('id', 'asc')->count();
                if ($tcount == 0) {
                    $saldo = 0;
                    //print_r("0");
                } else {
                    $saldo = $tran->saldo_akhir;
                }
                $idj = $get2->jenis_simpanan;

                $data[] = array(
                    'nosimp' => $get2->nomor_simpanan,
                    'nama' => $get2->anggotaid->nama,
                    'jsimp' => $get2->pengaturanid->jenis_simpanan,
                    'saldo' => number_format($saldo, 2, '.', ','),
                    'sld' => $saldo,
                    'sld2' => $saldo,
                    'idj' => $idj
                );
            }
        } else {
            $data[] = array(
                'nosimp' => "",
                'nama' => "",
                'jsimp' => "",
                'saldo' => "",
                'sld' => 0,
                'sld2' => 0,
                'idj' => 0
            );
        }

        return $data;
    }






    public function saldosimpjns() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        return view('laporan.simpanan.saldo_simpanan_jenis')->with('today', $today)
            ->with('pengaturan', $pengaturan)
            ->with('customer', $customer);
    }

    public function cetaksaldosimpjns(Request $request) {
        if ($request->tgl != "") {
            $dper = date("Y-m-d", strtotime($request->tgl));
//            $df = explode('/', $request->tgl);
//            $dper = $df[2] . '-' . $df[0] . '-' . $df[1];
        } else {
            $dper = "";
        }

        $js = $request->jenis;
        $jc = $request->jenis_customer;
        $csdari = $request->csdari;
        $cske = $request->cske;
        $urut = $request->urut;
        $urutan = $request->urutan;

        if ($jc == "") {
            if($csdari > 0 && $cske > 0) {
                $cs1 = Anggota::find($csdari);
                $cs2 = Anggota::find($cske);
                $csnya = $cs1->kode." - ".$cs2->kode;
                $cc = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->count();
                $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske){
                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                })->orderBy($urut, $urutan)->get();
            } else {
                $csnya = " - ";
                $cc = Anggota::count();
                $simp = Simpanan::orderBy($urut, $urutan)->get();
            }
        } else {
            if($csdari > 0 && $cske > 0) {
                $cs1 = Anggota::find($csdari);
                $cs2 = Anggota::find($cske);
                $csnya = $cs1->kode." - ".$cs2->kode;
                $cc = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc)->count();
                $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske){
                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                })->orderBy($urut, $urutan)->get();
            } else {
                $csnya = " - ";
                $customer = Anggota::where('jenis_nasabah', $jc)->get();
                $cc = Anggota::where('jenis_nasabah', $jc)->count();
                $simp = Simpanan::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske){
                    $query->where('jenis_nasabah', $jc);
                })->orderBy($urut, $urutan)->get();
            }
        }
        $simpanan = $this->_forjns($simp, $dper);

        if ($js > 0) {
            foreach($request->jenis as $key => $jenisid) {
                $pengaturan = Pengaturan::find($jenisid);
                $data[] = array(
                    'idp' => $key,
                    'kjenis' => $pengaturan->jenis_simpanan
                );
            }
            $jenis = $data;
            $pdf = PDF::loadView('laporan.simpanan.saldo_simpanan_jenis_print2', ['simpanan' => $simpanan, 'jenis' => $jenis, 'csnya' => $csnya, 'jc' => $jc, 'js' => $js, 'dper' => $dper, 'cc' => $cc]);
        } else {
            $pdf = PDF::loadView('laporan.simpanan.saldo_simpanan_jenis_print', ['simpanan' => $simpanan, 'csnya' => $csnya, 'jc' => $jc, 'js' => $js, 'dper' => $dper]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Saldo-Simpanan-Kolom-Jenis.pdf');
        } else {
            return $pdf->download('Daftar-Saldo-Simpanan-Kolom-Jenis.pdf');
        }
    }

    public function _forjns($simp, $dper) {
            if ($simp->count() > 0) {
                foreach ($simp as $get2) {
                    $transaksi = Transaksi::where('id_simpanan', $get2->id)->where('tanggal', '<=', $dper)->orderBy('id', 'asc')->get();
                    $idt = 0;
                    foreach ($transaksi as $get3) {
                        $idt = $get3->id;
                    }
                    $tran = Transaksi::find($idt);
                    $tcount = Transaksi::where('id_simpanan', $get2->id)->where('tanggal', '<=', $dper)->orderBy('id', 'asc')->count();
                    if ($tcount == 0) {
                        $saldo = 0;
                    } else {
                        $saldo = $tran->saldo_akhir;
                    }
                    $idj = $get2->jenis_simpanan;

                    $data[] = array(
                        'nosimp' => $get2->nomor_simpanan,
                        'nama' => $get2->anggotaid->nama,
                        'idj' => $idj,
                        'sld' => $saldo,
                        'total' => number_format($saldo, 2, '.', ',')
                    );
                }
            } else {
                $data[] = array(
                    'nosimp' => "",
                    'nama' => "",
                    'idj' => 0,
                    'sld' => 0,
                    'total' => ""
                );
            }

        return $data;
    }





    public function transimp() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $simpanan = Simpanan::all();
        $pengaturan = Pengaturan::all();
        $transaksi = Transaksi::all();
        $customer = Anggota::all();
        return view('laporan.simpanan.transaksi_simpanan')->with('today', $today)
            ->with('simpanan', $simpanan)
            ->with('pengaturan', $pengaturan)
            ->with('transaksi', $transaksi)
            ->with('customer', $customer);
    }

    public function cetaktransimp(Request $request) {

        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
//            $df = explode('/', $request->dari);
//            $dt = explode('/', $request->ke);
//            $dfrom = $df[2] . '-' . $df[0] . '-' . $df[1];
//            $dto = $dt[2] . '-' . $dt[0] . '-' . $dt[1];
        } else {
            $dfrom = "";
            $dto = "";
        }


        $datenya = $dfrom." s/d ".$dto;

        $daritran = $request->daritran;
        $ketran = $request->ketran;
        $darisimp = $request->darisimp;
        $kesimp = $request->kesimp;

        $js = $request->jenis_simpanan;
        $jc = $request->jenis_customer;
        $urut = $request->urut;
        $urutan = $request->urutan;

        if ($daritran > 0 && $ketran > 0) {
            $t1 = Transaksi::find($daritran);
            $t2 = Transaksi::find($ketran);
            $trannya = $t1->kode." - ".$t2->kode;
            if ($js != "") {
                $pengaturan = Pengaturan::where('id', $js)->get();
                if ($darisimp > 0 && $kesimp > 0) {
                    $s1 = Simpanan::find($darisimp);
                    $s2 = Simpanan::find($kesimp);
                    $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                    if ($jc != "") {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js);
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $simpnya = "-";
                    if ($jc != "") {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('jenis_simpanan', $js)->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('jenis_simpanan', $js);
                        })->orderBy($urut, $urutan)->get();
                    }
                }
            } else {
                $pengaturan = Pengaturan::all();
                if ($darisimp > 0 && $kesimp > 0) {
                    $s1 = Simpanan::find($darisimp);
                    $s2 = Simpanan::find($kesimp);
                    $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                    if ($jc != "") {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp);
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $simpnya = "-";
                    if ($jc != "") {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::where('id', '>=', $daritran)->where('id', '<=', $ketran)->orderBy($urut, $urutan)->get();
                    }
                }
            }

        } else {
            $trannya = "-";
            if ($js != "") {
                $pengaturan = Pengaturan::where('id', $js)->get();
                if ($darisimp > 0 && $kesimp > 0) {
                    $s1 = Simpanan::find($darisimp);
                    $s2 = Simpanan::find($kesimp);
                    $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                    if ($jc != "") {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js)->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->where('jenis_simpanan', $js);
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $simpnya = "-";
                    if ($jc != "") {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('jenis_simpanan', $js)->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('jenis_simpanan', $js);
                        })->orderBy($urut, $urutan)->get();
                    }
                }
            } else {
                $pengaturan = Pengaturan::all();
                if ($darisimp > 0 && $kesimp > 0) {
                    $s1 = Simpanan::find($darisimp);
                    $s2 = Simpanan::find($kesimp);
                    $simpnya = $s1->nomor_simpanan." - ".$s2->nomor_simpanan;
                    if ($jc != "") {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp)->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->where('id', '>=', $darisimp)->where('id', '<=', $kesimp);
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $simpnya = "-";
                    if ($jc != "") {
                        $transaksi = Transaksi::whereHas('simpananid', function($query) use ($js,$darisimp,$kesimp, $jc) {
                            $query->whereHas('anggotaid', function ($querys) use ($jc) {
                                $querys->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $transaksi = Transaksi::orderBy($urut, $urutan)->get();
                    }
                }
            }
        }

        $simpanan = $this->_fortran($transaksi);

        if ($request->pilih == "transimp") {
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print', ['simpanan' => $simpanan, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        } else if($request->pilih == "retrantipe") {
            $s = 0;
            $t = 0;
            $x = 0;
            $y = 0;
            foreach($simpanan as $item) {
                if ($item['tipe'] == "SETOR") {
                    $s+=$item['sld'];
                } elseif ($item['tipe'] == "TARIK") {
                    $t+=$item['sld'];
                } elseif ($item['tipe'] == "TRANSFER") {
                    $x+=$item['sld'];
                } else {
                    $y+=$item['sld'];
                }
            }

            $sld['s'] = $s;
            $sld['t'] = $t;
            $sld['x'] = $x;
            $sld['y'] = $y;
            $sld['z'] = $s + $t + $x + $y;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print2', ['sld' => $sld, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        } else if($request->pilih == "detrantipe") {
            $s = 0;
            $t = 0;
            $x = 0;
            $y = 0;
            foreach($simpanan as $item) {
                if ($item['tipe'] == "SETOR") {
                    $s+=$item['sld'];
                } elseif ($item['tipe'] == "TARIK") {
                    $t+=$item['sld'];
                } elseif ($item['tipe'] == "TRANSFER") {
                    $x+=$item['sld'];
                } else {
                    $y+=$item['sld'];
                }
            }

            $sld['s'] = $s;
            $sld['t'] = $t;
            $sld['x'] = $x;
            $sld['y'] = $y;
            $sld['z'] = $s + $t + $x + $y;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print3', ['sld' => $sld, 'simpanan' => $simpanan, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        } else if($request->pilih == "retranjenis") {
            foreach($pengaturan as $item) {
                $data[]= array(
                    'jenis' => $item->jenis_simpanan,
                    'idp'   => $item->id,
                    'idj'   => $item->id,
                );
            }
            $aturan = $data;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print4', ['aturan' => $aturan,'simpanan' => $simpanan, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        } else if($request->pilih == "detranjenis") {
            foreach($pengaturan as $item) {
                $data[]= array(
                    'jenis' => $item->jenis_simpanan,
                    'idp'   => $item->id,
                    'idj'   => $item->id,
                );
            }
            $aturan = $data;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print5', ['aturan' => $aturan,'simpanan' => $simpanan, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        } else if ($request->pilih == "retranjeniscs") {
            $s = 0;
            $t = 0;
            $u = 0;
            foreach($simpanan as $item) {
                if ($item['jcs'] == "UMUM") {
                    $s+=$item['sld'];
                } else if($item['jcs'] == "BIASA") {
                    $t+=$item['sld'];
                } else {
                    $u+=$item['sld'];
                }
            }
            $sld['s'] = $s;
            $sld['t'] = $t;
            $sld['u'] = $u;
            $sld['z'] = $s+$t+$u;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print6', ['sld' => $sld, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        } else if ($request->pilih == "detranjeniscs") {
            $s = 0;
            $t = 0;
            $u = 0;
            foreach($simpanan as $item) {
                if ($item['jcs'] == "UMUM") {
                    $s+=$item['sld'];
                } else if ($item['jcs'] == "BIASA") {
                    $t+=$item['sld'];
                } else {
                    $u+=$item['sld'];
                }
            }
            $sld['s'] = $s;
            $sld['t'] = $t;
            $sld['u'] = $u;
            $sld['z'] = $s+$t+$u;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print7', ['sld' => $sld, 'simpanan' => $simpanan, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        }else {
            foreach($pengaturan as $item) {
                $data[]= array(
                    'jenis' => $item->jenis_simpanan,
                    'idp'   => $item->id,
                    'idp2'   => $item->id,
                    'idp3'   => $item->id,
                    'idp4'   => $item->id,
                    'idp5'   => $item->id,
                    'idj'   => $item->id,
                );
            }
            $aturan = $data;
            $s = 0;
            $t = 0;
            $x = 0;
            $y = 0;
            foreach($simpanan as $item) {
                if ($item['tipe'] == "SETOR") {
                    $s+=$item['sld'];
                } elseif ($item['tipe'] == "TARIK") {
                    $t+=$item['sld'];
                } elseif ($item['tipe'] == "TRANSFER") {
                    $x+=$item['sld'];
                } else {
                    $y+=$item['sld'];
                }
            }

            $sld['s'] = $s;
            $sld['t'] = $t;
            $sld['x'] = $x;
            $sld['y'] = $y;
            $sld['z'] = $s + $t + $x + $y;
            $pdf = PDF::loadView('laporan.simpanan.transaksi_simpanan_print8', ['sld' => $sld, 'aturan' => $aturan, 'simpanan' => $simpanan, 'simpnya' => $simpnya, 'trannya' => $trannya, 'datenya' => $datenya, 'jc' => $jc, 'js' => $js]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Transaksi-Simpanan.pdf');
        } else {
            return $pdf->download('Daftar-Transaksi-Simpanan.pdf');
        }
    }

    public function _fortran($transaksi) {
        if ($transaksi->count() > 0) {
                foreach ($transaksi as $get3) {
                    $data[] = array(
                        'notran' => $get3->kode,
                        'nosimp' => $get3->simpananid->nomor_simpanan,
                        'nama' => $get3->simpananid->anggotaid->nama,
                        'tgl' => $get3->tanggal,
                        'tipe' => $get3->tipe,
                        'jumlah' => number_format($get3->nominal, 2, '.', ','),
                        'ket' => $get3->keterangan,
                        'sld' => $get3->nominal,
                        'idj' => $get3->simpananid->jenis_simpanan,
                        'jcs' => $get3->simpananid->anggotaid->jenis_nasabah
                    );
                }
        } else {
            $data[] = array(
                'notran' => "",
                'nosimp' => "",
                'nama' => "",
                'tgl' => "",
                'tipe' => "",
                'jumlah' => "",
                'ket' => "",
                'sld' => "",
                'idj' => "",
                'jcs' => ""
            );
        }

        return $data;
    }
}
