<?php

namespace App\Http\Controllers\Simpanan;

use App\Approve;
use App\Approverole;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Nomor;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Kolektif;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class KolektifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nom = Nomor::where('modul', 'Simpanan')->first();
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

        if($nom == null) {
            $msgclass = "warning";
            $msg = "Peringatan !! Anda harus menentukan Format Nomor untuk modul Simpanan terlebih dahulu .";
            return redirect(url('pengaturan/nomor/create'))
                ->with('msgclass', $msgclass)
                ->with('msg', $msg);
        } else if($nom2 == null) {
            $msgclass = "warning";
            $msg = "Peringatan !! Anda harus menentukan Format Nomor untuk modul Jurnal Otomatis terlebih dahulu .";
            return redirect(url('pengaturan/nomor/create'))
                ->with('msgclass', $msgclass)
                ->with('msg', $msg);
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $date = date('m/d/Y');
            $simpanan = Simpanan::whereHas('anggotaid', function($query) {
                $query->where('status', 'AKTIF');
            })->get();
            $kolektif = Kolektif::paginate(20);
            return view('simpanan.transaksi.kolektif')->with('simpanan', $simpanan)
                ->with('kolektif', $kolektif)
                ->with('date', $date);
        }
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
        $jum = $request->jumlah;
        $jum2 = str_replace(",","",$jum);
        $jumlah = str_replace(".00","",$jum2);

        if ($request->tanggal == "") {
            $date = "00/00/0000";
        } else {
            $date = $request->tanggal;
        }
        $simp = Simpanan::findOrNew($request->nomor_simpanan);
        $saldomm = $simp->pengaturanid->saldo_minimum;
        $setormm = $simp->pengaturanid->setoran_minimum;
        $ak3 = Akumulasi::where('id_simpanan', $request->nomor_simpanan)->first();
        if ($request->tipe == "SETOR") {
            if($jumlah < $setormm) {
                $msgclass = "danger";
                $msg = "Transaksi GAGAL Dilakukan. <br>Jumlah setoran yang Anda lakukan di bawah setoran minimum yang telah ditentukan.( Rp.".number_format($setormm, 2, '.', ',')." )";
                return redirect(url('simpanan/kolektif'))
                    ->with('msgclass', $msgclass)
                    ->with('msg', $msg);
            }

        } else {
            if($ak3->saldo <= $saldomm) {
                $msgclass = "danger";
                $msg = "Transaksi GAGAL Dilakukan. <br>Saldo Anda berada di bawah saldo minimum yang telah ditentukan.( Rp.".number_format($saldomm, 2, '.', ',')." )";
                return redirect(url('simpanan/kolektif'))
                    ->with('msgclass', $msgclass)
                    ->with('msg', $msg);
            }
        }

        $tgl = explode('/', $date);
        Kolektif::create([
            'tipe'  => $request->tipe,
            'id_simpanan'  => $request->nomor_simpanan,
            'nominal'  => $jumlah,
            'tanggal'  => $tgl[2].'-'.$tgl[0].'-'.$tgl[1],
            'keterangan'    => $request->keterangan
        ]);

        return redirect(url('simpanan/kolektif'));
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


    public function up() {
        $kolektif = Kolektif::all();
        foreach($kolektif as $item) {
            $simp = Simpanan::findOrNew($item->id_simpanan);
            $ak3 = Akumulasi::where('id_simpanan', $item->id_simpanan)->first();
            if ($item->tipe == "SETOR") {
                $kredit = $item->nominal;
                $debet = "";
                $tipe = "SETOR";
                $saldo3 = ($ak3->saldo + $item->nominal) - $ak3->outs;
            } else {
                $tipe = "TARIK";
                $debet = $item->nominal;
                $kredit = "";
                $saldo3 = $ak3->saldo - $item->nominal;

                $cekrole = Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->first();
                if ($cekrole != null) {
                    $levv1 = \App\Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->where('level', '1')->first();
                    if ($levv1 == null) {
                        $lev1 = 2;
                    } else {
                        $lev1 = 0;
                    }

                    $levv2 = \App\Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->where('level', '2')->first();
                    if ($levv2 == null) {
                        $lev2 = 2;
                    } else {
                        $lev2 = 0;
                    }

                    $levv3 = \App\Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->where('level', '3')->first();
                    if ($levv3 == null) {
                        $lev3 = 2;
                    } else {
                        $lev3 = 0;
                    }

                    $rell = \App\Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->where('level', '4')->first();
                    if ($rell == null) {
                        $rel = 2;
                    } else {
                        $rel = 0;
                    }

                    $approve = Approve::create([
                        'id_for' => $item->id_simpanan,
                        'for' => "simpanan",
                        'lev1' => $lev1,
                        'lev2' => $lev2,
                        'lev3' => $lev3,
                        'release' => $rel
                    ]);
                }
            }
            $tran3 = Transaksi::create([
                'kode' => $this->_generate(),
                'tipe' => $tipe,
                'id_simpanan' => $item->id_simpanan,
                'id_dari' => $item->id_simpanan,
                'saldo_awal'  => $simp->akumulasiid->saldo,
                'nominal'     => $item->nominal,
                'saldo_akhir'  => $saldo3,
                'tanggal'     => $item->tanggal,
                'kredit'   => $kredit,
                'debet'    => $debet,
                'status'   => "AKTIF",
                'keterangan'    => $item->keterangan,
                'info'     => $tipe." : ".$simp->anggotaid->nama,
                'approved' => 1
            ]);

            $tr3 = Akumulasi::findOrNew($ak3->id);
            $tr3->update(['saldo' => $saldo3, 'outs' => 0]);

            if ($tipe == "TARIK") {
                $cekrole = Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->first();
                if ($cekrole != null) {
                    $appr = Approve::find($approve->id);
                    $appr->update(['id_for' => $tran3->id]);

                    $transimp = Transaksi::find($tran3->id);
                    $transimp->update(['approved' => 0]);
                } else {
                    $ids = $item->id_simpanan;
                    $tp = $tipe;
                    $nominal = $item->nominal;
                    $this->_isijurnal($ids, $tp, $nominal);
                }
            } else {

                $ids = $item->id_simpanan;
                $tp = $tipe;
                $nominal = $item->nominal;
                $this->_isijurnal($ids, $tp, $nominal);
            }

            Kolektif::destroy($item->id);
        }

        return redirect(url('simpanan/kolektif'));
    }

    public function down() {
        $kolektif = Kolektif::all();
        foreach($kolektif as $item) {
            Kolektif::destroy($item->id);
        }
        return redirect(url('simpanan/kolektif'));
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

    public function _ceksaldo($id) {
        $kredit = Transaksi::where('id_simpanan', $id)->where('tipe', 'SETOR')->sum('nominal');
        $debet = Transaksi::where('id_simpanan', $id)->where('tipe', 'TARIK')->sum('nominal');
        $trf_debet = Transaksi::where('id_simpanan', $id)->where('tipe', 'TRANSFER')->where('id_dari', '=', '')->sum('nominal');
        $trf_kredit = Transaksi::where('id_simpanan', $id)->where('tipe', 'TRANSFER')->where('id_dari', '!=', '')->sum('nominal');

        $saldo = $kredit + $trf_kredit - $debet - $trf_debet;

        return $saldo;
    }

    public function _isijurnal($ids, $tp, $nominal) {
        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "TABUNGAN",
            'kode_jurnal'   => $this->_generatekodejurnal(),
            'tanggal'   => date('Y-m-d H:i:s'),
            'keterangan'=> $tp
        ]);
        $simp = Simpanan::findOrNew($ids);

        if($tp == "SETOR") {
            $debet = "";
            $kredit = $nominal;
            $akunid = $simp->pengaturanid->akun_setoran;

            $debet2 = $nominal;
            $kredit2 = "";
            $akunid2 = $simp->pengaturanid->akun_kas_bank;
        } else {
            $debet = $nominal;
            $kredit = "";
            $akunid = $simp->pengaturanid->akun_penarikan;

            $debet2 = "";
            $kredit2 = $nominal;
            $akunid2 = $simp->pengaturanid->akun_kas_bank;
        }
        $detail1 = [
            'id_header'     => $header->id,
            'id_akun'       => $akunid,
            'debet'         => $debet,
            'kredit'         => $kredit,
            'nominal'         => $nominal
        ];

        $detail2 = [
            'id_header'     => $header->id,
            'id_akun'       => $akunid2,
            'debet'         => $debet2,
            'kredit'         => $kredit2,
            'nominal'         => $nominal
        ];

        if($tp == "SETOR") {
            JurnalDetail::create($detail2);
            JurnalDetail::create($detail1);
        } else {
            $cekapprole = Approverole::where('for', 'simpanan')->where('id_for', $simp->jenis_simpanan)->first();
            if ($cekapprole == null) {
                JurnalDetail::create($detail1);
                JurnalDetail::create($detail2);
            }
        }

        $jurnal = "OKE";
        return $jurnal;
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

    public function cekup() {
        $kolektif = Kolektif::count();
        if($kolektif > 0) {
            $stat = "OK";
            $title = "";
            $psg = "";
        } else {
            $stat = "FAIL";
            $title = "Simpanan Kolektif";
            $psg = "Daftar Kolektif tidak boleh kosong";
        }

        $data[] = array(
            'stat' => $stat,
            'title' => $title,
            'psg'   => $psg
        );

        return json_encode($data);
    }

    public function cekaturan($ids, $jumlah, $tipe) {
        $simpanan = Simpanan::find($ids);
        if ($simpanan->status == 1) {
            $blk = "Telah DiBlokir";
        } else if ($simpanan->status == 2) {
            $blk = "Sudah DiTutup";
        } else {
            $blk = "";
        }

        $jmlnominal = str_replace(",","",$jumlah);
        $bnominal = str_replace(".00","",$jmlnominal);

        if($tipe == "TARIK") {
            if ($simpanan->status != 0) {
                $stat = "FAIL";
                $title = "GAGAL TARIK";
                $psg = "Simpanan ".$simpanan->nomor_simpanan." ".$blk;
            } else if($bnominal > $simpanan->akumulasiid->saldo) {
                $stat = "FAIL";
                $title = "GAGAL TARIK";
                $psg = "Saldo tidak boleh kurang dari Nominal : ".number_format($bnominal, 2, '.', ',');
            } else if($simpanan->akumulasiid->saldo < $simpanan->pengaturanid->saldo_minimum){
                $stat = "FAIL";
                $title = "GAGAL TARIK";
                $psg = "Saldo tidak boleh kurang dari Saldo Minimum : ".number_format($simpanan->pengaturanid->saldo_minimum, 2, '.', ',');
            } else {
                $stat = "OK";
                $title = "";
                $psg = "";
            }
        } else {
            if ($simpanan->status != 0) {
                $stat = "FAIL";
                $title = "GAGAL SETOR";
                $psg = "Simpanan ".$simpanan->nomor_simpanan." ".$blk;
            } else if($bnominal < $simpanan->pengaturanid->setoran_minimum) {
                $stat = "FAIL";
                $title = "GAGAL SETOR";
                $psg = "Setoran tidak boleh kurang dari Setoran Minimum : " . number_format($simpanan->pengaturanid->setoran_minimum, 2, '.', ',');
            } else {
                $stat = "OK";
                $title = "";
                $psg = "";
            }
        }

        $data[] = array(
            'stat' => $stat,
            'title' => $title,
            'psg'   => $psg
        );

        return json_encode($data);
    }
}
