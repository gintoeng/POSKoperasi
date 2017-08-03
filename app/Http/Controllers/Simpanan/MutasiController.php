<?php

namespace App\Http\Controllers\Simpanan;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Master\Katshudetail;
use App\Model\Pengaturan\Nomor;
use App\Model\Pengaturan\Profil;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Prosesdetail;
use App\Model\Simpanan\Prosesheader;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $datefrom = date('m/01/Y');
        $dateto = date('m/t/Y');
        $simpanan = Simpanan::all();
        return view('simpanan.mutasi_simpanan')->with('simpanan', $simpanan)
            ->with('datefrom', $datefrom)
            ->with('dateto', $dateto);
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
    public function show($id, $df, $dt)
    {
        $mutasi = Transaksi::where('id_simpanan', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', 'AKTIF')->orderBy('id','desc')->get();

        $i = 1;
       // $i = ($mutasi->currentPage() - 1) * $mutasi->perPage() + 1;
        echo '<table class="table table-bordered table-striped mg-t editable-datatable" id="table">';
        echo '<thead>';
        echo '<tr class="bg-color">';
        echo '<th class="text-center">No</th>';
        echo '<th class="text-center">No.Transaksi</th>';
        echo '<th class="text-center">Tanggal</th>';
        echo '<th class="text-center">NPK</th>';
        echo '<th class="text-center">Kode Anggota</th>';
        echo '<th class="text-center">Tipe</th>';
        echo '<th class="text-center">Info</th>';
        echo '<th class="text-right">Debet</th>';
        echo '<th class="text-right">Kredit</th>';
        echo '<th class="text-right">Saldo</th>';
        echo '<th class="text-center">Keterangan</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach($mutasi as $value) {
            echo '<tr>';
            echo '<td class="text-center">'.$i++.'</td>';
            echo '<td>'.$value->kode.'</td>';
            echo '<td class="text-center">'.$value->tanggal.'</td>';
            echo '<td>'.$value->simpananid->anggotaid->npk.'</td>';
            echo '<td>'.$value->simpananid->anggotaid->kode.'</td>';
            echo '<td>'.$value->tipe.'</td>';
            echo '<td>'.$value->info.'</td>';
            echo '<td align="right">'.number_format($value->debet, 2, '.', ',').'</td>';
            echo '<td align="right">'.number_format($value->kredit, 2, '.', ',').'</td>';
            echo '<td align="right">'.number_format($value->saldo_akhir, 2, '.', ',').'</td>';
            echo '<td>'.$value->keterangan.'</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function show2($id, $df, $dt) {
        $mutasi = Transaksi::where('id_simpanan', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->where('status', 'AKTIF')->orderBy('id','desc')->count();
        echo '<div class="pull-right" id="jml">Total data ditemukan : '.$mutasi.'</div>';
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


    public function _ceksaldo($id, $tgl) {
        $kredit = Transaksi::where('id_simpanan', $id)->where('tipe', 'SETOR')->where('tanggal', '<=', $tgl)->sum('nominal');
        $debet = Transaksi::where('id_simpanan', $id)->where('tipe', 'TARIK')->where('tanggal', '<=', $tgl)->sum('nominal');
        $trf_debet = Transaksi::where('id_simpanan', $id)->where('tipe', 'TRANSFER')->where('id_dari', '=', '')->where('tanggal', '<=', $tgl)->sum('nominal');
        $trf_kredit = Transaksi::where('id_simpanan', $id)->where('tipe', 'TRANSFER')->where('id_dari', '!=', '')->where('tanggal', '<=', $tgl)->sum('nominal');

        $saldo = $kredit + $trf_kredit - $debet - $trf_debet;

        return $saldo;
    }

    public function proses(){
        date_default_timezone_set('Asia/Jakarta');
        $bln = date('m');
        $th = date('Y');

        $mod = "m";
        $header = Prosesheader::where('autodebet', 0)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $id = $get->id;
        }

        $head = Prosesheader::where('autodebet', 0)->count();
        if ($head > 0) {
            $hid = $id;
            $hea = Prosesheader::find($id);
            $bulannya = $this->tampil_bulan($hea->bulan);
            $tgl = $bulannya." ".$hea->tahun;
        } else {
            $hid = 0;
            $tgl = "";
        }
        $proc = Prosesdetail::where('autodebet', '0')->where('id_proses_header', $hid)->get();
        return view('simpanan.proses_simpanan')->with('bln', $bln)->with('th', $th)->with('mod', $mod)
            ->with('proc', $proc)->with('tgl', $tgl);

    }

    public function postproses(Request $request) {
        $date = $request->tahun."-".$request->bulan;
        $bn = (int) $request->bulan;
        $ket = "Proses Simpanan bulan ke-".$request->bulan."tahun ".$request->tahun;
        $valproc = Prosesheader::where('autodebet', 0)->where('bulan', $bn)->where('tahun', $request->tahun)->first();
        if ($valproc == null) {

            date_default_timezone_set('Asia/Jakarta');
            $today = date('Y-m-d');
            $header = Prosesheader::create([
                'tanggal_proses' => $today,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'keterangan' => $ket,
                'autodebet' => 0
            ]);

            $jumHari = date('t', mktime(0, 0, 0, $request->bulan, 1, $request->tahun));
            $simpanan = Simpanan::where('status', 0)->get();
            foreach ($simpanan as $get) {
                $simp = Simpanan::findOrNew($get->id);
                $administrasi = $simp->pengaturanid->administrasi;

                $sistembunga = $get->pengaturanid->sistem_bunga;
                $sbunga = $get->suku_bunga;
                $pbunga = $simp->pengaturanid->persen_pajak;
                $minpajak = $simp->pengaturanid->saldo_minimum_pajak;
                $minbunga = $simp->pengaturanid->saldo_minimum_bunga;
                $akarsaldo = $simp->akumulasiid->saldo;

                if ($sistembunga == "1") {
                    $transaksi = Transaksi::where('tanggal', 'like', '%' . $date . '%')->where('id_simpanan', $get->id)->min('saldo_akhir');
                    $saldo = $transaksi;
                    $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
                } else if ($sistembunga == "2") {
                    $i = 0;
                    $t = 0;
                    $transaksi = Transaksi::where('tanggal', 'like', '%' . $date . '%')->where('id_simpanan', $get->id)->get();
                    $trcount = Transaksi::where('tanggal', 'like', '%' . $date . '%')->where('id_simpanan', $get->id)->count();
                    foreach ($transaksi as $ts) {
                        $a = $i++;
                        $b = $a + 1;

                        if ($b == $trcount) {
                            $ddt = $request->tahun . "-" . $request->bulan . "-" . $jumHari;
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
                    $saldo = $t / $jumHari;
                    $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
                } else {
                    $i = 0;
                    $y = 0;
                    $z = 0;
                    $transaksi = Transaksi::where('tanggal', 'like', '%' . $date . '%')->where('id_simpanan', $get->id)->get();
                    $trcount = Transaksi::where('tanggal', 'like', '%' . $date . '%')->where('id_simpanan', $get->id)->count();
                    foreach ($transaksi as $gg) {
                        $a = $i++;
                        $b = $a + 1;

                        if ($b == $trcount) {
                            $ddt = $request->tahun . "-" . $request->bulan . "-" . $jumHari;
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
                    $bunga = $y;
                }


                if ($akarsaldo >= $minpajak) {
                    if ($akarsaldo >= $minbunga) {
                        $kena_pajak = 1;
                        $pajak = $bunga * $pbunga / 100;
                        $dptbunga = $bunga - $pajak;
                        $bunga2 = $bunga;
                    } else {
                        $kena_pajak = 1;
                        $pajak = $bunga * $pbunga / 100;
                        $dptbunga = 0 - $pajak;
                        $bunga2 = 0;
                    }
                } else {
                    if ($akarsaldo >= $minbunga) {
                        $kena_pajak = 1;
                        $pajak = 0;
                        $dptbunga = $bunga;
                        $bunga2 = $bunga;
                    } else {
                        $kena_pajak = 0;
                        $pajak = 0;
                        $dptbunga = 0;
                        $bunga2 = 0;
                    }
                }


                Prosesdetail::create([
                    'id_proses_header' => $header->id,
                    'id_simpanan' => $simp->id,
                    'bunga' => $bunga2,
                    'pajak' => $pajak,
                    'diterima' => $dptbunga,
                    'kena_pajak' => $kena_pajak,
                    'autodebet' => "0",
                    'debet' => "0"
                ]);
                $idsim = $get->id;
                $jurnalnya = $this->_isijurnal($kena_pajak, $pajak, $bunga2, $dptbunga, $administrasi, $idsim);
                $akumulasi = Akumulasi::where('id_simpanan', $simp->id)->first();
                $asaldo = $akumulasi->saldo + $dptbunga - $administrasi;

                $ak = Akumulasi::find($akumulasi->id);
                if ($asaldo < 0) {
                    $sld = 0;
                    $gsld = $asaldo * -1;
                } else {
                    $sld = $asaldo;
                    $gsld = 0;
                }
                $ak->update([
                    'saldo' => $sld,
                    'outs' => $gsld
                ]);


            }

            $bln = (int) $request->bulan;
            $bulannya = $this->tampil_bulan($bln);
            $th = $request->tahun;
            $tgl = $bulannya." ".$th;
            $mod = "modd";
            $msg = "Proses Simpanan Berhasil";
            $alert = Toastr::success($msg, $title = "Proses Simpanan", $options = []);

            $proc = Prosesdetail::where('autodebet', '0')->where('id_proses_header', $header->id)->get();
            return view('simpanan.proses_simpanan')->with('bln', $request->bulan)->with('th', $th)->with('mod', $mod)
                ->with('proc', $proc)->with('tgl', $tgl)
                ->with('alert', $alert);
        } else {
            $bln = (int) $request->bulan;
            $th = $request->tahun;
            $msg = "Proses Simpanan Gagal. Proses Simpanan ".$this->tampil_bulan($bln)." ".$th." sudah pernah Dilakukan";
            $alert = Toastr::error($msg, $title = "Proses Simpanan", $options = []);
            return redirect(url('simpanan/proses'))->with('alert', $alert);
        }
    }

    public function proseslihat($bln, $thn) {
        $b = (int) $bln;
        $header = Prosesheader::where('bulan', $b)->where('tahun', $thn)->where('keterangan','like','%Proses Simpanan%')->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $hid = $get->id;
        }
        $i = 1;
            $proc = Prosesdetail::where('autodebet', '0')->where('id_proses_header', $hid)->get();
            echo '<table id="tabproc" class="table table-bordered table-striped no-m scroll" style="height:800px; display: -moz-groupbox;">';
            echo '<thead>';
            echo '<tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">';
            echo '<th class="text-center" width="50">No.</th>';
            echo '<th class="text-center">Simpanan</th>';
            //echo '<th class="text-center">Nama</th>';
            echo '<th class="text-center">Bunga</th>';
            echo '<th class="text-center">Pajak</th>';
            echo '<th class="text-center">Adm</th>';
            echo '<th class="text-center">Diterima</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody id="bodyproc" style="overflow-y: scroll;height: 700px;width: auto;position: absolute;">';
            foreach($proc as $tampil) {
                echo '<tr style="width: 100%;display: inline-table;table-layout: fixed;">';
                echo '<td class="text-center" width="50">'.$i++.'</td>';
                echo '<td>'.$tampil->simpananid->nomor_simpanan.'</td>';
//                echo '<td>'.$tampil->simpananid->anggotaid->nama.'</td>';
                echo '<td class="text-right">'.number_format($tampil->bunga, 2, '.', ',').'</td>';
                echo '<td class="text-right">'.number_format($tampil->pajak, 2, '.', ',').'</td>';
                echo '<td class="text-right">'.number_format($tampil->simpananid->pengaturanid->administrasi, 2, '.', ',').'</td>';
                echo '<td class="text-right">'.number_format($tampil->diterima, 2, '.', ',').'</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
    }

    public function prosescetak($bln, $thn) {
        $b = (int) $bln;
        $bulan = $this->tampil_bulan($b);
        $header = Prosesheader::where('bulan', $b)->where('tahun', $thn)->where('keterangan','like','%Proses Simpanan%')->orderBy('id', 'desc')->take(1)->get();
        $hid = 0;
        foreach($header as $get){
            $hid = $get->id;
        }
            $proc = Prosesdetail::where('autodebet', '0')->where('id_proses_header', $hid)->get();
            $pdf = PDF::loadView('simpanan.proses_simpanan_print', ['proc' => $proc, 'bulan' => $bulan, 'thn' => $thn]);
            return $pdf->stream('Proses-Simpanan.pdf');
    }

    function tampil_bulan ($x) {
        $bulan = array (1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember');
        return $bulan[$x];
    }

    public function cekproses() {
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

    public function _isijurnal($kena_pajak, $pajak, $bunga2, $dptbunga, $administrasi, $idsim) {
        $simpan = Simpanan::find($idsim);
        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "TABUNGAN",
            'kode_jurnal'   => $this->_generatekodejurnal(),
            'tanggal'   => date('Y-m-d H:i:s'),
            'keterangan'=> 'PROSES SIMPANAN'
        ]);

        $detaildbt = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $simpan->pengaturanid->akun_kas_bank,
                'debet'         => $pajak+$bunga2+$administrasi,
                'kredit'         => "",
                'nominal'         => $pajak
            ]);

        if($pajak > 0) {
//            $detaildbt = JurnalDetail::create([
//                'id_header'     => $header->id,
//                'id_akun'       => $simpan->pengaturanid->akun_kas_bank,
//                'debet'         => $pajak,
//                'kredit'         => "",
//                'nominal'         => $pajak
//            ]);

            $detailkrd = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $simpan->pengaturanid->akun_pajak,
                'debet'         => "",
                'kredit'         => $pajak,
                'nominal'         => $pajak
            ]);
        }

        if($bunga2 > 0) {
//            $detaildbt2 = JurnalDetail::create([
//                'id_header'     => $header->id,
//                'id_akun'       => $simpan->pengaturanid->akun_setoran,
//                'debet'         => $bunga2,
//                'kredit'         => "",
//                'nominal'         => $bunga2
//            ]);

            $detailkrd2 = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $simpan->pengaturanid->akun_bunga,
                'debet'         => "",
                'kredit'         => $bunga2,
                'nominal'         => $bunga2
            ]);
        }

        if ($administrasi > 0) {
//            $detaildbt3 = JurnalDetail::create([
//                'id_header' => $header->id,
//                'id_akun' => $simpan->pengaturanid->akun_kas_bank,
//                'debet' => $administrasi,
//                'kredit' => "",
//                'nominal' => $administrasi
//            ]);

            $detailkrd3 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $simpan->pengaturanid->akun_administrasi,
                'debet' => "",
                'kredit' => $administrasi,
                'nominal' => $administrasi
            ]);
        }

        $idh = $header->id;
        return  $idh;
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

    public function cetak($id, $df, $dt, $ctk)
    {
        $mutasi = Transaksi::where('id_simpanan', $id)->where('tanggal', '>=', $df)->where('tanggal', '<=', $dt)->orderBy('id','desc')->get();
        $simpanan = Simpanan::find($id);
        $pdf = PDF::loadView('simpanan.mutasi_simpanan_print', ['mutasi' => $mutasi, 'simpanan' => $simpanan, 'df' => $df, 'dt' => $dt]);

        if ($ctk == "print") {
            return $pdf->download('Mutasi-Simpanan.pdf');
        } else {
            return $pdf->stream('Mutasi-Simpanan.pdf');
        }
    }


    public function autodebet() {
        $shunya = Katshudetail::where('id_header', 1)->first();
        
        date_default_timezone_set('Asia/Jakarta');
        $bln = date('m');
        $th = date('Y');
        $today = date('m/d/Y');

        $mod = "m";
        $header = Prosesheader::where('autodebet', 1)->where('shunya', $shunya->id)->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $id = $get->id;
        }

        $head = Prosesheader::where('autodebet', 1)->count();
        if ($head > 0) {
            $hid = $id;
            $hea = Prosesheader::find($id);
            $bulannya = $this->tampil_bulan($hea->bulan);
            $tgl = $bulannya." ".$hea->tahun;
        } else {
            $hid = 0;
            $tgl = "";
        }

        $shu = Katshudetail::all();
