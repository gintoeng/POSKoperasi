<?php

namespace App\Http\Controllers\Akuntansi;

use App\Model\Master\Unit;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProyeksiController extends Controller
{
    function tampil_abjad ($x) {
        $bulan = array (1=>'H',2=>'I',3=>'J',4=>'K',
            5=>'L',6=>'M',7=>'N',8=>'O',
            9=>'P',10=>'Q',11=>'R',12=>'S',13=>'T',14=>'U',15=>'V',16=>'W',
            17=>'X',18=>'Y',19=>'Z',20=>'AA',21=>'AB',22=>'AC',23=>'AD',24=>'AE');
        return $bulan[$x];
    }

    function tampil_abjadbunga ($x) {
        $bulan = array (1=>'J',2=>'K',3=>'L',4=>'M',
            5=>'N',6=>'O',7=>'P',8=>'Q',
            9=>'R',10=>'S',11=>'T',12=>'U',13=>'V',14=>'W',15=>'X',16=>'Y',
            17=>'Z',18=>'AA',19=>'AB',20=>'AC',21=>'AD',22=>'AE',23=>'AF',24=>'AG');
        return $bulan[$x];
    }

    function tampil_abjadpinj ($x) {
        $bulan = array (1=>'K',2=>'L',3=>'M',4=>'N',
            5=>'O',6=>'P',7=>'Q',8=>'R',
            9=>'S',10=>'T',11=>'U',12=>'V',13=>'W',14=>'X',15=>'Y',16=>'Z',
            17=>'AA',18=>'AB',19=>'AC',20=>'AD',21=>'AE',22=>'AF',23=>'AG',24=>'AH');
        return $bulan[$x];
    }

    public function indexsimpanan() {
        $simpanan = Simpanan::orderBy('anggota', 'asc')->paginate(50);
        $jml = Simpanan::count();
        return view('Akuntansi.proyeksi.simpanan_index')->with('simpanan', $simpanan)->with('jml', $jml);
    }

    public function indexbungasimpanan() {
        $simpanan = Simpanan::orderBy('anggota', 'asc')->paginate(50);
        $jml = Simpanan::count();
        return view('Akuntansi.proyeksi.simpanan_bunga_index')->with('simpanan', $simpanan)->with('jml', $jml);
    }

    public function indexpinjaman() {
        $pinjaman = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->orderBy('anggota', 'asc')->paginate(50);
        $jml = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->count();
        return view('Akuntansi.proyeksi.pinjaman_index')->with('pinjaman', $pinjaman)->with('jml', $jml);
    }


    public function cetaksimpanan(Request $request) {
        $simpanan = Simpanan::orderBy('anggota', 'asc')->take(10)->get();
        $pdf = PDF::loadView('Akuntansi.proyeksi.simpanan_print', ['simpanan' => $simpanan]);

        $customPaper = array(0,0,950,950);
        if ($request->print == "preview") {
            return $pdf->setPaper($customPaper, 'landscape')->stream('Proyeksi-Simpanan.pdf');
        } else {
            return $pdf->setPaper($customPaper, 'landscape')->download('Proyeksi-Simpanan.pdf');
        }
    }

    public function cetakbungasimpanan(Request $request) {
        $simpanan = Simpanan::orderBy('anggota', 'asc')->take(10)->get();
        $pdf = PDF::loadView('Akuntansi.proyeksi.simpanan_bunga_print', ['simpanan' => $simpanan]);

        $customPaper = array(0,0,950,950);
        if ($request->print == "preview") {
            return $pdf->setPaper($customPaper, 'landscape')->stream('Proyeksi-Bunga-Simpanan.pdf');
        } else {
            return $pdf->setPaper($customPaper, 'landscape')->download('Proyeksi-Bunga-Simpanan.pdf');
        }
    }

    public function cetakpinjaman(Request $request) {
        $pinjaman = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->orderBy('anggota', 'asc')->get();
        $pdf = PDF::loadView('Akuntansi.proyeksi.pinjaman_print', ['pinjaman' => $pinjaman]);

        $customPaper = array(0,0,950,950);
        if ($request->print == "preview") {
            return $pdf->setPaper($customPaper, 'landscape')->stream('Proyeksi-Pinjaman.pdf');
        } else {
            return $pdf->setPaper($customPaper, 'landscape')->download('Proyeksi-Pinjaman.pdf');
        }
    }
    
    
    public function excelsimpanan() {
        date_default_timezone_set('Asia/Jakarta');
        Excel::create("Proyeksi-Simpanan", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->mergeCells('H1:I1');
                $sheet->mergeCells('J1:K1');
                $sheet->mergeCells('L1:M1');
                $sheet->mergeCells('N1:O1');
                $sheet->mergeCells('P1:Q1');
                $sheet->mergeCells('R1:S1');
                $sheet->mergeCells('T1:U1');
                $sheet->mergeCells('V1:W1');
                $sheet->mergeCells('X1:Y1');
                $sheet->mergeCells('Z1:AA1');
                $sheet->mergeCells('AB1:AC1');
                $sheet->mergeCells('AD1:AE1');
                $arr = array('KODE_ANGGOTA','NAMA_ANGGOTA','NPK','SIMPANAN','SETORAN_BULANAN','TGL_PEMBUATAN','SALDO_SEKARANG','','','','','','','','','','','','','','','','','','','','','','','','');
                $arr2 = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
                $i =0;
                for ($z=9; $z<=12; $z++){
                    $a = $i++;
                    $arr[7+($a*2)] = 'BLN '.$z;
                    $arr2[7+($a*2)] = 'SETORAN';
                    $arr2[8+($a*2)] = 'SALDO';
                }
                $b = (13-9)*2;
                $abjad = $this->tampil_abjad($b);
                $simpanan = Simpanan::orderBy('anggota', 'asc')->take(10)->get();
                foreach($simpanan as $item){
                    $cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $item->id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $item->setoran_bulanan)->first();
                    if ($cektr == null) {
                        $sld = $item->akumulasiid->saldo;
                    } else {
                        $sld = $item->akumulasiid->saldo - $item->setoran_bulanan;
                    }

                    $arr4 = array(
                        $item->anggotaid->kode, $item->anggotaid->nama, $item->anggotaid->npk, $item->pengaturanid->jenis_simpanan, number_format($item->setoran_bulanan, 2, '.',','), $item->tanggal_pembuatan, number_format($sld, 2,'.',','),'','','','','','','','','','','','','','','','','','','','','','','',''
                    );
                    $u = 0;
                    $asaldo = $sld;
                    for ($y=9; $y<=12; $y++){
                        $sldnya = $asaldo + $item->setoran_bulanan;
                        $a = $u++;
                        $arr4[7+($a*2)] = number_format($item->setoran_bulanan,2,'.',',');
                        $arr4[8+($a*2)] = number_format($sldnya,2,'.',',');
                        $asaldo = $sldnya;
                    }
                    $data=[];
                    array_push($data, $arr4);
                    $sheet->fromArray($data, null, 'A3', false, false);
                }
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:D2');
                $sheet->mergeCells('E1:E2');
                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('G1:G2');

                $sheet->row(1, $arr);
                $sheet->row(2, $arr2);

                $sheet->setBorder('A1:'.$abjad.'1', 'thin');
                $sheet->setBorder('A2:'.$abjad.'2', 'thin');
                $sheet->cells('A1:'.$abjad.'1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->cells('A2:'.$abjad.'2', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setAutoSize(true);
            });
//            return redirect(url()->previous());
        })->download('xls');
    }

    public function excelbungasimpanan() {
        date_default_timezone_set('Asia/Jakarta');
        Excel::create("Proyeksi-Bunga-Simpanan", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->mergeCells('J1:K1');
                $sheet->mergeCells('L1:M1');
                $sheet->mergeCells('N1:O1');
                $sheet->mergeCells('P1:Q1');
                $sheet->mergeCells('R1:S1');
                $sheet->mergeCells('T1:U1');
                $sheet->mergeCells('V1:W1');
                $sheet->mergeCells('X1:Y1');
                $sheet->mergeCells('Z1:AA1');
                $sheet->mergeCells('AB1:AC1');
                $sheet->mergeCells('AD1:AE1');
                $sheet->mergeCells('AF1:AG1');
                $arr = array('KODE_ANGGOTA','NAMA_ANGGOTA','NPK','SIMPANAN','SETORAN_BULANAN','BUNGA','TGL_PEMBUATAN','SISTEM_BUNGA','SALDO_SEKARANG','','','','','','','','','','','','','','','','','','','','','','','','');
                $arr2 = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
                $i =0;
                for ($z=9; $z<=12; $z++){
                    $a = $i++;
                    $arr[9+($a*2)] = 'BLN '.$z;
                    $arr2[9+($a*2)] = 'SETORAN';
                    $arr2[10+($a*2)] = 'SALDO';
                }
                $b = (13-9)*2;
                $abjad = $this->tampil_abjadbunga($b);
                $simpanan = Simpanan::orderBy('anggota', 'asc')->take(10)->get();
                foreach($simpanan as $item){
                    $cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $item->id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $item->setoran_bulanan)->first();
                    if ($cektr == null) {
                        $sld = $item->akumulasiid->saldo;
                    } else {
                        $sld = $item->akumulasiid->saldo - $item->setoran_bulanan;
                    }

                    $arr4 = array(
                        $item->anggotaid->kode, $item->anggotaid->nama, $item->anggotaid->npk, $item->pengaturanid->jenis_simpanan, number_format($item->setoran_bulanan, 2, '.',','), $item->pengaturanid->suku_bunga." %",$item->tanggal_pembuatan, $item->pengaturanid->sbunga->sistem,number_format($sld, 2,'.',','),'','','','','','','','','','','','','','','','','','','','','','','',''
                    );
                    $u = 0;
                    $asaldo = $sld;
                    $saldonya2 = $item->akumulasiid->saldo;
                    $saldor2 = $item->akumulasiid->saldo + $item->setoran_bulanan;
                    for ($y=9; $y<=12; $y++){
                        $a = $u++;
                        $id = $item->id;
                        $saldonya = $saldonya2;
                        $saldor = $saldor2;
                        $setr = $item->setoran_bulanan;

                        $jumHari = date('t');
                        $simp = \App\Model\Simpanan\Simpanan::findOrNew($id);

                        $sistembunga = $simp->pengaturanid->sistem_bunga;
                        $sbunga = $simp->pengaturanid->suku_bunga;
                        $minbunga = $simp->pengaturanid->saldo_minimum_bunga;

                        $akarsaldo = $saldonya;

                        $cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $simp->setoran_bulanan)->first();

                        if ($akarsaldo >= $minbunga) {
                            if ($sistembunga == "1") {
                                $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->min('saldo_akhir');
                                if ($cektr == null) {
                                    if ($simp->setoran_bulanan < $transaksi) {
                                        $saldo = $simp->setoran_bulanan;
                                    } else {
                                        $saldo = $transaksi;
                                    }
                                } else {
                                    $saldo = $transaksi;
                                }
                                $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
                            } else if ($sistembunga == "2") {
                                $i = 0;
                                $t = 0;
                                $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->get();
                                $transaksi2 = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->orderBy('id', 'desc')->first();
                                $trcount = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->count();
                                foreach ($transaksi as $ts) {
                                    $a = $i++;
                                    $b = $a + 1;

                                    if ($b == $trcount) {
                                        $ddt = date('Y-m-t');
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($ddt))) / (60 * 60 * 24));
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $hari;
                                    } else {
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($transaksi[$b]['tanggal']))) / (60 * 60 * 24));
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $hari;
                                    }
                                    $t += $total;
                                }
                                if ($cektr == null) {
                                    $ddt = date('Y-m-t');
                                    $harinya = ((abs(strtotime($transaksi2->tanggal) - strtotime($ddt))) / (60 * 60 * 24));
                                    $saldo = ($t / $jumHari) + ($simp->setoran_bulanan * $harinya);
                                } else {
                                    $saldo = $t / $jumHari;
                                }
                                $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
                            } else {
                                $i = 0;
                                $y = 0;
                                $z = 0;
                                $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->get();
                                $transaksi2 = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->orderBy('id', 'desc')->first();
                                $trcount = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->count();
                                foreach ($transaksi as $gg) {
                                    $a = $i++;
                                    $b = $a + 1;

                                    if ($b == $trcount) {
                                        $ddt = date('Y-m-t');
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($ddt))) / (60 * 60 * 24));
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $simp->suku_bunga / 100 * ($hari / 365);
                                    } else {
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($transaksi[$b]['tanggal']))) / (60 * 60 * 24));
                                        $day = $transaksi[$a]['tanggal'];
                                        $day2 = $transaksi[$b]['tanggal'];
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $simp->suku_bunga / 100 * ($hari / 365);
                                    }
                                    $y += $total;
                                    $z += $nominal;
                                }
                                $saldo = $z;
                                if ($cektr == null) {
                                    $ddt = date('Y-m-t');
                                    $harinya = ((abs(strtotime($transaksi2->tanggal) - strtotime($ddt))) / (60 * 60 * 24));
                                    $bunga = $y + ($simp->setoran_bulanan * $simp->suku_bunga / 100 * ($harinya / 365));
                                } else {
                                    $bunga = $y;
                                }
                            }
                            $bunganya = $bunga;
                        } else {
                            $bunganya = 0;
                        }

                        $sldnya = $asaldo + $setr + $bunganya;
                        $arr4[9+($a*2)] = number_format($bunganya,2,'.',',');
                        $arr4[10+($a*2)] = number_format($sldnya,2,'.',',');
                        $asaldo = $sldnya; $saldonya2 = $sldnya; $saldor2 = $sldnya;
                    }
                    $data=[];
                    array_push($data, $arr4);
                    $sheet->fromArray($data, null, 'A3', false, false);
                }
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:D2');
                $sheet->mergeCells('E1:E2');
                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('G1:G2');
                $sheet->mergeCells('H1:H2');
                $sheet->mergeCells('I1:I2');

                $sheet->row(1, $arr);
                $sheet->row(2, $arr2);

                $sheet->setBorder('A1:'.$abjad.'1', 'thin');
                $sheet->setBorder('A2:'.$abjad.'2', 'thin');
                $sheet->cells('A1:'.$abjad.'1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->cells('A2:'.$abjad.'2', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setAutoSize(true);
            });
