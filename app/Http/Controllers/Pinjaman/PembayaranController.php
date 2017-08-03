<?php

namespace App\Http\Controllers\Pinjaman;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Pengaturan\Nomor;
use App\Model\Pinjaman\Realisasi;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use App\Model\Sistembunga;
use DB;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pinjaman;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class PembayaranController extends Controller
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
        $df = date('Y-m-01');
        $dateto = date('m/t/Y');
        $dt = date('Y-m-t');
        $pembayaran = Pembayaran::where('start', '1')->where('tanggal_bayar', '>=', $df)->where('tanggal_bayar', '<=', $dt)->orderBy('id','asc')->paginate(20);
        $jml = Pembayaran::where('start', '1')->where('tanggal_bayar', '>=', $df)->where('tanggal_bayar', '<=', $dt)->count();
        $pinjaman = Pinjaman::where('id', '1')->get();
        return view('pinjaman.pembayaran.daftar_pembayaran')->with('pembayaran', $pembayaran)
            ->with('pinjaman', $pinjaman)
            ->with('datefrom', $datefrom)
            ->with('dateto', $dateto)->with('jml',$jml);
    }

    public function search(Request $request) {
        $datefrom = $request->datefrom;
        $dateto = $request->dateto;
        $query = $request->input('query');
        $df = explode('/',$datefrom);
        $datefrom2 = $df[2]."-".$df[0]."-".$df[1];
        $dt = explode('/',$dateto);
        $dateto2 = $dt[2]."-".$dt[0]."-".$dt[1];

        if ($query == "") {
            $pembayaran = Pembayaran::where('start', '1')->where('tanggal_bayar', '>=', $datefrom2)->where('tanggal_bayar', '<=', $dateto2)->orderBy('id','asc')->paginate(20);
            $jml = Pembayaran::where('start', '1')->where('tanggal_bayar', '>=', $datefrom2)->where('tanggal_bayar', '<=', $dateto2)->count();
        } else {
            $pembayaran = Pembayaran::where('start', '1')->where('tanggal_bayar', '>=', $datefrom2)->where('tanggal_bayar', '<=', $dateto2)->where('nomor_transaksi', 'like', '%' . $query . '%')->orWhereHas('pinjamanid', function ($querys) use ($query) {
                $querys->where('nomor_pinjaman', 'like', '%' . $query . '%')->orWhereHas('anggotaid', function ($queryss) use ($query) {
                    $queryss->where('nama', 'like', '%' . $query . '%');
                });
            })->orderBy('id', 'asc')->paginate(20);

            $jml = Pembayaran::where('start', '1')->where('tanggal_bayar', '>=', $datefrom2)->where('tanggal_bayar', '<=', $dateto2)->where('nomor_transaksi', 'like', '%' . $query . '%')->orWhereHas('pinjamanid', function ($querys) use ($query) {
                $querys->where('nomor_pinjaman', 'like', '%' . $query . '%')->orWhereHas('anggotaid', function ($queryss) use ($query) {
                    $queryss->where('nama', 'like', '%' . $query . '%');
                });
            })->count();
        }

        $pinjaman = Pinjaman::where('id', '1')->get();
        return view('pinjaman.pembayaran.cari_pembayaran')->with('pembayaran', $pembayaran)
            ->with('pinjaman', $pinjaman)
            ->with('datefrom', $datefrom)
            ->with('dateto', $dateto)->with('jml',$jml)->with('query',$query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $perkiraan = Perkiraan::all();
        $pinjaman = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->whereHas('anggotaid', function($query) {
            $query->where('status', 'AKTIF');
        })->get();
        $simpanan = Simpanan::whereHas('anggotaid', function($query) {
            $query->where('status', 'AKTIF');
        })->get();
        return view('pinjaman.pembayaran.tambah_pembayaran')->with('pinjaman', $pinjaman)
            ->with('today', $today)
            ->with('perkiraan', $perkiraan)
            ->with('simpanan', $simpanan)
            ->with('sistem_bunga', $sistem_bunga);
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
        $kode = "PINJ".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $bayarpokok = str_replace(",","",$r->input('bayar_pokok'));
        $bpokok = str_replace(".00","",$bayarpokok);

        $bayarbunga = str_replace(",","",$r->input('bayar_bunga'));
        $bbunga = str_replace(".00","",$bayarbunga);

        $bayardenda = str_replace(",","",$r->input('bayar_denda'));
        $bdenda = str_replace(".00","",$bayardenda);


        $bayartotal = str_replace(",","",$r->input('total'));
        $btotal = str_replace(".00","",$bayartotal);

        $tgltrans = explode('/', $r->input('tanggal_transaksi'));
        $id = $r->input('id_pinjaman');
        $cara_bayar = $r->input('cara_bayar');
        if ($cara_bayar == "Tunai") {
            $buy = "TUNAI";
            $ss = '1';
        } else {
            $buy = "SIMPANAN";
            $ss = '1';
        }

        $pinj = Pinjaman::find($id);
        $akun_kas = $pinj->pengaturanid->akun_kas_bank;

        $pembayaran = Pembayaran::findOrNew($r->input('idpem'));
        $pembayaran->update([
            'id_pinjaman' => $id,
            'nomor_transaksi' => $this->_generate(),
            'cara_bayar'    => $buy,
            'akun_kas_bank' => $akun_kas,
            'tanggal_bayar' => $tgltrans[2].'-'.$tgltrans[0].'-'.$tgltrans[1],
            'pokok'         => $bpokok,
            'denda'         => $bdenda,
            'bunga'         => $bbunga,
            'total'         => $btotal,
            'status'        => 'AKTIF',
            'start'         => 1,
            'autodebet'     => $ss,
            'keterangan'    => $r->input('keterangan')
        ]);

        $pinj = Pinjaman::find($id);
        $bay = Pembayaran::where('id_pinjaman', $pinj->id)->max('bulan_ke');
        if ($r->input('bakhir') == $bay) {
            $msg = "Pembayaran Berhasil di Dilakukan dan SEALAMAT PINJAMAN TELAH LUNAS";
            $alert = Toastr::success($msg, $title = "PINJAMAN LUNAS", $options = []);
            $pinj->update(['status_lunas' => 'Y']);
        } else {
            $msg = "Pembayaran Berhasil di Dilakukan";
            $alert = Toastr::success($msg, $title = "Pembayaran", $options = []);
        }

            date_default_timezone_set('Asia/Jakarta');
            $header = JurnalHeader::create([
                'tipe' => "KREDIT",
                'kode_jurnal' => $this->_generatekodejurnal(),
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => 'BYR'
            ]);

            if ($cara_bayar == "Simpanan") {
                $ids = $r->input('pilih_simpanan');
                $akumulasi = Akumulasi::where('id_simpanan', $ids)->first();
                $saldonya = $akumulasi->saldo - $btotal;
                $simp = Simpanan::find($ids);
                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $simp->pengaturanid->akun_penarikan,
                    'debet' => $btotal,
                    'kredit' => "",
                    'nominal' => $btotal
                ]);

                $tran = Transaksi::create([
                    'kode' => $this->_generate(),
                    'tipe' => "TPINJAMAN",
                    'id_simpanan' => $ids,
                    'id_dari' => $ids,
                    'saldo_awal' => $akumulasi->saldo,
                    'nominal' => $btotal,
                    'saldo_akhir' => $saldonya,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'kredit' => "",
                    'debet' => $saldonya,
                    'status' => "AKTIF",
                    'keterangan' => "Transaksi Pinjaman : " . $simp->anggotaid->nama,
                    'info' => "TPINJAMAN : " . $simp->anggotaid->nama
                ]);;

                $ak = Akumulasi::find($akumulasi->id);
                $ak->update([
                    'saldo' => $saldonya
                ]);
            } else {
                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $pinj->pengaturanid->akun_kas_bank,
                    'debet' => $btotal,
                    'kredit' => "",
                    'nominal' => $btotal
                ]);
            }

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

        $nom = Nomor::where('modul', 'Pinjaman')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);
        
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format2 = Nomor::find($nom2->id);
        $format2->update(['nomor_now' => $nom2->nomor_now + 1]);

        return redirect('pinjaman/pembayaran')->with('alert', $alert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::find($id);
        $pembayar = Pembayaran::where('id_pinjaman', $pembayaran->id_pinjaman)->where('start', '1')->get();
        $bayarlast = Pembayaran::where('id_pinjaman', $pembayaran->id_pinjaman)->orderBy('cara_bayar', 'desc')->first();
        $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $perkiraan = Perkiraan::all();
        $pinjaman = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->get();
        $simpanan = Simpanan::all();
        if ($pembayaran->tanggal_bayar > $pembayaran->tanggal) {
            $hari = ((abs(strtotime ($$pembayaran->tanggal_bayar) - strtotime ($pembayaran->tanggal)))/(60*60*24));
        } else {
            $hari = 0;
        }

        $tglreal = explode('-',$pembayaran->pinjamanid->realisasiid->tanggal_realisasi);
        $tgljth = explode('-',$bayarlast->tanggal);
        $tgljthper = explode('-',$pembayaran->tanggal);
        $tgltran = explode('-',$pembayaran->tanggal_bayar);
                $tgl_real = $tglreal[1]."/".$tglreal[2]."/".$tglreal[0];
                $tgl_tempo = $tgljth[1]."/".$tgljth[2]."/".$tgljth[0];
                $tgl_periode = $tgljthper[1]."/".$tgljthper[2]."/".$tgljthper[0];
                $tgl_bayar = $tgltran[1]."/".$tgltran[2]."/".$tgltran[0];

        return view('pinjaman.pembayaran.lihat_pembayaran')->with('pinjaman', $pinjaman)
            ->with('today', $today)
            ->with('perkiraan', $perkiraan)
            ->with('simpanan', $simpanan)
            ->with('sistem_bunga', $sistem_bunga)
            ->with('pembayaran', $pembayaran)
            ->with('pembayar', $pembayar)
            ->with('hari', $hari)
            ->with('tgl_real', $tgl_real)
            ->with('tgl_tempo', $tgl_tempo)
            ->with('tgl_periode', $tgl_periode)
            ->with('tgl_bayar', $tgl_bayar);

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
        $msgclass = "success";
        $msg = "Data Berhasil di Hapus";

        $pembayaran =  Pembayaran::findOrNew($id);
        $pembayaran->update(['status' => 'VOID']);

        return redirect(url()->previous())
            ->with('msgclass', $msgclass)
                ->with('msg', $msg);
    }

    public function _generate() {
        $nom = Nomor::where('modul', 'Pinjaman')->first();

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

        $digit = intval($last_digit) + 1;
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


    public function simulasi() {
        return view('pinjaman.pembayaran.simulasi_pembayaran');
    }

    public function listbayar($idp) {
        $pembayaran = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->get();
        echo '<table id="table" class="table table-bordered table-striped mg-t editable-datatable scroll" style="height:300px; display: -moz-groupbox;">';
        echo '<thead>';
        echo '<tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">';
        echo '<th class="text-center" width="70">No</th>';
        echo '<th class="text-center">Tanggal Bayar</th>';
        echo '<th class="text-center">Jumlah</th>';
        echo '<th class="text-center">Saldo</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody style="overflow-y: scroll;height: 250px;width: auto;position: absolute;">';
        $i = 0;
        foreach($pembayaran as $tampil) {
            echo '<tr style="width: 100%;display: inline-table;table-layout: fixed;">';
            echo '<td class="text-center" width="70">' . $i++ . '</td>';
            echo '<td>'.$tampil->tanggal_bayar.'</td>';
            echo '<td>'.number_format($tampil->pokok, 2, '.', ',').'</td>';
            echo '<td>'.number_format($tampil->saldo, 2, '.', ',').'</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';

    }

    public function bayarajax($idp) {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        
        $pinjaman = Pinjaman::findOrNew($idp);

        $real = Realisasi::where('id_pinjaman', $idp)->first();
        $bayar = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->max('bulan_ke');
        $next = $bayar+1;
        $bayarnext = Pembayaran::where('id_pinjaman', $idp)->where('bulan_ke', $next)->first();
        $bayarlast = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->orderBy('bulan_ke', 'desc')->first();

//        $jtempo = $pinjaman->tanggal_pengajuan;
//        $jtempo2 = strtotime('+'.$next.' month', strtotime($jtempo));// jangka waktu + 365 hari
//        $tgltempo=date("Y-m-d",$jtempo2);//tanggal expired
        $toldenda = $pinjaman->pengaturanid->toleransi_denda;
        $mindenda = strtotime('+'.$toldenda.' day', strtotime($bayarnext->tanggal));// jangka waktu + 365 hari
        $tgldenda=date("Y-m-d",$mindenda);//tanggal expired

        if ($today > $tgldenda) {
            $hari = ((abs(strtotime ($today) - strtotime ($tgldenda)))/(60*60*24));
            if ($pinjaman->pengaturanid->tipe_denda_perhari == "denda_nominal") {
                $dendanya = $pinjaman->pengaturanid->jumlah_denda_perhari * $hari;
            } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "saldo_X_persen%_X_hari") {
                $bayarnya = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->where('bulan_ke', $bayar)->first();
                $dendanya = $bayarnya->saldo * $pinjaman->pengaturanid->persen_denda_perhari/100 * $hari;
            } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "angsuran_X_persen%_X_hari") {
                $dendanya = $bayarnext->pokok * $pinjaman->pengaturanid->persen_denda_perhari/100 * $hari;
            }
        } else {
            $hari = 0;
            $dendanya = 0;
        }

        if ($pinjaman->perhitungan_bunga == "bulanan") {
            $bunganya = $bayarnext->bunga;
        } else {
            $hari2 = ((abs(strtotime ($today) - strtotime ($bayarlast->tanggal)))/(60*60*24));
            $hari3 = ((abs(strtotime ($bayarnext->tanggal) - strtotime ($bayarlast->tanggal)))/(60*60*24));
//            $bunganya = $bayarnext->saldo * $pinjaman->pengaturanid->suku_bunga / 100 / 365 * $hari2;
            $bunganya = $bayarnext->bunga / $hari3 * $hari2;
        }

        $tglreal = explode('-',$real->tanggal_realisasi);
        $tgljth = explode('-',$bayarlast->tanggal);
        $tgljthper = explode('-',$bayarnext->tanggal);

        $total = $bayarnext->pokok + $bunganya + $dendanya;
        $byr = Pembayaran::find($bayarnext->id);
        $byr->update(['bunga' => $bunganya, 'denda' =>$dendanya, 'total' => $total]);

            $stat = "OK";
            $title = "";
            $psg = "";
            $data[] = array(
                'id' => $pinjaman->id,
                'jenis' => $pinjaman->pengaturanid->nama_pinjaman,
                'nama' => $pinjaman->anggotaid->nama,
                'alamat' => $pinjaman->anggotaid->alamat . ", " . $pinjaman->anggotaid->kota . ", " . $pinjaman->anggotaid->provinsi,
                'tgl_real' => $tglreal[1]."/".$tglreal[2]."/".$tglreal[0],
                'tgl_tempo' => $tgljth[1]."/".$tgljth[2]."/".$tgljth[0],
                'tgl_periode' => $tgljthper[1]."/".$tgljthper[2]."/".$tgljthper[0],
                'realisasi' => number_format($real->realisasi, 2, '.', ','),
                'bpokok' => number_format($bayarnext->pokok, 2, '.', ','),
                'bbunga' => number_format($bunganya, 2, '.', ','),
                'btotal' => number_format($total, 2, '.', ','),
                'sbunga' => $real->suku_bunga,
                'jwaktu' => $real->jangka_waktu,
                'idpem' => $bayarnext->id,
                'bakhir' => $bayarnext->bulan_ke,
                'simb' => $pinjaman->pengaturanid->sbunga->sistem,
                'simbid' => $pinjaman->pengaturanid->sistem_bunga,
                'bdenda' => number_format($dendanya, 2, '.', ','),
                'stat' => $stat,
                'title' => $title,
                'psg'   => $psg,
                'hari_ke' => $bayarnext->bulan_ke,
                'hari_terlambat' => $hari
            );

        return json_encode($data);
    }

    public function bayartotal(Request $request) {
        $bayarpokok = str_replace(",","",$request->bpokok);
        $bpokok = str_replace(".00","",$bayarpokok);

        $bayarbunga = str_replace(",","",$request->bbunga);
        $bbunga = str_replace(".00","",$bayarbunga);

        $bayardenda = str_replace(",","",$request->bdenda);
        $bdenda = str_replace(".00","",$bayardenda);

        $total = $bpokok + $bbunga + $bdenda;
        $data[] = array(
            'btotal'    => number_format($total, 2, '.', ',')
        );

        return json_encode($data);
    }

    public function cekaturan() {
        $nom = Nomor::where('modul', 'Pinjaman')->first();

        if($nom == null){
            $stat = "FAIL";
            $title = "Format Nomor Pembayaran";
            $psg = "Format nomor Pembayaran  belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
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

    public function loadsaldo($ids) {
        $simp = Simpanan::find($ids);
        $saldo = number_format($simp->akumulasiid->saldo, 2, '.', ',');
        echo '<input type="text" class="form-control" id="saldo-simpanan" placeholder="Saldo Simpanan" value="'.$saldo.'" readonly>';
    }

    public function ceksaldo($idp, $total) {
        $bayartotal = str_replace(",","",$total);
        $btotal = str_replace(".00","",$bayartotal);

        $simpanan = Simpanan::find($idp);
        $bsaldo = $simpanan->akumulasiid->saldo;

        if ($simpanan->status == 1) {
            $blk = "telah DiBlokir";
        } else if ($simpanan->status == 2) {
            $blk = "Sudah DiTutup";
        } else {
            $blk = "";
        }

        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

        if ($simpanan->status != 0) {
            $stat = "FAIL";
            $title = "GAGAL BAYAR";
            $psg = "Simpanan ".$simpanan->nomor_simpanan." ".$blk;
        } else if($nom2 == null){
            $stat = "FAIL";
            $title = "Format Nomor Jurnal Otomatis";
            $psg = "Format nomor untuk Jurnal Otomatis belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
        } else if($bsaldo < $btotal){
            $stat = "FAIL";
            $title = "GAGAL BAYAR";
            $psg = "Saldo Simpanan lebih kecil dari Total Angsuran";
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

    public function cekauto($auto) {
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

//        if ($auto == "confauto") {
//            $stat = "FAIL";
//            $title = "GAGAL BAYAR";
//            $psg = "Pembayaran Pinjaman masih menunggu konfirmasi AUTODEBET";
//        }

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

    public function testSimulasi($idsistembunga,$idpinjaman)
    {
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
                    $bunga = $pinjaman->realisasiid->realisasi/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/12;
                }else {
//                    $bunga = $arr_pinjaman['jumlah_pengajuan']/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/365;
                    $bunga = $pinjaman->realisasiid->realisasi/$arr_pinjaman['jangka_waktu']*$arr_pinjaman['suku_bunga']/100/365;
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
                        echo number_format($pinjaman->realisasiid->realisasi, 2, '.', ',');
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
                        echo number_format($pinjaman->realisasiid->realisasi-=$pokok, 2, '.', ',');
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
                $pokok = $pinjaman->realisasiid->realisasi/$arr_pinjaman['jangka_waktu'];
//                $bungath = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100;
                $bungath = $pinjaman->realisasiid->realisasi*$arr_pinjaman['suku_bunga']/100;
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
                        echo number_format($pinjaman->realisasiid->realisasi, 2, '.', ',');
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
                        echo number_format($pinjaman->realisasiid->realisasi-=$pokok, 2, '.', ',');
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
                        echo number_format($pinjaman->realisasiid->realisasi-=$pokok, 2, '.', ',');
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
                $bungath = $pinjaman->realisasiid->realisasi*$arr_pinjaman['suku_bunga']/100;
//                $angsuran = $arr_pinjaman['jumlah_pengajuan']*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
                $angsuran = $pinjaman->realisasiid->realisasi*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
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
                $pokok_pinjaman = $pinjaman->realisasiid->realisasi-$pokok;
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
                        echo number_format($pinjaman->realisasiid->realisasi, 2, '.', ',');
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
                        $angsuran = $pinjaman->realisasiid->realisasi*$arr_pinjaman['suku_bunga']/100/12/(1-1/(pow(1+($arr_pinjaman['suku_bunga']/100/12),$arr_pinjaman['jangka_waktu'])));
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
}