//        $shu = Katshudetail::where('id_header', 1)->get();
        $auto = Prosesdetail::where('autodebet', '1')->where('id_proses_header', $hid)->get();
        return view('simpanan.autodebet')->with('bln', $bln)->with('th', $th)->with('mod', $mod)
            ->with('auto', $auto)->with('tgl', $tgl)->with('shu', $shu)->with('today', $today);
    }

    public function autodebetlihat($bln, $thn, $shu) {
        $b = (int) $bln;
        $header = Prosesheader::where('bulan', $b)->where('tahun', $thn)->where('shunya', $shu)->where('keterangan','like','%AUTODEBET%')->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $hid = $get->id;
        }
        $i = 1;

            $autop = Prosesdetail::where('autodebet', '1')->where('id_proses_header', $hid)->get();
            echo '<table id="tabauto" class="table table-bordered table-striped no-m scroll" style="height:800px; display: -moz-groupbox;">';
            echo '<thead>';
            echo '<tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">';
            echo '<th class="text-center" width="50">No.</th>';
            echo '<th class="text-center">Simpanan</th>';
            echo '<th class="text-center">Nama</th>';
            echo '<th class="text-center">Debet</th>';
            echo '<th class="text-center">Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody id="bodyauto" style="overflow-y: scroll;height: 700px;width: auto;position: absolute;">';
            foreach($autop as $tampil) {
                echo '<tr style="width: 100%;display: inline-table;table-layout: fixed;">';
                echo '<td class="text-center" width="50">'.$i++.'</td>';
                echo '<td>'.$tampil->simpananid->nomor_simpanan.'</td>';
                echo '<td>'.$tampil->simpananid->anggotaid->nama.'</td>';
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
        $header = Prosesheader::where('bulan', $b)->where('tahun', $thn)->where('shunya', $shu)->where('keterangan','like','%AUTODEBET%')->orderBy('id', 'desc')->take(1)->get();
        foreach($header as $get){
            $hid = $get->id;
        }

            $autop = Prosesdetail::where('autodebet', '1')->where('id_proses_header', $hid)->get();
            $pdf = PDF::loadView('simpanan.proses_simpanan_print2', ['autop' => $autop, 'bulan' => $bulan, 'thn' => $thn]);
            return $pdf->stream('AUTODEBET-Simpanan.pdf');
    }
    
    public function autodebetdownload($bln, $th, $shu, $df, $dt) {
        date_default_timezone_set('Asia/Jakarta');
        $dfrom = date("dmY", strtotime($df));
        $dto = date("dmY", strtotime($dt));
        $dper = $dfrom."-".$dto;
//        dd($dfrom."-".$dto);
        $today = $th."".$bln;
        Excel::create("AUTODEBET_simpanan_".$dper, function($result) use($shu, $dper, $dt)
        {
            $result->sheet('SheetName', function($sheet) use ($shu, $dt)
            {
                $today2 = date('Y-m-d');
                $simp = Simpanan::where('status', 0)->whereHas('pengaturanid', function ($query) use($shu) {
                    $query->where('id_shu', $shu);
                })->whereHas('anggotaid', function ($query) use($shu) {
                    $query->where('jenis_nasabah', "!=", "UMUM")->where('status', 'ANGGOTA');
                })->get();

                foreach($simp as $simpanan){
                    if ($simpanan->pengaturanid->wajibpokok == 0) {
                        $tglnya = strtotime('+'.$simpanan->jangka_waktu.' month', strtotime($simpanan->tanggal_pembuatan));
                        $tglbuat = date("Y-m-d",$tglnya);
                        if ($dt <= $tglbuat) {
                            $data = [];
                            array_push($data, array(
                                $simpanan->nomor_simpanan,
                                $simpanan->id,
                                $simpanan->anggotaid->nama,
                                $today2,
                                $simpanan->setoran_bulanan,
                                '0'
                            ));
                            $sheet->fromArray($data, null, 'A2', false, false);
                        }
                    } else if ($simpanan->pengaturanid->wajibpokok == 2) {
                        $data = [];
                        if ($simpanan->pengaturanid->pokokstat == 0) {
                            array_push($data, array(
                                $simpanan->nomor_simpanan,
                                $simpanan->id,
                                $simpanan->anggotaid->nama,
                                $today2,
                                $simpanan->setoran_bulanan,
                                '0'
                            ));
                            $sheet->fromArray($data, null, 'A2', false, false);
                        }
                    } else {
                        $data = [];
                        array_push($data, array(
                            $simpanan->nomor_simpanan,
                            $simpanan->id,
                            $simpanan->anggotaid->nama,
                            $today2,
                            $simpanan->setoran_bulanan,
                            '0'
                        ));
                        $sheet->fromArray($data, null, 'A2', false, false);
                    }
                }
                $sheet->row(1, array('NO_SIMP', 'ID_SIMP', 'NAMA', 'TANGGAL', 'AUTODEBET', 'STATUS'));

                $sheet->setBorder('A1:F1', 'thin');
                $sheet->cells('A1:F1', function($cells){
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
            });
            
        })->store('xls', public_path());
        $profil = Profil::find(1);
        $nom = Nomor::where('modul', 'Master Customer')->first();
        if ($nom == null) {
            $dgt = 0;
        } else {
            $dgt = $nom->jumlah_digit;
        }
        $simp2 = Simpanan::where('status', 0)->whereHas('pengaturanid', function ($query) use($shu) {
            $query->where('id_shu', $shu);
        })->whereHas('anggotaid', function ($query) use($shu) {
            $query->where('jenis_nasabah', "!=", "UMUM")->where('status', 'ANGGOTA');
        })->get();
        $fp = fopen('autodebet-simpanan_'.$dper.'.txt', 'w');
        foreach ($simp2 as $item) {
            $data = "0112".$dper."007".$item->anggotaid->nomor_rekening."".round($item->setoran_bulanan)."".$item->anggotaid->recabid->kode."".round($item->setoran_bulanan)."".$item->anggotaid->recabid->kode."IDRIDR".$profil->nomor_rekening."D007IDR00"."   ".$item->pengaturanid->shuid->nama." (".$item->pengaturanid->shuid->headershu->nama.")   KOP".substr($item->anggotaid->kode, 0, $dgt)." ".substr($item->anggotaid->nama, 0, 30)."\n";
            fwrite($fp, $data);
        }
        fclose($fp);
        $link = "autodebet-simpanan_".$dper.".zip";
        
        Zipper::make('autodebet-simpanan_'.$dper.'.zip')->add(['autodebet-simpanan_'.$dper.'.txt', 'AUTODEBET_simpanan_'.$dper.'.xls']);

        return redirect(url('akuntansi/autodebet/simpanan/download/'.$link));
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
        $valproc = Prosesheader::where('autodebet', 1)->where('bulan', $bn)->where('tahun', $request->tahun)->where('shunya', $request->shu)->first();
        if ($valproc == null) {
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
                $header = Prosesheader::create([
                    'tanggal_proses' => $today,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'keterangan' => $ket,
                    'autodebet' => 1,
                    'tanggal_awal'  => $dfrom,
                    'tanggal_akhir'  => $dto
                ]);
                foreach ($result as $value) {
                    if ($value->no_simp != "") {
                        $simp = Simpanan::find($value->id_simp);
                        if ($value->status == 1) {
                            $debet = $simp->setoran_bulanan;
                            $sald = $simp->akumulasiid->saldo;
                            $asaldo = $sald + $debet;

                            Transaksi::create([
                                'kode' => $this->_generate(),
                                'tipe' => "SETOR",
                                'id_simpanan' => $simp->id,
                                'id_dari' => $simp->id,
                                'saldo_awal' => $simp->akumulasiid->saldo,
                                'nominal' => $debet,
                                'saldo_akhir' => $asaldo,
                                'tanggal' => date('Y-m-d'),
                                'kredit' => $debet,
                                'debet' => "",
                                'status' => "AKTIF",
                                'keterangan' => "SETOR : " . $simp->anggotaid->nama,
                                'info' => "SETOR : " . $simp->anggotaid->nama
                            ]);

                            $akumu = Akumulasi::where('id_simpanan', $simp->id)->first();
                            $akumulasi = Akumulasi::find($akumu->id);
                            $akumulasi->update([
                                'saldo' => $asaldo
                            ]);

                            date_default_timezone_set('Asia/Jakarta');
                            $headerjurnal = JurnalHeader::create([
                                'tipe' => "TABUNGAN",
                                'kode_jurnal' => $this->_generatekodejurnal(),
                                'tanggal' => date('Y-m-d H:i:s'),
                                'keterangan' => 'AUTODEBET SIMPANAN'
                            ]);

                            $detaildbt = JurnalDetail::create([
                                'id_header' => $headerjurnal->id,
                                'id_akun' => $simp->pengaturanid->akun_kas_bank,
                                'debet' => $debet,
                                'kredit' => "",
                                'nominal' => $debet
                            ]);

                            $detailkrd = JurnalDetail::create([
                                'id_header' => $headerjurnal->id,
                                'id_akun' => $simp->pengaturanid->akun_setoran,
                                'debet' => "",
                                'kredit' => $debet,
                                'nominal' => $debet
                            ]);
                        } else {
                            $debet = 0;
                        }
                        Prosesdetail::create([
                            'id_proses_header' => $header->id,
                            'id_simpanan' => $simp->id,
                            'bunga' => 0,
                            'pajak' => 0,
                            'diterima' => 0,
                            'kena_pajak' => 0,
                            'autodebet' => "1",
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

            File::delete('foto/' . $filename);
            $bln = (int) $request->bulan;
            $bulannya = $this->tampil_bulan($bln);
            $tgl = $bulannya." ".$request->tahun;
            $mod = "mod";
            $auto = Prosesdetail::where('autodebet', '1')->where('id_proses_header', $header->id)->get();
            return view('simpanan.autodebet')->with('bln', $request->bulan)->with('th', $request->tahun)->with('mod', $mod)
                ->with('auto', $auto)->with('tgl', $tgl)
                ->with('alert', $alert);
        } else {
            $sh = Katshudetail::find($request->shu);
            $bln = (int) $request->bulan;
            $th = $request->tahun;
            $msg = "Autodebet Simpanan Gagal. Autodebet Simpanan ".$this->tampil_bulan($bln)." ".$th." dengan kategori SHU = ".$sh->nama."sudah pernah Dilakukan";
            $alert = Toastr::error($msg, $title = "Autodebet Simpanan", $options = []);
            return redirect(url('akuntansi/autodebet/simpanan'))->with('alert', $alert);
        }

    }

    public function _generate() {
        $nom = Nomor::where('modul', 'Simpanan')->first();

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

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;

    }

}