//            return redirect(url()->previous());
        })->download('xls');
    }

    public function excelpinjaman() {
        date_default_timezone_set('Asia/Jakarta');
        Excel::create("Proyeksi-Pendapatan-Pinjaman", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->mergeCells('H1:I1');
                $sheet->mergeCells('J1:K1');
                $sheet->mergeCells('L1:M1');
                $sheet->mergeCells('N1:O1');
                $sheet->mergeCells('P1:Q1');
                $sheet->mergeCells('R1:S1');
                $sheet->mergeCells('T1:U1');
                $sheet->mergeCells('V1:W1');
                $sheet->mergeCells('X1:Y1');
                $sheet->mergeCells('Z1:AA1');
                $sheet->mergeCells('AB1:AC1');
                $sheet->mergeCells('AD1:AE1');
                $arr = array('KODE_ANGGOTA','NAMA_ANGGOTA','NPK','PINJAMAN','BUNGA','TGL_AWAL','TGL_AKHIR','TOTAL_BULAN','SISTEM_BUNGA','PENGAJUAN','','','','','','','','','','','','','','','','','','','','','','','','');
                $arr2 = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
                $i =0;
                $th = date('Y');
                for ($z=9; $z<=12; $z++){
                    $a = $i++;
                    $arr[10+($a*2)] = 'BLN '.$z;
                    $arr2[10+($a*2)] = 'OUTSTANDING';
                    $arr2[11+($a*2)] = 'BUNGA';
                }
                $b = (13-9)*2;
                $abjad = $this->tampil_abjadpinj($b);
                $pinjaman = Pinjaman::orderBy('anggota', 'asc')->take(10)->get();
                foreach($pinjaman as $item){
                    $maxtgl = \App\Model\Pinjaman\Pembayaran::where('id_pinjaman', $item->id)->orderBy('bulan_ke', 'desc')->first();
                    $mintgl = \App\Model\Pinjaman\Pembayaran::where('id_pinjaman', $item->id)->orderBy('bulan_ke', 'asc')->first();

                    $arr4 = array(
                        $item->anggotaid->kode, $item->anggotaid->nama, $item->anggotaid->npk, $item->pengaturanid->nama_pinjaman, $item->pengaturanid->suku_bunga."  %", $mintgl->tanggal, $maxtgl->tanggal,$item->jangka_waktu,$item->pengaturanid->sbunga->sistem, number_format($item->jumlah_pengajuan, 2,'.',','),'','','','','','','','','','','','','','','','','','','','','','','',''
                    );
                    $u = 0;
                    for ($y=9; $y<=12; $y++){
                        $tglawal = $th."-".$y."-01";
                        $tglakhir = $th."-".$y."-".date('t', mktime(0, 0, 0, $y, 1, $th));
                        $cektr = \App\Model\Pinjaman\Pembayaran::where('id_pinjaman', $item->id)->where('tanggal', '>=', $tglawal)->where('tanggal', '<=', $tglakhir)->first();

                        $a = $u++;
                        $arr4[10+($a*2)] = number_format($cektr->saldo,2,'.',',');
                        $arr4[11+($a*2)] = number_format($cektr->bunga,2,'.',',');
                    }
                    $data=[];
                    array_push($data, $arr4);
                    $sheet->fromArray($data, null, 'A3', false, false);
                }
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:D2');
                $sheet->mergeCells('E1:E2');
                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('G1:G2');

                $sheet->row(1, $arr);
                $sheet->row(2, $arr2);

                $sheet->setBorder('A1:'.$abjad.'1', 'thin');
                $sheet->setBorder('A2:'.$abjad.'2', 'thin');
                $sheet->cells('A1:'.$abjad.'1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->cells('A2:'.$abjad.'2', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setAutoSize(true);
            });
//            return redirect(url()->previous());
        })->download('xls');
    }
}
