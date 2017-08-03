<?php

namespace App\Http\Controllers\Akuntansi;

use App\Autowasdetail;
use App\Autowasheader;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Master\Anggota;
use App\Model\Master\Barang;
use App\Model\Master\Cabang;
use App\Model\Master\Katshudetail;
use App\Model\Pengaturan\Nomor;
use App\Model\Pengaturan\Profil;
use App\Model\Pos\Transaksidetail;
use App\Model\Pos\Transaksiheader;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class AutowaserdaController extends Controller
{
    public function autodebet() {
        date_default_timezone_set('Asia/Jakarta');
        $bln = date('m');
        $th = date('Y');
        $today = date('m/d/Y');

        $mod = "m";
        $header = Autowasheader::orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $id = $get->id;
        }

        $head = Autowasheader::count();
        if ($head > 0) {
            $hid = $id;
            $hea = Autowasheader::find($id);
            $bulannya = $this->tampil_bulan($hea->bulan);
            $tgl = $bulannya." ".$hea->tahun;
        } else {
            $hid = 0;
            $tgl = "";
        }
        $shu = Katshudetail::all();
//        $shu = Katshudetail::where('id_header', 3)->get();
        $auto = Autowasdetail::where('id_auto_header', $hid)->get();
        return view('Akuntansi.autodebet_waserda')->with('bln', $bln)->with('th', $th)->with('mod', $mod)
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

    public function autodebetlihat($bln, $thn) {
        $b = (int) $bln;
        $header = Autowasheader::where('bulan', $b)->where('tahun', $thn)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $hid = $get->id;
        }
        $i = 1;

        $autop = Autowasdetail::where('id_auto_header', $hid)->get();
        echo '<table id="tabauto" class="table table-bordered table-striped no-m scroll" style="height:800px; display: -moz-groupbox;">';
        echo '<thead>';
        echo '<tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">';
        echo '<th class="text-center" width="50">No.</th>';
        echo '<th class="text-center">No REF</th>';
        echo '<th class="text-center">Nama</th>';
        echo '<th class="text-center">Debet</th>';
        echo '<th class="text-center">Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="bodyauto" style="overflow-y: scroll;height: 700px;width: auto;position: absolute;">';
        foreach($autop as $tampil) {
            $tranheader = \App\Model\Pos\Transaksiheader::where('noref', $tampil->trandetailid->no_ref)->first();
            $anggota = \App\Model\Master\Anggota::where('npk', $tranheader->no_kartu)->first();

            echo '<tr style="width: 100%;display: inline-table;table-layout: fixed;">';
            echo '<td class="text-center" width="50">'.$i++.'</td>';
            echo '<td>'.$tampil->trandetailid->no_ref.'</td>';
            echo '<td>'.$anggota->nama.'</td>';
            echo '<td class="text-right">'.number_format($tampil->debet, 2, '.', ',').'</td>';
            $warna = $tampil->debet ==  "0" ? 'danger' : 'primary';
            $hasil = $tampil->debet ==  "0" ? 'GAGAL' : 'SUKSES';
            echo '<td class="text-center text-'.$warna.'">'.$hasil.'</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    public function autodebetcetak($bln, $thn) {
        $b = (int) $bln;
        $bulan = $this->tampil_bulan($b);
        $header = Autowasheader::where('bulan', $b)->where('tahun', $thn)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $id = $get->id;
        }

        $head = Autowasheader::count();
        if ($head > 0) {
            $hid = $id;
        } else {
            $hid = 0;
        }

        $autop = Autowasdetail::where('id_auto_header', $hid)->get();
        $pdf = PDF::loadView('Akuntansi.autodebet_waserda_print', ['autop' => $autop, 'bulan' => $bulan, 'thn' => $thn]);
        return $pdf->stream('AUTODEBET-Waserda.pdf');
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
        Excel::create("AUTODEBET_waserda_".$dper, function($result) use ($lastdate, $dper, $shu)
        {
            $result->sheet('SheetName', function($sheet) use ($lastdate, $shu)
            {
                $today2 = date('Y-m-d');

                $tran = Transaksiheader::where('kategori', 'belum dibayar')->where('tanggal', '<=', $lastdate)->get();
                foreach($tran as $transaksi){
                    $anggota = Anggota::where('npk', $transaksi->no_kartu)->first();
                    $trandetail = Transaksidetail::where('no_ref', $transaksi->noref)->get();

                    foreach ($trandetail as $item) {
                        $produk = Barang::where('barcode', $item->barcode)->first();
                        if ($produk->id_shu == $shu) {
                            $data = [];
                            array_push($data, array(
                                $transaksi->noref,
                                $item->id,
                                $anggota->nama,
                                $today2,
                                $item->produk,
                                $item->qty,
                                $item->harga_beli,
                                '0'
                            ));
                            $sheet->fromArray($data, null, 'A2', false, false);
                        }
                    }
                }
                $sheet->row(1, array('NO_REF', 'ID_TRAN_DETAIL', 'NAMA', 'TANGGAL', 'BARANG', 'JUMLAH', 'AUTODEBET', 'STATUS'));

                $sheet->setBorder('A1:H1', 'thin');
                $sheet->cells('A1:H1', function($cells){
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
            });

        })->store('xls', public_path());
        $nom = Nomor::where('modul', 'Master Customer')->first();
        if ($nom == null) {
            $dgt = 0;
        } else {
            $dgt = $nom->jumlah_digit;
        }
        $profil = Profil::find(1);
        $tran = Transaksiheader::where('kategori', 'belum dibayar')->where('tanggal', '<=', $lastdate)->get();
        $fp = fopen('autodebet-waserda_'.$dper.'.txt', 'w');
        $shunya = Katshudetail::where('id_header', 3)->first();
        foreach ($tran as $item) {
            $anggota = Anggota::where('npk', $item->no_kartu)->first();
            $trandetail = Transaksidetail::where('no_ref', $item->noref)->get();

            foreach ($trandetail as $value) {
                $produk = Barang::where('barcode', $value->barcode)->first();
                if ($produk->id_shu == $shu) {
                    $data = "0112" . $dper . "007" . $anggota->nomor_rekening . "" . round($value->harga_beli) . "" . $anggota->recabid->kode . "" . round($value->harga_beli) . "" . $anggota->recabid->kode . "IDRIDR" . $profil->nomor_rekening . "D007IDR00" . "   " . $produk->shuid->nama . " (" . $produk->shuid->headershu->nama . ")   KOP" . substr($anggota->kode, 0, $dgt) . " " . substr($anggota->nama, 0, 30) . "\n";
                    fwrite($fp, $data);
                }
            }
        }
        fclose($fp);
        $link = "autodebet-waserda_".$dper.".zip";

        Zipper::make('autodebet-waserda_'.$dper.'.zip')->add(['autodebet-waserda_'.$dper.'.txt', 'AUTODEBET_waserda_'.$dper.'.xls']);

        return redirect(url('akuntansi/autodebet/waserda/download/'.$link));
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
        $valauto = Autowasheader::where('bulan', $bn)->where('tahun', $request->tahun)->first();
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
                $headauto = Autowasheader::create([
                    'tanggal_proses' => $today,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'keterangan' => $ket,
                    'tanggal_awal'  => $dfrom,
                    'tanggal_akhir'  => $dto
                ]);
                foreach ($result as $value) {
                    if ($value->no_ref != "") {
                        if ($value->status == 1) {
                            $tran = Transaksidetail::find($value->id_tran_detail);
                            $tran->update(['bayarstat', 1]);

                            $z = 0;
                            $tran2 = Transaksidetail::where('no_ref', $tran->no_ref)->get();
                            $tran2count = Transaksidetail::where('no_ref', $tran->no_ref)->count();
                            foreach ($tran2 as $get) {
                                if ($get->bayarstat == 1) {
                                    $z += 1;
                                }
                            }

                            $trannya = Transaksiheader::where('noref', $tran->no_ref)->first();
                            if ($z == $tran2count) {
                                $trannya->update(['kategori', 'sudah dibayar']);
                            }

                            $cabang = Cabang::find($trannya->cabang);
                            date_default_timezone_set('Asia/Jakarta');
                            $headerjurnal = JurnalHeader::create([
                                'tipe' => "WASERDA",
                                'kode_jurnal' => $this->_generatekodejurnal(),
                                'tanggal' => date('Y-m-d H:i:s'),
                                'keterangan' => 'AUTODEBET WASERDA'
                            ]);

                            $detail = JurnalDetail::create([
                                'id_header' => $headerjurnal->id,
                                'id_akun' => $cabang->akun_piutang_wsd,
                                'debet' => $value->autodebet,
                                'kredit' => "",
                                'nominal' => $value->autodebet
                            ]);

                            $detail2 = JurnalDetail::create([
                                'id_header' => $headerjurnal->id,
                                'id_akun' => $cabang->akun_penjualan_wsd,
                                'debet' => "",
                                'kredit' => $value->autodebet,
                                'nominal' => $value->autodebet
                            ]);

                            $debet = $value->autodebet;
                        } else {
                            $debet = 0;
                        }
                        Autowasdetail::create([
                            'id_auto_header' => $headauto->id,
                            'id_transaksi_detail' => $value->id_tran_detail,
                            'status' => $value->status,
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
            unlink('foto/' . $filename);
            $mod = "mod";
            $shu = Katshudetail::all();
            $auto = Autowasdetail::where('id_auto_header', $headauto->id)->get();
            date_default_timezone_set('Asia/Jakarta');
            $today = date('m/d/Y');
            return view('akuntansi.autodebet_waserda')->with('bln', $request->bulan)->with('th', $request->tahun)->with('mod', $mod)
                ->with('auto', $auto)->with('tgl', $tgl)->with('today', $today)
                ->with('alert', $alert)->with('shu', $shu);
        } else {
            $bln = (int) $request->bulan;
            $th = $request->tahun;
            $msg = "Autodebet Waserda Gagal. Autodebet Waserda ".$this->tampil_bulan($bln)." ".$th." sudah pernah Dilakukan";
            $alert = Toastr::error($msg, $title = "Autodebet Waserda", $options = []);
            return redirect(url('akuntansi/autodebet/waserda'))->with('alert', $alert);
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
