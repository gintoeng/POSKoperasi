<?php

namespace App\Http\Controllers\Simpanan;

use App\Approve;
use App\Approverole;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Nomor;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::orderBy('id','asc')->paginate(20);
        $jml = Transaksi::count();
        return view('simpanan.transaksi.daftar_transaksi')->with('transaksi', $transaksi)->with('jml',$jml);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $transaksi = Transaksi::where('kode','like','%'.$query.'%')->orWhere('tanggal','like','%'.$query.'%')->orWhere('tipe','like','%'.$query.'%')->orWhereHas('simpananid', function($querys) use ($query) {
            $querys->where('nomor_simpanan','like','%'.$query.'%')->orWhereHas('anggotaid', function($queryss) use ($query) {
                $queryss->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
            });
        })->orderBy('id','asc')->paginate(20);
        $jml = Transaksi::where('kode','like','%'.$query.'%')->orWhere('tanggal','like','%'.$query.'%')->orWhere('tipe','like','%'.$query.'%')->orWhereHas('simpananid', function($querys) use ($query) {
            $querys->where('nomor_simpanan','like','%'.$query.'%')->orWhereHas('anggotaid', function($queryss) use ($query) {
                $queryss->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
            });
        })->count();
        return view('simpanan.transaksi.cari_transaksi')->with('transaksi', $transaksi)->with('query',$query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $simpanan = Simpanan::whereHas('anggotaid', function($query) {
            $query->where('status', 'AKTIF');
        })->get();
        return view('simpanan.transaksi.tambah_transaksi')->with('simpanan', $simpanan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nom = $request->nominal;
        $nom2 = str_replace(",","",$nom);
        $nominal = str_replace(".00","",$nom2);

        $simp = Simpanan::findOrNew($request->nomor_simpanan);
        $saldomm = $simp->pengaturanid->saldo_minimum;
        $setormm = $simp->pengaturanid->setoran_minimum;
        $simpto = Simpanan::findOrNew($request->nomor_simpanan_to);

        date_default_timezone_set('Asia/Jakarta');
        if ($request->tipe == "TRANSFER") {
            $ak = Akumulasi::where('id_simpanan', $request->nomor_simpanan)->first();
                $saldo = $ak->saldo - $nominal;
                $tr = Akumulasi::findOrNew($ak->id);
                $tr->update(['saldo' => $saldo]);

                Transaksi::create([
                    'kode' => $this->_generate(),
                    'tipe' => "TRANSFER",
                    'id_simpanan' => $request->nomor_simpanan,
                    'id_dar'   => $request->nomor_simpanan,
                    'id_tujuan' => $request->nomor_simpanan_to,
                    'saldo_awal'  => $ak->saldo,
                    'nominal'     => $nominal,
                    'saldo_akhir'  => $saldo,
                    'tanggal'     => date('Y-m-d H:i:s'),
                    'kredit'    => $nominal,
                    'status'   => "AKTIF",
                    'keterangan' => $request->keterangan,
                    'info'     => "TRANSFER Dari : ".$simp->anggotaid->nama
                ]);
                $ids = $request->nomor_simpanan;
                $tp = "TRANSFERdari";
                $tpn = "TRANSFER";
                $header = $this->_jurnalheader($tpn);
//                $jurnal2 = $this->_isijurnal($header, $ids, $tp, $nominal);

                $ak2 = Akumulasi::where('id_simpanan', $request->nomor_simpanan_to)->first();
                $saldo2 = $ak2->saldo + $nominal - $ak2->outs;
                $tr2 = Akumulasi::findOrNew($ak2->id);
                $tr2->update(['saldo' => $saldo2, 'outs' => 0]);
                Transaksi::create([
                    'kode' => $this->_generate(),
                    'tipe' => "TRANSFER",
                    'id_simpanan' => $request->nomor_simpanan_to,
                    'id_dari'    => $request->nomor_simpanan,
                    'id_tujuan'   => $request->nomor_simpanan_to,
                    'saldo_awal'  => $ak2->saldo,
                    'nominal'     => $nominal,
                    'saldo_akhir'  => $saldo2,
                    'tanggal'     => date('Y-m-d H:i:s'),
                    'debet'    => $nominal,
                    'status'   => "AKTIF",
                    'keterangan' => $request->keterangan,
                    'info'     => "TRANSFER Ke : ".$simpto->anggotaid->nama
                ]);
                $ids2 = $request->nomor_simpanan_to;
                $tp2 = "TRANSFERto";

                $simpanan = Simpanan::find($request->nomor_simpanan);
                $simpananke = Simpanan::find($request->nomor_simpanan_to);

                $detail1 = JurnalDetail::create([
                    'id_header'     => $header,
                    'id_akun'       => $simpanan->pengaturanid->akun_penarikan,
                    'debet'         => $nominal,
                    'kredit'         => "",
                    'nominal'         => $nominal
                ]);

                $detail2 = JurnalDetail::create([
                    'id_header'     => $header,
                    'id_akun'       => $simpananke->pengaturanid->akun_setoran,
                    'debet'         => "",
                    'kredit'         => $nominal,
                    'nominal'         => $nominal
                ]);
//                $jurnal2 = $this->_isijurnal($header, $ids2, $tp2, $nominal);

        } else {
            $ak3 = Akumulasi::where('id_simpanan', $request->nomor_simpanan)->first();

            if ($request->tipe == "SETOR") {
                $kredit = $nominal;
                $debet = "";
                $tipe = "SETOR";
                $tpp = "Setoran";
                $saldo3 = ($ak3->saldo + $nominal) - $ak3->outs;

            } else {
                $tipe = "TARIK";
                $tpp = "Penarikan";
                $debet = $nominal;
                $kredit = "";
                $saldo3 = $ak3->saldo - $nominal;

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
                        'id_for' => $request->nomor_simpanan,
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
               'id_simpanan' => $request->nomor_simpanan,
               'id_dari' => $request->nomor_simpanan,
               'saldo_awal'  => $ak3->saldo,
               'nominal'     => $nominal,
               'saldo_akhir'  => $saldo3,
               'tanggal'     => date('Y-m-d H:i:s'),
               'kredit'   => $kredit,
               'debet'    => $debet,
               'status'   => "AKTIF",
               'keterangan' => $request->keterangan,
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
                    $ids3 = $request->nomor_simpanan;
                    $tp3 = $tipe;
                    $header3 = $this->_jurnalheader($tp3);
                    $this->_isijurnal($header3, $ids3, $tp3, $nominal);
                }
            } else {

                $ids3 = $request->nomor_simpanan;
                $tp3 = $tipe;
                $header3 = $this->_jurnalheader($tp3);
                $this->_isijurnal($header3, $ids3, $tp3, $nominal);
            }

        }

        $msg = "Transaksi Berhasil Dilakukan";
        $alert = Toastr::success($msg, $title = "Transaksi", $options = []);
        return redirect(url('simpanan/transaksi'))
            ->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = Transaksi::findOrNew($id);
        $simpanan = Simpanan::all();
        return view('simpanan.transaksi.lihat_transaksi')->with('transaksi', $transaksi)->with('simpanan', $simpanan);
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
        $msg = "Data Berhasil di Hapus";
        $alert = Toastr::success($msg, $title = "Transaksi", $options = []);
        $transaksi = Transaksi::findOrNew($id);
        $transaksi->update([
            'status' => "VOID"
        ]);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function transaksiajax($id) {
        $sim = Simpanan::findOrNew($id);

        if ($sim->status == 1) {
            $blk = "telah DiBlokir";
            $stat = "FAIL";
            $title = "PERINGATAN";
            $psg = "Simpanan ".$sim->nomor_simpanan." ".$blk;
        } else if ($sim->status == 2) {
            $blk = "Sudah DiTutup";
            $stat = "FAIL";
            $title = "PERINGATAN";
            $psg = "Simpanan ".$sim->nomor_simpanan." ".$blk;
        } else {
            $blk = "";
            $stat = "OK";
            $title = "";
            $psg = "";
        }

        $data[] = array(
            'id'     => $sim->id,
            'text'   => $sim->nomor_simpanan.' - '.$sim->anggotaid->nama,
            'nama'   => $sim->anggotaid->nama,
            'alamat' => $sim->anggotaid->alamat.", ".$sim->anggotaid->kota.", ".$sim->anggotaid->provinsi,
            'jenis_simpanan'  => $sim->pengaturanid->jenis_simpanan,
            'akun_kas'        => $sim->pengaturanid->akun_kas_bank,
            'akun_setoran'    => $sim->pengaturanid->akun_setoran,
            'akun_penarikan'  => $sim->pengaturanid->akun_penarikan,
            'saldo'           => number_format($sim->akumulasiid->saldo, 2, '.', ','),
            'saldo_minimum'   => number_format($sim->pengaturanid->saldo_minimum, 2, '.', ','),
            'setoran_minimum' => number_format($sim->pengaturanid->setoran_minimum, 2, '.', ','),
            'setoran_bulanan' => number_format($sim->setoran_bulanan, 2, '.', ','),
            'status'          => $sim->status,
            'ss'              => (int)$sim->akumulasiid->saldo,
            'setorb'          => $sim->setoran_bulanan,
            'setormm'         => $sim->pengaturanid->setoran_minimum,
            'saldomm'         => (int)$sim->pengaturanid->saldo_minimum,
            'sb'              => $sim->saldo_blokir,
            'stat'            => $stat,
            'title'           => $title,
            'psg'             => $psg,
            'kode'            => $sim->anggotaid->kode,
            'npk'            => $sim->anggotaid->npk

        );

        return json_encode($data);
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

    public function _isijurnal($header, $ids, $tp, $nominal) {

        $simp = Simpanan::findOrNew($ids);
        if($tp == "SETOR" || $tp == "TRANSFERto") {
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
            'id_header'     => $header,
            'id_akun'       => $akunid,
            'debet'         => $debet,
            'kredit'         => $kredit,
            'nominal'         => $nominal
        ];

        $detail2 = [
            'id_header'     => $header,
            'id_akun'       => $akunid2,
            'debet'         => $debet2,
            'kredit'         => $kredit2,
            'nominal'         => $nominal
        ];

        if($tp == "SETOR" || $tp == "TRANSFERto") {
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

    public function _jurnalheader($tpt) {
        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "TABUNGAN",
            'kode_jurnal'   => $this->_generatekodejurnal(),
            'tanggal'   => date('Y-m-d H:i:s'),
            'keterangan'=> $tpt
        ]);

        $idh = $header->id;
        return $idh;
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

    public function cekaturan($idp, $idp2, $nominal, $status) {
        $nominalnya = str_replace(",","",$nominal);
        $nml = str_replace(".00","",$nominalnya);

        $nom = Nomor::where('modul', 'Simpanan')->first();
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

        $simpanan = Simpanan::find($idp);
        $sld = $simpanan->akumulasiid->saldo;

        if ($simpanan->status == 1) {
            $blk = "Telah DiBlokir";
        } else if ($simpanan->status == 2) {
            $blk = "Sudah DiTutup";
        } else {
            $blk = "";
        }

        if($nom == null) {
            $stat = "FAIL";
            $title = "Format Nomor Simpanan";
            $psg = "Format nomor untuk Simpanan belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
        } else if($nom2 == null){
            $stat = "FAIL";
            $title = "Format Nomor Jurnal Otomatis";
            $psg = "Format nomor untuk Jurnal Otomatis belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
        } else if($status == "TARIK") {
            if ($simpanan->status != 0) {
                $stat = "FAIL";
                $title = "GAGAL TARIK";
                $psg = "Simpanan ".$simpanan->nomor_simpanan." ".$blk;
            } else if($sld < $nml) {
                $stat = "FAIL";
                $title = "GAGAL TARIK";
                $psg = "Saldo tidak boleh kurang dari Nominal : ".number_format($nml, 2, '.', ',');
            } else if($sld < $simpanan->pengaturanid->saldo_minimum){
                $stat = "FAIL";
                $title = "GAGAL TARIK";
                $psg = "Saldo tidak boleh kurang dari Saldo Minimum : ".number_format($simpanan->pengaturanid->saldo_minimum, 2, '.', ',');
            }else {
                $stat = "OK";
                $title = "";
                $psg = "";
            }
        } else if($status == "TRANSFER") {
            $simpanan2 = Simpanan::find($idp2);
            if ($simpanan2->status == 1) {
                $blk2 = "Telah DiBlokir";
            } else if ($simpanan2->status == 2) {
                $blk2 = "Sudah DiTutup";
            } else {
                $blk2 = "";
            }

            if ($simpanan->status != 0) {
                $stat = "FAIL";
                $title = "GAGAL TRANSFER";
                $psg = "Simpanan ".$simpanan->nomor_simpanan." ".$blk;
            } else if ($simpanan2->status != 0) {
                $stat = "FAIL";
                $title = "GAGAL TRANSFER";
                $psg = "Simpanan tujuan ".$simpanan->nomor_simpanan." ".$blk2;
            } else if($sld < $nml) {
                $stat = "FAIL";
                $title = "GAGAL TRANSFER";
                $psg = "Saldo tidak boleh kurang dari Nominal : ".number_format($nml, 2, '.', ',');
            } else if($sld < $simpanan->pengaturanid->saldo_minimum){
                $stat = "FAIL";
                $title = "GAGAL TRANSFER";
                $psg = "Saldo tidak boleh kurang dari Saldo Minimum : ".number_format($simpanan->pengaturanid->saldo_minimum, 2, '.', ',');
            }else {
                $stat = "OK";
                $title = "";
                $psg = "";
            }
        }else {
            if ($simpanan->status != 0) {
                $stat = "FAIL";
                $title = "GAGAL SETOR";
                $psg = "Simpanan ".$simpanan->nomor_simpanan." ".$blk;
            } else if($nml < $simpanan->pengaturanid->setoran_minimum) {
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
