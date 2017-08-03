<?php

namespace App\Http\Controllers\Pinjaman;

use App\Approve;
use App\Approverole;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Master\Katshudetail;
use App\Model\Pengaturan\Nomor;
use App\Model\Pengaturan\Profil;
use App\Model\Pinjaman\Autodetail;
use App\Model\Pinjaman\Autoheader;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pinjaman;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class AutoController extends Controller
{
    public function autodebet() {
        $shunya = Katshudetail::where('id_header', 2)->first();

        date_default_timezone_set('Asia/Jakarta');
        $bln = date('m');
        $th = date('Y');
        $today = date('m/d/Y');

        $mod = "m";
        $header = Autoheader::where('shunya', $shunya->id)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $id = $get->id;
        }

        $head = Autoheader::where('shunya', $shunya->id)->count();
        if ($head > 0) {
            $hid = $id;
            $hea = Autoheader::find($id);
            $bulannya = $this->tampil_bulan($hea->bulan);
            $tgl = $bulannya." ".$hea->tahun;
        } else {
            $hid = 0;
            $tgl = "";
        }
        $shu = Katshudetail::all();
//        $shu = Katshudetail::where('id_header', 2)->get();
        $auto = Autodetail::where('id_auto_header', $hid)->get();
        return view('pinjaman.autodebet')->with('bln', $bln)->with('th', $th)->with('mod', $mod)
            ->with('auto', $auto)->with('tgl', $tgl)->with('shu', $shu)->with('today', $today);
    }

    public function cekautodebet() {
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

        if($nom2 == null){
            $stat = "FAIL";
            $title = "Format Nomor Jurnal Otomatis";
            $psg = "Format nomor untuk Jurnal Otomatis belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
        } else {
            $stat = "OK";
            $title = "";
            $psg = "";
        }

        $data[] = array(
            'stat' => $stat,
            'title' => $title,
            'psg'   => $psg
        );
        return json_encode($data);
    }

    public function autodebetlihat($bln, $thn, $shu) {
        $b = (int) $bln;
        $header = Autoheader::where('bulan', $b)->where('tahun', $thn)->where('shunya', $shu)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $hid = $get->id;
        }
        $i = 1;

        $autop = Autodetail::where('id_auto_header', $hid)->get();
        echo '<table id="tabauto" class="table table-bordered table-striped no-m scroll" style="height:800px; display: -moz-groupbox;">';
        echo '<thead>';
        echo '<tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">';
        echo '<th class="text-center" width="50">No.</th>';
        echo '<th class="text-center">Pinjaman</th>';
        echo '<th class="text-center">Nama</th>';
        echo '<th class="text-center">Debet</th>';
        echo '<th class="text-center">Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="bodyauto" style="overflow-y: scroll;height: 700px;width: auto;position: absolute;">';
        foreach($autop as $tampil) {
            echo '<tr style="width: 100%;display: inline-table;table-layout: fixed;">';
            echo '<td class="text-center" width="50">'.$i++.'</td>';
            echo '<td>'.$tampil->pinjamanid->nomor_pinjaman.'</td>';
            echo '<td>'.$tampil->pinjamanid->anggotaid->nama.'</td>';
            echo '<td class="text-right">'.number_format($tampil->debet, 2, '.', ',').'</td>';
            $warna = $tampil->debet ==  "0" ? 'danger' : 'primary';
            $hasil = $tampil->debet ==  "0" ? 'GAGAL' : 'SUKSES';
            echo '<td class="text-center text-'.$warna.'">'.$hasil.'</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    public function autodebetcetak($bln, $thn, $shu) {
        $b = (int) $bln;
        $bulan = $this->tampil_bulan($b);
        $header = Autoheader::where('bulan', $b)->where('tahun', $thn)->where('shunya', $shu)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $id = $get->id;
        }

        $head = Autoheader::count();
        if ($head > 0) {
            $hid = $id;
        } else {
            $hid = 0;
        }

        $autop = Autodetail::where('id_auto_header', $hid)->get();
        $pdf = PDF::loadView('pinjaman.autodebet_print', ['autop' => $autop, 'bulan' => $bulan, 'thn' => $thn]);
        return $pdf->stream('AUTODEBET-Pinjaman.pdf');
    }

    public function autodebetdownload($bln, $th, $shu, $df, $dt) {
        date_default_timezone_set('Asia/Jakarta');
        $dfrom = date("dmY", strtotime($df));
        $dto = date("dmY", strtotime($dt));
        $dper = $dfrom."-".$dto;
        $today = $th."".$bln;
        $jumHari = date('t', mktime(0, 0, 0, $bln, 1, $th));
//        $lastdate = $th."-".$bln."-".$jumHari;
        $lastdate = $dt;
        Excel::create("AUTODEBET_pinjaman_".$dper, function($result) use ($lastdate, $shu, $dper)
        {
            $result->sheet('SheetName', function($sheet) use ($lastdate, $shu)
            {
                $today2 = date('Y-m-d');
                $pembayaran = Pembayaran::where('cara_bayar', 'AUTODEBET')->where('tanggal', '<=', $lastdate)->where('start', '0')->whereHas('pinjamanid', function ($query) use($shu) {
                    $query->whereHas('pengaturanid', function ($querys) use($shu) {
                        $querys->where('id_shu', $shu);
                    });
                })->get();

                foreach($pembayaran as $bayar){
                    $data = [];
                    $approve = Approve::where('for', 'pinjaman')->where('id_for', $bayar->id_pinjaman)->first();
//                    if ($approve->lev1 > 0) {
//                        if ($approve->lev2 > 0) {
//                            if ($approve->lev3 > 0) {
//                                if ($approve->release > 0) {
//                                    $ref = "OK";
//                                } else {
//                                    $ref = "FAIL";
//                                }
//                            } else {
//                                $ref = "FAIL";
//                            }
//                        } else {
//                            $ref = "FAIL";
//                        }
//                    } else {
//                        $ref = "FAIL";
//                    }
                    if ($bayar->pinjamanid->approved == 0) {
                        $ref = "FAIL";
                    } else {
                        $ref = "OK";
                    }

                    if ($ref == "OK") {
                        $idb = $bayar->id;
                        $total = $this->__totalbayar($idb, $lastdate);
                        $bunga = $this->__bungabayar($idb, $lastdate);
                        $denda = $this->__dendabayar($idb, $lastdate);

                        array_push($data, array(
                            $bayar->pinjamanid->nomor_pinjaman,
                            $bayar->id_pinjaman,
                            $bayar->id,
                            $bayar->pinjamanid->anggotaid->nama,
                            $lastdate,
                            $bayar->pokok,
                            $bunga,
                            $denda,
                            $total,
                            '0'
                        ));
                    }
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('NO_PINJ', 'ID_PINJ', 'ID_BAYAR', 'NAMA', 'TANGGAL', 'POKOK', 'BUNGA', 'DENDA', 'AUTODEBET', 'STATUS'));

                $sheet->setBorder('A1:J1', 'thin');
                $sheet->cells('A1:J1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setWidth('A', '20');
                $sheet->setWidth('B', '20');
                $sheet->setWidth('C', '20');
                $sheet->setWidth('D', '10');
                $sheet->setWidth('E', '10');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '10');
                $sheet->setWidth('H', '10');
                $sheet->setWidth('I', '10');
                $sheet->setWidth('J', '10');
            });

        })->store('xls', public_path());
        $nom = Nomor::where('modul', 'Master Customer')->first();
        if ($nom == null) {
            $dgt = 0;
        } else {
            $dgt = $nom->jumlah_digit;
        }
        $profil = Profil::find(1);
        $pembayaran2 = Pembayaran::where('cara_bayar', 'AUTODEBET')->where('tanggal', '<=', $lastdate)->where('start', '0')->whereHas('pinjamanid', function ($query) use($shu) {
            $query->whereHas('pengaturanid', function ($querys) use($shu) {
                $querys->where('id_shu', $shu);
            });
        })->get();
        $fp = fopen('autodebet-pinjaman_'.$dper.'.txt', 'w');
        foreach ($pembayaran2 as $item) {
            $approve = Approve::where('for', 'pinjaman')->where('id_for', $item->id_pinjaman)->first();
//            if ($approve->lev1 > 0) {
//                if ($approve->lev2 > 0) {
//                    if ($approve->lev3 > 0) {
//                        if ($approve->release > 0) {
//                            $ref = "OK";
//                        } else {
//                            $ref = "FAIL";
//                        }
//                    } else {
//                        $ref = "FAIL";
//                    }
//                } else {
//                    $ref = "FAIL";
//                }
//            } else {
//                $ref = "FAIL";
//            }

            if ($item->pinjamanid->approved == 0) {
                $ref = "FAIL";
            } else {
                $ref = "OK";
            }

            if ($ref == "OK") {
                $idb = $item->id;
                $total = $this->__totalbayar($idb, $lastdate);

                $data = "0112" . $dper . "007" . $item->pinjamanid->anggotaid->nomor_rekening . "" . round($total) . "" . $item->pinjamanid->anggotaid->recabid->kode . "" . round($total) . "" . $item->pinjamanid->anggotaid->recabid->kode . "IDRIDR" . $profil->nomor_rekening . "D007IDR00" . "   " . $item->pinjamanid->pengaturanid->shuid->nama . " (" . $item->pinjamanid->pengaturanid->shuid->headershu->nama . ")   KOP" . substr($item->pinjamanid->anggotaid->kode, 0, $dgt) . " " . substr($item->pinjamanid->anggotaid->nama, 0, 30) . "\n";
                fwrite($fp, $data);
            }
        }
        fclose($fp);
        $link = "autodebet-pinjaman_".$dper.".zip";

        Zipper::make('autodebet-pinjaman_'.$dper.'.zip')->add(['autodebet-pinjaman_'.$dper.'.txt', 'AUTODEBET_pinjaman_'.$dper.'.xls']);

        return redirect(url('akuntansi/autodebet/pinjaman/download/'.$link));
    }

    public function __bungabayar($idb, $lastdate) {
        $bayar = Pembayaran::find($idb);

        $bayarlast = Pembayaran::where('id_pinjaman', $bayar->id_pinjaman)->where('bulan_ke', $bayar->bulan_ke - 1)->first();

        if ($bayar->pinjamanid->perhitungan_bunga == "bulanan") {
            $bunganya = $bayar->bunga;
        } else {
            $hari2 = ((abs(strtotime ($lastdate) - strtotime ($bayarlast->tanggal)))/(60*60*24));
            $hari3 = ((abs(strtotime ($bayar->tanggal) - strtotime ($bayarlast->tanggal)))/(60*60*24));
            $bunganya = $bayar->bunga / $hari3 * $hari2;
        }

        return $bunganya;
    }

    public function __dendabayar($idb, $lastdate) {
        $bayar = Pembayaran::find($idb);

        $bayarlast = Pembayaran::where('id_pinjaman', $bayar->id_pinjaman)->where('bulan_ke', $bayar->bulan_ke - 1)->first();

        $toldenda = $bayar->pinjamanid->pengaturanid->toleransi_denda;
        $mindenda = strtotime('+'.$toldenda.' day', strtotime($bayar->tanggal));// jangka waktu + 365 hari
        $tgldenda=date("Y-m-d",$mindenda);//tanggal expired

        if ($lastdate > $tgldenda) {
            $hari = ((abs(strtotime ($lastdate) - strtotime ($tgldenda)))/(60*60*24));
            if ($bayar->pinjamanid->pengaturanid->tipe_denda_perhari == "denda_nominal") {
                $dendanya = $bayar->pinjamanid->pengaturanid->jumlah_denda_perhari * $hari;
            } else if ($bayar->pinjamanid->pengaturanid->tipe_denda_perhari == "saldo_X_persen%_X_hari") {
                $dendanya = $bayarlast->saldo * $bayar->pinjamanid->pengaturanid->persen_denda_perhari/100 * $hari;
            } else if ($bayar->pinjamanid->pengaturanid->tipe_denda_perhari == "angsuran_X_persen%_X_hari") {
                $dendanya = $bayar->pokok * $bayar->pinjamanid->pengaturanid->persen_denda_perhari/100 * $hari;
            }
        } else {
            $hari = 0;
            $dendanya = 0;
        }

        return $dendanya;
    }

    public function __totalbayar($idb, $lastdate) {
        $bayar = Pembayaran::find($idb);
        $bunganya = $this->__bungabayar($idb, $lastdate);
        $dendanya = $this->__dendabayar($idb, $lastdate);
        $total = $bayar->pokok + $bunganya + $dendanya;

        return $total;
    }

    public function download($link) {
        return response()->download(public_path($link));
    }

    public function autodebetupload(Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $dfrom = date("Y-m-d", strtotime($request->dari));
        $dto = date("Y-m-d", strtotime($request->ke)); 
        
        $ket = "AUTODEBET bulan ke-".$request->bulan."tahun ".$request->tahun;
        $bn = (int) $request->bulan;
        $valauto = Autoheader::where('bulan', $bn)->where('tahun', $request->tahun)->first();
        if ($valauto == null) {

            if ($request->hasFile('excelauto')) {
                $file = $request->excelauto;
                $filename = $file->getClientOriginalName();

                $destinationPath = 'foto/';
                $file->move($destinationPath, $filename);

            }

            $xls = explode(".", $filename);

            if ($xls[1] == "xls" || $xls[1] == "csv") {

                $result = Excel::load('public/foto/' . $filename)->get();
                date_default_timezone_set('Asia/Jakarta');
                $today = date('Y-m-d');
                $headauto = Autoheader::create([
                    'tanggal_proses' => $today,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'keterangan' => $ket,
                    'tanggal_awal'  => $dfrom,
                    'tanggal_akhir'  => $dto
                ]);
                foreach ($result as $value) {
                    if ($value->no_pinj != "") {

                        $pembayaran = Pembayaran::find($value->id_bayar);

                        $pinj = Pinjaman::find($value->id_pinj);
                        if ($value->status == 1) {

                            $bayar = Pembayaran::find($value->id_bayar);
                            $bayar->update(['autodebet' => '1', 'start' => '1', 'bunga' => $value->bunga, 'denda' => $value->denda, 'total' => $value->autodebet]);

                            $debet = $pembayaran->total;
                            $status = "1";

                            $btotal = $value->autodebet;
                            $bpokok = $value->pokok;
                            $bbunga = $value->bunga;
                            $bdenda = $value->denda;

                            $header = JurnalHeader::create([
                                'tipe' => "KREDIT",
                                'kode_jurnal' => $this->_generatekodejurnal(),
                                'tanggal' => date('Y-m-d H:i:s'),
                                'keterangan' => 'BYR'
                            ]);

                            $detail = JurnalDetail::create([
                                'id_header' => $header->id,
                                'id_akun' => $pinj->pengaturanid->akun_kas_bank,
                                'debet' => $btotal,
                                'kredit' => "",
                                'nominal' => $btotal
                            ]);

                            $detail2 = JurnalDetail::create([
                                'id_header' => $header->id,
                                'id_akun' => $pinj->pengaturanid->akun_angsuran,
                                'debet' => "",
                                'kredit' => $bpokok,
                                'nominal' => $bpokok
                            ]);


                            $detail3 = JurnalDetail::create([
                                'id_header' => $header->id,
                                'id_akun' => $pinj->pengaturanid->akun_bunga,
                                'debet' => "",
                                'kredit' => $bbunga,
                                'nominal' => $bbunga
                            ]);

                            if ($bdenda != 0) {
                                $detail4 = JurnalDetail::create([
                                    'id_header' => $header->id,
                                    'id_akun' => $pinj->pengaturanid->akun_denda,
                                    'debet' => "",
                                    'kredit' => $bdenda,
                                    'nominal' => $bdenda
                                ]);
                            }

                            $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();
                            $format = Nomor::find($nom->id);
                            $format->update(['nomor_now' => $nom->nomor_now + 1]);

                        } else {
                            $debet = 0;
                            $status = "0";

                            $bayar = Pembayaran::find($value->id_bayar);
                            $bayar->update(['autodebet' => '0', 'start' => '0']);
                        }
                        Autodetail::create([
                            'id_auto_header' => $headauto->id,
                            'id_pinjaman' => $value->id_pinj,
                            'id_bayar' => $value->id_bayar,
                            'status' => $status,
                            'debet' => $debet
                        ]);
                    }
                }
                $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : " . count($result);
                $alert = Toastr::success($msg, $title = "Autodebet", $options = []);
            } else {
                $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
                $alert = Toastr::error($msg, $title = "Autodebet", $options = []);
            }

            $bln = (int) $request->bulan;
            $bulannya = $this->tampil_bulan($bln);
            $th = $request->tahun;
            $tgl = $bulannya." ".$th;
            File::delete('foto/' . $filename);
            $mod = "mod";
            $auto = Autodetail::where('id_auto_header', $headauto->id)->get();
            return view('pinjaman.autodebet')->with('bln', $request->bulan)->with('th', $request->tahun)->with('mod', $mod)
                ->with('auto', $auto)->with('tgl', $tgl)
                ->with('alert', $alert);
        } else {
            $bln = (int) $request->bulan;
            $th = $request->tahun;
            $msg = "Autodebet Pinjaman Gagal. Autodebet Pinjaman ".$this->tampil_bulan($bln)." ".$th." sudah pernah Dilakukan";
            $alert = Toastr::error($msg, $title = "Autodebet Pinjaman", $options = []);
            return redirect(url('akuntansi/autodebet/pinjaman'))->with('alert', $alert);
        }

    }

    function tampil_bulan ($x) {
        $bulan = array (1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember');
        return $bulan[$x];
    }

    public function _generatekodejurnal() {
        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();

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
        $kode = "SIMP".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
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
    
    public function cekshu($shu) {
        $shunya = Katshudetail::find($shu);

        $data[] = array(
            'shuname' => $shunya->nama
        );

        return json_encode($data);
    }
}
