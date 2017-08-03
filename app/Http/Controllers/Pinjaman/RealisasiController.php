<?php

namespace App\Http\Controllers\Pinjaman;

use App\Approve;
use App\Approverole;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Pengaturan\Nomor;
use App\Model\Pinjaman\Jaminan;
use App\Model\Pinjaman\Jaminanbangunan;
use App\Model\Pinjaman\Jaminanelektronik;
use App\Model\Pinjaman\Jaminanemas;
use App\Model\Pinjaman\Jaminankendaraan;
use App\Model\Pinjaman\Jaminansimpanan;
use App\Model\Pinjaman\Jaminantanpa;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Pinjaman\Realisasi;
use App\Model\Sistembunga;
use Illuminate\Http\Request;

 use DB;
 use Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class RealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now()->format('m/d/Y');
        $sistem_bunga = DB::table('sistem_bunga')->where('untuk', 'pinjaman')->get();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $pinjaman = Pinjaman::where('status_realisasi', 'N')->whereHas('anggotaid', function($query) {
            $query->where('status', 'AKTIF');
        })->get();
        return view('pinjaman.realisasi_pinjaman')->with('pinjaman', $pinjaman)
            ->with('today', $today)
            ->with('perkiraan', $perkiraan)
            ->with('sistem_bunga', $sistem_bunga);
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

    public function cekmodul() {
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
        $kode = "REAPINJ".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

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

    public function _isijurnal($real, $biayaa,$biayaab,$biayaat, $biayap, $biayal, $uangd,  $idp){
        $pinj = Pinjaman::find($idp);
        if ($pinj->re == 2) {

        }

        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "KREDIT",
            'kode_jurnal'   => $this->_generatekodejurnal(),
            'tanggal'   => date('Y-m-d H:i:s'),
            'keterangan'=> 'REALISASI'
        ]);

        if($real != "0") {
            if ($pinj->pengaturanid->tipe_pinjaman == "uang") {
                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $pinj->pengaturanid->akun_realisasi,
                    'debet' => $real,
                    'kredit' => "",
                    'nominal' => $real
                ]);
            } else {
                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $pinj->pengaturanid->akun_realisasi,
                    'debet' => $pinj->jumlah_pengajuan,
                    'kredit' => "",
                    'nominal' => $pinj->jumlah_pengajuan
                ]);
            }
        }

        if($biayaa != "0") {
            $detail2 = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $pinj->pengaturanid->akun_administrasi,
                'debet'         => "",
                'kredit'         => $biayaa,
                'nominal'         => $biayaa
            ]);
        }
        if($biayaab != "0") {
            $detail6 = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $pinj->pengaturanid->akun_administrasi_bank,
                'debet'         => "",
                'kredit'         => $biayaab,
                'nominal'         => $biayaab
            ]);
        }
        if($biayaat != "0") {
            $detail7 = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $pinj->pengaturanid->akun_administrasi_tambahan,
                'debet'         => "",
                'kredit'         => $biayaat,
                'nominal'         => $biayaat
            ]);
        }

        if($biayap != "0") {
            $detail3 = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $pinj->pengaturanid->biaya_provinsi,
                'debet'         => "",
                'kredit'         => $biayap,
                'nominal'         => $biayap
            ]);
        }

        if($biayal != "0") {
            $detail4 = JurnalDetail::create([
                'id_header'     => $header->id,
                'id_akun'       => $pinj->pengaturanid->akun_lain_lain,
                'debet'         => "",
                'kredit'         => $biayal,
                'nominal'         => $biayal
            ]);
        }

        if ($pinj->pengaturanid->tipe_pinjaman == "uang") {
            $detail5 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $pinj->pengaturanid->akun_kas_bank,
                'debet' => "",
                'kredit' => $uangd,
                'nominal' => $uangd
            ]);
        } else {
            $detail5 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $pinj->pengaturanid->akun_kas_bank,
                'debet' => "",
                'kredit' => $real,
                'nominal' => $real
            ]);
        }

        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);
        
        return "OK";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->tanggal_realisasi == "") {
            $tglreal = "00/00/0000";
        } else {
            $tglreal = $request->tanggal_realisasi;
        }
        $treal = explode('/', $tglreal);

        $realisasi = str_replace(",","",$request->realisasi);
        $real = str_replace(".00","",$realisasi);

        $uangditerima = str_replace(",","",$request->uang_diterima);
        $uangd = str_replace(".00","",$uangditerima);

        $administrasi = str_replace(",","",$request->biaya_administrasi);
        $biayaa = str_replace(".00","",$administrasi);
        $administrasibank = str_replace(",","",$request->biaya_administrasi_bank);
        $biayaab = str_replace(".00","",$administrasibank);
        $administrasitambahan = str_replace(",","",$request->biaya_administrasi_tambahan);
        $biayaat = str_replace(".00","",$administrasitambahan);

        $provisi = str_replace(",","",$request->biaya_provinsi);
        $biayap = str_replace(".00","",$provisi);

        $lain = str_replace(",","",$request->biaya_lain);
        $biayal = str_replace(".00","",$lain);

        $angsuran = str_replace(",","",$request->angsuran);
        $angsur = str_replace(".00","",$angsuran);

        Realisasi::create([
            'id_pinjaman'        => $request->nomor_pinjaman,
            'tanggal_realisasi'  => $treal[2] . '-' . $treal[0] . '-' . $treal[1],
            'jangka_waktu'       => $request->jangka_waktu,
            'suku_bunga'        => $request->suku_bunga,
            'biaya_administrasi' => $biayaa,
            'biaya_administrasi_bank' => $biayaab,
            'biaya_administrasi_tambahan' => $biayaat,
            'biaya_provinsi'     => $biayap,
            'biaya_lain'         => $biayal,
            'realisasi'          => $real,
            'uang_diterima'      => $uangd,
            'angsuran'           => $angsur
        ]);

        $pinjaman = Pinjaman::find($request->nomor_pinjaman);
        $pinjaman->update([
            'jangka_waktu'       => $request->jangka_waktu,
            'status_realisasi' => "Y"
        ]);

        $levv1 = \App\Approverole::where('for', 'pinjaman')->where('id_for', $pinjaman->nama_pinjaman)->where('level', '1')->first();
        if ($levv1 == null) {
            $lev1 = 2;
        } else {
            $lev1 = 0;
        }

        $levv2 = \App\Approverole::where('for', 'pinjaman')->where('id_for', $pinjaman->nama_pinjaman)->where('level', '2')->first();
        if ($levv2 == null) {
            $lev2 = 2;
        } else {
            $lev2 = 0;
        }

        $levv3 = \App\Approverole::where('for', 'pinjaman')->where('id_for', $pinjaman->nama_pinjaman)->where('level', '3')->first();
        if ($levv3 == null) {
            $lev3 = 2;
        } else {
            $lev3 = 0;
        }

        $rell = \App\Approverole::where('for', 'pinjaman')->where('id_for', $pinjaman->nama_pinjaman)->where('level', '4')->first();
        if ($rell == null) {
            $rel = 2;
        } else {
            $rel = 0;
        }

        Approve::create([
            'id_for' => $pinjaman->id,
            'for'   => "pinjaman",
            'lev1'  => $lev1,
            'lev2'  => $lev2,
            'lev3'  => $lev3,
            'release'  => $rel
        ]);

        $idp = $request->nomor_pinjaman;
        $sistem = $request->sisbungaid;
        $jpengajuan = $real;
        $jwaktu = $request->jangka_waktu;
        $sbunga = $request->suku_bunga;

        $this->_bayar($idp, $sistem, $jpengajuan, $sbunga, $jwaktu);
        $cekapprole = Approverole::where('for', 'pinjaman')->where('id_for', $pinjaman->nama_pinjaman)->first();
        if ($cekapprole == null) {
             $this->_isijurnal($real, $biayaa,$biayaab,$biayaat, $biayap, $biayal, $uangd,  $idp);
            $pinj = Pinjaman::find($request->nomor_pinjaman);
            $pinj->update(['approved' => 1]);
        }

        $msg = "Realisasi Berhasil";
        $alert = Toastr::success($msg, $title = "Realisasi Pinjaman", $options = []);
        return redirect(url('pinjaman/realisasi'))->with('alert', $alert);
    }

    public function _bayar($idp, $sistem, $jpengajuan, $sbunga, $jwaktu){
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now()->format('Y-m-d');
        $sistem_bunga = Sistembunga::findOrNew($sistem);
        if ($sistem_bunga->sistem=='Bunga Tetap') {
            $pokok = $jpengajuan/$jwaktu;
            $bunga = $jpengajuan/$jwaktu*$sbunga/100/12;
            $angsuran = $pokok+$bunga;
            $no = 0;

            for ($i = 0; $i <= $jwaktu; $i++) {
                if ($no==0) {
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $no++,
                        'tipe'          => "REA",
                        'tanggal'       => $today,
                        'tanggal_bayar'       => $today,
                        'saldo'         => $jpengajuan,
                        'pokok'         => '0',
                        'bunga'         => '0',
                        'total'         => '0',
                        'start'         => '1',
                        'keterangan'    => "Realisasi Pinjaman"
                    ];
                }

                else {
                    $z = $no++;
                    $tglnya = strtotime('+'.$z.' month', strtotime($today));
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $z,
                        'tipe'          => "BYR",
                        'tanggal'       => date("Y-m-d",$tglnya),
                        'saldo'         => $jpengajuan-=$pokok,
                        'pokok'         => $pokok,
                        'bunga'         => $bunga,
                        'total'         => $angsuran,
                        'start'         => '0',
                        'cara_bayar'    => 'AUTODEBET',
                        'keterangan'    => ""
                    ];
                }
                Pembayaran::create($data);
            }
        }

        elseif ($sistem_bunga->sistem=='Bunga Efektif / Sliding Data') {
            $pokok = $jpengajuan/$jwaktu;
            $bunga = $jpengajuan*$sbunga/100/12;
            $bunga2 = $bunga/$jwaktu;
            $angsuran = $pokok+$bunga;
            $no = 0;

            for ($i=0; $i <= $jwaktu; $i++) {
                if ($no==0) {
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $no++,
                        'tipe'          => "REA",
                        'tanggal'       => $today,
                        'saldo'         => $jpengajuan,
                        'pokok'         => '0',
                        'bunga'         => '0',
                        'total'         => '0',
                        'start'         => '1',
                        'keterangan'    => "Realisasi Pinjaman"
                    ];
                }

                elseif ($no==1) {
                    $z = $no++;
                    $tglnya = strtotime('+'.$z.' month', strtotime($today));
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $z,
                        'tipe'          => "BYR",
                        'tanggal'       => date("Y-m-d",$tglnya),
                        'saldo'         => $jpengajuan-=$pokok,
                        'pokok'         => $pokok,
                        'bunga'         => $bunga,
                        'total'         => $angsuran,
                        'start'         => '0',
                        'cara_bayar'    => 'AUTODEBET',
                        'keterangan'    => ""
                    ];
                }

                else {
                    $z = $no++;
                    $tglnya = strtotime('+'.$z.' month', strtotime($today));
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $z,
                        'tipe'          => "BYR",
                        'tanggal'       => date("Y-m-d",$tglnya),
                        'saldo'         => $jpengajuan-=$pokok,
                        'pokok'         => $pokok,
                        'bunga'         => $bunga-=$bunga2,
                        'total'         => $angsuran-=$bunga2,
                        'start'         => '0',
                        'cara_bayar'    => 'AUTODEBET',
                        'keterangan'    => ""
                    ];
                }
                Pembayaran::create($data);
            }
        }

        elseif ($sistem_bunga->sistem=='Bunga Menurun / Anuitas') {
            $no = 0;

            $angsuran = $jpengajuan*$sbunga/100/12/(1-1/(pow(1+($sbunga/100/12),$jwaktu)));
            $bunga = $jpengajuan*$sbunga/100/12;
            $pokok = $angsuran-$bunga;
            // Other variable
            $pokok_pinjaman = $jpengajuan-$pokok;
            $dummy_bunga = $pokok_pinjaman*$sbunga/100/12;
            $dummy_pokok = $angsuran-$dummy_bunga;

            for ($i=0; $i <= $jwaktu; $i++) {
                if ($no==0) {
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $no++,
                        'tipe'          => "REA",
                        'tanggal'       => $today,
                        'saldo'         => $jpengajuan,
                        'pokok'         => '0',
                        'bunga'         => '0',
                        'total'         => '0',
                        'start'         => '1',
                        'keterangan'    => "Realisasi Pinjaman"
                    ];
                }

                elseif ($no==1) {
                    $z = $no++;
                    $tglnya = strtotime('+'.$z.' month', strtotime($today));
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $z,
                        'tipe'          => "BYR",
                        'tanggal'       => date("Y-m-d",$tglnya),
                        'saldo'         => $pokok_pinjaman,
                        'pokok'         => $pokok,
                        'bunga'         => $bunga,
                        'total'         => $angsuran,
                        'start'         => '0',
                        'cara_bayar'    => 'AUTODEBET',
                        'keterangan'    => ""
                    ];

                    $ppi = $pokok_pinjaman;
                }

                else {
                    $z = $no++;
                    $tglnya = strtotime('+'.$z.' month', strtotime($today));
                    $dummy_bunga2 = $ppi*$sbunga/100/12;
                    $dummy_pokok2 = $angsuran-$dummy_bunga2;
                    $data = [
                        'id_pinjaman'   => $idp,
                        'bulan_ke'      => $z,
                        'tipe'          => "BYR",
                        'tanggal'       => date("Y-m-d",$tglnya),
                        'saldo'         => $pokok_pinjaman-=$dummy_pokok2,
                        'pokok'         => $dummy_pokok2,
                        'bunga'         => $dummy_bunga2,
                        'total'         => $angsuran,
                        'start'         => '0',
                        'cara_bayar'    => 'AUTODEBET',
                        'keterangan'    => ""
                    ];
                    $ppi = $pokok_pinjaman;
                }
                Pembayaran::create($data);
            }
        }
        return "OK";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now()->format('m/d/Y');
        $sistem_bunga = DB::table('sistem_bunga')->where('untuk', 'pinjaman')->get();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();

        $pinjaman = Pinjaman::where('status_realisasi', 'N')->get();
        $pinj = Pinjaman::find($id);

        return view('pinjaman.realisasi_pinjaman2')->with('pinjaman', $pinjaman)->with('pinj', $pinj)->with('today', $today)
            ->with('perkiraan', $perkiraan)
            ->with('sistem_bunga', $sistem_bunga);
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


    public function realisasiajax($id) {
        $pinjaman = Pinjaman::findOrNew($id);

        if ($pinjaman->pengaturanid->tipe_maksimum_waktu == "bulan") {
            $persen = $pinjaman->jumlah_pengajuan * ($pinjaman->suku_bunga / 100 / 12);
        } else {
            $persen = $pinjaman->jumlah_pengajuan * ($pinjaman->suku_bunga / 100 / 365);
        }

//        if($pinjaman->pengaturanid->sistem_bunga == 4) {
//            $angsur = ($pinjaman->jumlah_pengajuan / $pinjaman->jangka_waktu) + $persen;
//        }else if($pinjaman->pengaturanid->sistem_bunga == 5) {
//            $angsur = ($pinjaman->jumlah_pengajuan / $pinjaman->jangka_waktu);
//        }else {
//            $angsur = $pinjaman->jumlah_pengajuan*$pinjaman->suku_bunga/100/12/(1-1/(pow(1+($pinjaman->suku_bunga/100/12),$pinjaman->jangka_waktu)));
//        }
        $harga = $pinjaman->jumlah_pengajuan;
        $adminbank = $pinjaman->pengaturanid->biaya_admin_bank;
        $adminfee = $pinjaman->pengaturanid->biaya_admin_fee;
        $admintambahan = $pinjaman->pengaturanid->biaya_admin_tambahan;

        $adminnya = $harga * $adminfee / 100;
        if ($adminnya < 5000) {
            $badminnya = 5000;
        } else {
            $badminnya = $adminnya;
        }

        if ($pinjaman->pengaturanid->tipe_pinjaman == "barang") {
            if ($pinjaman->jangka_waktu == 1) {
                $badmin = $badminnya + $adminbank;
            } else if ($pinjaman->jangka_waktu == 2 || $pinjaman->jangka_waktu == 3) {
                $badmin = $badminnya + ($harga * $admintambahan / 100) + $adminbank;
            } else {
                $badmin = $badminnya + $adminbank;
            }
            $ureal = $harga + $badmin;
            $uditerima = $harga;
        } else {
            $badmin = $badminnya;

            $ureal = $harga;
            $uditerima = $harga - ($badmin  + $adminbank);
        }

        $angsur = ($ureal / $pinjaman->jangka_waktu);

        $data[] = array(
            'id'        => $pinjaman->id,
            'jenis'     => $pinjaman->pengaturanid->nama_pinjaman,
            'nama'      => $pinjaman->anggotaid->nama,
            'alamat'    => $pinjaman->anggotaid->alamat.", ".$pinjaman->anggotaid->kota.", ".$pinjaman->anggotaid->provinsi,
            'jml'       => number_format($pinjaman->jumlah_pengajuan, 2, '.', ','),
            'tgl'       => $pinjaman->tanggal_pengajuan,
            'tempo'     => $pinjaman->jatuh_tempo,
            'realisasi' => number_format($ureal, 2, '.', ','),
            'diterima'  => number_format($uditerima, 2, '.', ','),
            'bunga'     => $pinjaman->suku_bunga,
            'waktu'     => $pinjaman->jangka_waktu,
            'angsuran'  => number_format($angsur, 2, '.', ','),
            'tipe'      => $pinjaman->pengaturanid->tipe_maksimum_waktu,
            'akun'      => $pinjaman->pengaturanid->apkas->kode_akun.' - '.$pinjaman->pengaturanid->apkas->nama_akun,
            'sisbungaid'=> $pinjaman->pengaturanid->sistem_bunga,
            'sisbunga'  => $pinjaman->pengaturanid->sbunga->sistem,
            'akun_id'   => $pinjaman->id,
            'badmin'    => number_format($badminnya, 2, '.', ','),
            'badminbank'    => number_format($adminbank, 2, '.', ','),
            'badmintambah'    => number_format($harga * $admintambahan / 100, 2, '.', ',')
        );

        return json_encode($data);
    }

    public function simulasi() {

        echo '<div id="simulasi"  class="panel-body">';
        echo '<div class="table-responsive no-border">';
        echo '<table class="table table-bordered table-striped mg-t datatable editable-datatable">';
        echo '<thead>';
        echo '<tr style="background-color: dodgerblue; color: white">';
        echo '<th class="text-center" width="30px">No</th>';
        echo '<th class="text-center">Saldo</th>';
        echo '<th class="text-center">Pokok</th>';
        echo '<th class="text-center">Bunga</th>';
        echo '<th class="text-center">Angsuran</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        echo '<tr>';
        echo '<td class="text-center"></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }

    public function realajax(Request $request) {
        $pinjaman = Pinjaman::find($request->idp);
        $bagi = $pinjaman->pengaturanid->maksimum_waktu;

        $realisasi = str_replace(",","",$request->jml);
        $real = str_replace(".00","",$realisasi);

        $waktu = $request->waktu;

        if ($waktu > $bagi) {
            $hs = $bagi;
        } else {
            $hs = $waktu;
        }
        $total = $real / $hs ;

        $data[] = array(
            'angsuran' => number_format($total, 2, '.', ','),
            'hs'       => $hs
        );

        return json_encode($data);
    }

    public function biayaajax(Request $request) {
        $pinjaman = Pinjaman::find($request->idp);
        $bagi = $pinjaman->pengaturanid->maksimum_waktu;
        
        $realisasi = str_replace(",","",$request->real);
        $real = str_replace(".00","",$realisasi);

        $diterima = str_replace(",","",$request->ud);
        $bterima = str_replace(".00","",$diterima);

        $administrasi = str_replace(",","",$request->ad);
        $biayaa = str_replace(".00","",$administrasi);
        $administrasib = str_replace(",","",$request->adb);
        $biayaab = str_replace(".00","",$administrasib);
        $administrasit = str_replace(",","",$request->adt);
        $biayaat = str_replace(".00","",$administrasit);

        $provisi = str_replace(",","",$request->pro);
        $biayap = str_replace(".00","",$provisi);

        $lain = str_replace(",","",$request->lain);
        $biayal = str_replace(".00","",$lain);

        if ($pinjaman->pengaturanid->tipe_pinjaman == "barang") {
            $ureal = $bterima + ($biayaa + $biayaab + $biayaat + $biayap + $biayal);
            $uditerima = $bterima;
        } else {
            $ureal = $real;
            $uditerima = $real - ($biayaa + $biayaab + $biayaat + $biayap + $biayal);
        }

        if ($request->waktu > $bagi) {
            $hs = $bagi;
        } else {
            $hs = $request->waktu;
        }

        $data[] = array(
            'uangd' => number_format($uditerima, 2, '.', ','),
            'uangr' => number_format($ureal, 2, '.', ','),
            'angsuran' => number_format($ureal / $hs, 2, '.', ','),
            'hs'       => $hs
        );

        return json_encode($data);
    }

    public function getSimulasi(Request $r, $idsukubunga, $jangkawaktu)
    {
      $modules = \App\Module::all();

      $suku_bunga = $r->input('suku_bunga');

      for ($a = 1; $a <= $suku_bunga; $a++) {
        echo '<tr class="bungatr">'.
              '<td>'.$module->id.'</td>'.
              '<td>'.$module->module_name.'</td>'.
              '<td>'.$module->module_name.'</td>'.
              '<td>'.$module->module_name.'</td>'.
              '<td>'.$module->module_name.'</td>'.
             '</tr>';
      }
    }

    public function testSimulasi($idsistembunga,$idpinjaman,$real)
    {
        $real2 = str_replace(",","",$real);
        $realisasi = str_replace(".00","",$real2);

        $sistem_bunga = DB::table('sistem_bunga')->where('id',$idsistembunga)->first();
        $pinjaman = Pinjaman::where('id',$idpinjaman)->first();
        $hitung = $pinjaman->perhitungan_bunga;

        if (count($pinjaman)==0||count($sistem_bunga)==0) {
            echo '<tr class="bungatr"><td colspan="5" style="text-align:center">Data pinjaman tidak ditemukan</td></tr>';
        }

        else {
            $arr_pinjaman = Pinjaman::where('id',$idpinjaman)->first()->toArray();

            if ($sistem_bunga->sistem=='Bunga Tetap') {

                $pokok = $arr_pinjaman['jumlah_pengajuan']/$arr_pinjaman['jangka_waktu'];
                if ($pinjaman->pengaturanid->tipe_maksimum_waktu == "bulan") {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/12;
                    $bunga = $realisasi/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/12;
                }else {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/365;
                    $bunga = $realisasi/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/365;
                }
                $angsuran = $pokok+$bunga;
                $no = 0;

                for ($i = 0; $i <= $arr_pinjaman['jangka_waktu']; $i++) {
                    if ($no==0) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
//                        echo number_format($arr_pinjaman['jumlah_pengajuan'], 2, '.', ',');
                        echo number_format($realisasi, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }

                    else {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
//                        echo number_format($arr_pinjaman['jumlah_pengajuan']-=$pokok, 2, '.', ',');
                        echo number_format($realisasi-=$pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($bunga, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($angsuran, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }

            elseif ($sistem_bunga->sistem=='Bunga Efektif / Sliding Data') {
//                $pokok = $arr_pinjaman['jumlah_pengajuan']/$arr_pinjaman['jangka_waktu'];
                $pokok = $realisasi/$arr_pinjaman['jangka_waktu'];
//                $bungath = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100;
                $bungath = $realisasi*$arr_pinjaman['suku_bunga']/100;
                if ($pinjaman->pengaturanid->tipe_maksimum_waktu == "bulan") {
                    $bunga = $bungath / 12;
                }else {
                    $bunga = $bungath / 365;
                }
//                if($hitung == "bulanan") {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100/12;
//                } else {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100*30/360;
//                }
                $bunga2 = $bunga/$arr_pinjaman['jangka_waktu'];
                $angsuran = $pokok+$bunga;
                $no = 0;

                for ($i=0; $i <= $arr_pinjaman['jangka_waktu']; $i++) {
                    if ($no==0) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
//                        echo number_format($arr_pinjaman['jumlah_pengajuan'], 2, '.', ',');
                        echo number_format($realisasi, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }

                    elseif ($no==1) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
//                        echo number_format($arr_pinjaman['jumlah_pengajuan']-=$pokok, 2, '.', ',');
                        echo number_format($realisasi-=$pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($bunga, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($angsuran, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }

                    else {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
//                        echo number_format($arr_pinjaman['jumlah_pengajuan']-=$pokok, 2, '.', ',');
                        echo number_format($realisasi-=$pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($bunga-=$bunga2, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($angsuran-=$bunga2, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }

            elseif ($sistem_bunga->sistem=='Bunga Menurun / Anuitas') {
                $no = 0;

//                $bungath = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100;
                $bungath = $realisasi*$arr_pinjaman['suku_bunga']/100;
//                $angsuran = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
                $angsuran = $realisasi*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
                if ($pinjaman->pengaturanid->tipe_maksimum_waktu == "bulan") {
                    $bunga = $bungath / 12;
                }else {
                    $bunga = $bungath / 365;
                }
//                if($hitung == "bulanan") {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100/12;
//                } else {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100*30/360;
//                }
                $pokok = $angsuran-$bunga;
                // Other variable
//                $pokok_pinjaman = $arr_pinjaman['jumlah_pengajuan']-$pokok;
                $pokok_pinjaman = $realisasi-$pokok;
                $bungath2 = $pokok_pinjaman*$arr_pinjaman['suku_bunga']/100;
                if ($pinjaman->pengaturanid->tipe_maksimum_waktu == "bulan") {
                    $dummy_bunga = $bungath2 / 12;
                }else {
                    $dummy_bunga = $bungath2 / 365;
                }
//                if($hitung == "bulanan") {
//                    $dummy_bunga = $pokok_pinjaman*$arr_pinjaman['suku_bunga']/100/12;
//                } else {
//                    $dummy_bunga = $pokok_pinjaman*$arr_pinjaman['suku_bunga']/100*30/360;
//                }
                $dummy_pokok = $angsuran-$dummy_bunga;

                for ($i=0; $i <= $arr_pinjaman['jangka_waktu']; $i++) {
                    if ($no==0) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
//                        echo number_format($arr_pinjaman['jumlah_pengajuan'], 2, '.', ',');
                        echo number_format($realisasi, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format(0, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }

                    elseif ($no==1) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($pokok_pinjaman, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($pokok, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($bunga, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($angsuran, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }

                    else {
                       // $ppi = $pokok_pinjaman;
//                        if ($no%2 == 0) {
//                            $ppi-=1;
//                        }
                        $ppi = $pokok_pinjaman;
//                        $angsuran = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
                        $angsuran = $realisasi*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
                        if($hitung == "bulanan") {
                            $dummy_bunga2 = $ppi*$arr_pinjaman['suku_bunga']/100/12;
                        } else {
                            $dummy_bunga2 = $ppi*$arr_pinjaman['suku_bunga']/100*30/360;
                        }
                        $dummy_pokok2 = $angsuran-$dummy_bunga2;
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($pokok_pinjaman-=$dummy_pokok2, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($dummy_pokok2, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($dummy_bunga2, 2, '.', ',');
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($angsuran, 2, '.', ',');
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }
        }
    }

    public function tablejamin($idp) {
        $jaminan = Jaminan::where('id_pinjaman', $idp)->get();
        echo '<table class="table table-hover" id="tjamin">';
        $i = 1;
        foreach ($jaminan as $value) {
            echo '<a href="javascript:void(0)"><tr onclick="ket('.$value->id.')">';
            echo '<td width="10">'.$i++.'</td>';
            echo '<td>'.$value->jenisid->jenis.'</td>';
            echo '</tr></a>';
        }
        echo '</table>';
    }

    public function tableket($idj) {
        $jaminan = Jaminan::find($idj);
        echo '<table class="table table-hover" id="tjamin">';
        echo '<tr>';
        echo '<td><img width="100" src="'.url('foto/jaminan/'.$jaminan->foto).'"></td>';
        echo '<td>-</td>';
        echo '<td><img width="100" src="'.url('foto/jaminan/'.$jaminan->foto2).'"></td>';
        echo '</tr>';
        if ($jaminan->jenisid->tabel == "jaminan_simpanan") {

            $jamsimpanan = Jaminansimpanan::where('id_jaminan', $idj)->first();
            echo '<tr>';
            echo '<td>Nomor Simpanan</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamsimpanan->nomor_simpanan.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Bank</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamsimpanan->bank.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Jumlah</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamsimpanan->jumlah.'</td>';
            echo '</tr>';
        } else if ($jaminan->jenisid->tabel == "jaminan_emas") {

            $jamemas = Jaminanemas::where('id_jaminan', $idj)->first();
            echo '<tr>';
            echo '<td>Nomor Sertifikat</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamemas->nomor_sertifikat.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Berat</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamemas->berat.' Gram</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Karat</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamemas->karat.' Karat</td>';
            echo '</tr>';
        } else if ($jaminan->jenisid->tabel == "jaminan_elektronik") {

            $jamelektronik = Jaminanelektronik::where('id_jaminan', $idj)->first();
            echo '<tr>';
            echo '<td>Nomor Serial</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamelektronik->nomor_serial.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Tipe</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamelektronik->tipe.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Merek</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamelektronik->merek.'</td>';
            echo '</tr>';
        } else if ($jaminan->jenisid->tabel == "jaminan_bangunan") {

            $jambangunan = Jaminanbangunan::where('id_jaminan', $idj)->first();
            echo '<tr>';
            echo '<td>Nomor Sertifikat</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->nomor_sertfikat.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Kelurahan</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->kelurahan.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Kecamatan</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->kecamatan.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Kota</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->kota.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Provinsi</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->provinsi.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>NIB</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->nib.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Peruntukan</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->pruntukan.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Ser HAK</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->ser_hak.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Luas Tanah</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jambangunan->luas_tanah.'</td>';
            echo '</tr>';
        } else if ($jaminan->jenisid->tabel == "jaminan_kwndaraan") {

            $jamkendaraan = Jaminankendaraan::where('id_jaminan', $idj)->first();
            echo '<tr>';
            echo '<td>Nomor Plat</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->nomor_plat.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Nomor BPKB</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->nomor_bpkb.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Merek</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->merek.'</td>';
            echo '</tr>';echo '<tr>';
            echo '<td>Jenis</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->jenis.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Tahun</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->tahun.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Warna</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->warna.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Nomor Rangka</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->nomor_rangka.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Bahan Bakar</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->bahan_bakar.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Tipe</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->tipe.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Model</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->model.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>CC</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->cc.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Jumlah Roda</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->jumlah_roda.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Nomor Mesin</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamkendaraan->nomor_mesin.'</td>';
            echo '</tr>';
        }else {

            $jamtanpa = Jaminantanpa::where('id_jaminan', $idj)->first();
            echo '<tr>';
            echo '<td>Nomor</td>';
            echo '<td width="1">:</td>';
            echo '<td>'.$jamtanpa->nomor.'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}
