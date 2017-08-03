<?php

namespace App\Http\Controllers\Pinjaman;

use App\Approve;
use App\Approverole;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Master\Anggota;
use App\Model\Pengaturan\Nomor;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pengaturan;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Sistembunga;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class RescheduleController extends Controller
{
    public function index() {
        $pinjaman = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->paginate(20);
        $jml = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->count();
        return view('pinjaman.reschedule.index')->with('pinjaman', $pinjaman)->with('jml', $jml);
    }

    public function search(Request $r) {
        $query = $r->input('query');
        $pinjaman = Pinjaman::where('nama_pinjaman','like','%'.$query.'%')->orWhere('nomor_pinjaman','like','%'.$query.'%')->orWhereHas('anggotaid', function($querys) use ($query){
            $querys->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
        })->orderBy('id','desc')->paginate(20);

        $jml = $pinjaman->where('status_realisasi', 'Y')->where('status_lunas', 'N')->count();
        return view('pinjaman.reschedule.cari')->with('query',$query)->with('pinjaman', $pinjaman)->with('jml',$jml);
    }

    public function create() {
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        $sistem = Sistembunga::where('untuk', 'pinjaman')->get();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $anggota = Anggota::where('status', 'AKTIF')->get();
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now()->format('m/d/Y');
        return view('pinjaman.reschedule.tambah_reschedule')->with('sistem', $sistem)->with('perkiraan', $perkiraan)->with('anggota', $anggota)->with('today', $today)->with('user', $user);
    }

    public function store(Request $request) {

        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/pinjaman/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "";
        }

        if ($request->hasFile('foto2'))
        {
            $file     = $request->foto2;
            $filename2 = $file->getClientOriginalName();

            $destinationPath = 'foto/pinjaman/';
            $file->move($destinationPath, $filename2);

        } else {
            $filename2 = "";
        }
        $dendaperhari = str_replace(",","",$request->jumlah_denda_perhari);
        $dendap = str_replace(".00","",$dendaperhari);

        $valatur = Pengaturan::where('kode', $request->kode)->orWhere('nama_pinjaman', $request->nama_pinjaman)->first();
        if ($valatur == null) {
            date_default_timezone_set('Asia/Jakarta');
            $today = date('Y-m-d');
            $pinj = Pinjaman::where('re', '1')->where('status_lunas', 'N')->where('parent', '-1')->get();
            $s = 0;
            $t = 0;
            $u = 0;
            foreach ($pinj as $get) {
                $pinjaman = Pinjaman::find($get->id);
                $pinnya = Pinjaman::find($get->id);
                $pinnya->update(['status_lunas' => 'Y', 'status_tutup' => 1]);
                $bayarnya = Pembayaran::where('id_pinjaman', $get->id)->where('start', 0)->get();
                foreach ($bayarnya as $byr) {

                    $pembayaran = Pembayaran::where('id_pinjaman', $get->id)->where('start', '1')->orderBy('id', 'desc')->first();
                    $bayarnext = Pembayaran::find($byr->id);
                    $bayarlast = Pembayaran::where('id_pinjaman', $get->id)->where('start', '1')->orderBy('bulan_ke', 'desc')->first();

                    $toldenda = $pinjaman->pengaturanid->toleransi_denda;
                    $mindenda = strtotime('+' . $toldenda . ' day', strtotime($bayarnext->tanggal));// jangka waktu + 365 hari
                    $tgldenda = date("Y-m-d", $mindenda);//tanggal expired

                    if ($today > $tgldenda) {
                        $hari = ((abs(strtotime($today) - strtotime($tgldenda))) / (60 * 60 * 24));
                        if ($pinjaman->pengaturanid->tipe_denda_perhari == "denda_nominal") {
                            $dendanya = $pinjaman->pengaturanid->jumlah_denda_perhari * $hari;
                        } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "saldo_X_persen%_X_hari") {
                            $bayarnya = Pembayaran::where('id_pinjaman', $get->id)->where('start', '1')->where('bulan_ke', $pembayaran->bulan_ke)->first();
                            $dendanya = $bayarnya->saldo * $pinjaman->pengaturanid->persen_denda_perhari / 100 * $hari;
                        } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "angsuran_X_persen%_X_hari") {
                            $dendanya = $bayarnext->pokok * $pinjaman->pengaturanid->persen_denda_perhari / 100 * $hari;
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
                        $bunganya = $bayarnext->bunga / $hari3 * $hari2;
                    }

                    $total = $bayarnext->pokok + $bunganya + $dendanya;
                    $bayr = Pembayaran::find($bayarnext->id);
                    $bayr->update(['bunga' => $bunganya, 'denda' => $dendanya, 'total' => $total]);
                }

                $bayarpokok = Pembayaran::where('id_pinjaman', $get->id)->where('start', '0')->sum('pokok');
                $bayarbunga = Pembayaran::where('id_pinjaman', $get->id)->where('start', '0')->sum('bunga');
                $bayardenda = Pembayaran::where('id_pinjaman', $get->id)->where('start', '0')->sum('denda');

                $s+=$bayarpokok;
                $t+=$bayarbunga;
                $u+=$bayardenda;

                $datanya[] = array(
                    'idpnya'   => $get->id,
                    'pokoknya' => $bayarpokok,
                    'bunganya' => $bayarbunga,
                    'dendanya' => $bayardenda
                );

                date_default_timezone_set('Asia/Jakarta');
                $header = JurnalHeader::create([
                    'tipe'      => "KREDIT",
                    'kode_jurnal'   => "TTP".$this->_generatekodejurnal(),
                    'tanggal'   => date('Y-m-d H:i:s'),
                    'keterangan'=> 'TUTUP PINJAMAN'
                ]);

                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $pinj->pengaturanid->akun_piutang_tak_tertagih,
                    'debet' => $bayarpokok + $bayarbunga,
                    'kredit' => "",
                    'nominal' => $bayarpokok + $bayarbunga
                ]);

                $detail2 = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $pinj->pengaturanid->akun_piutang_pinjaman,
                    'debet' => "",
                    'kredit' => $bayarpokok,
                    'nominal' => $bayarpokok
                ]);

                $detail3 = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $pinj->pengaturanid->akun_bunga,
                    'debet' => "",
                    'kredit' => $bayarbunga,
                    'nominal' => $bayarbunga
                ]);
            }
            $jpengajuan = $s + $t + $u;

            $pengaturan = Pengaturan::create([
                'kode' => $request->kode,
                'nama_pinjaman' => $request->nama_pinjaman,
                'suku_bunga' => $request->suku_bunga,
                'sistem_bunga' => $request->sistem_bunga,
                'maksimum_waktu' => $request->maksimum_waktu,
                'tipe_maksimum_waktu' => "bulan",                       
                'tipe_denda_perhari' => $request->tipe_denda_perhari,
                'jumlah_denda_perhari' => $dendap,
                'persen_denda_perhari' => $request->persen_denda_perhari,
                'toleransi_denda' => $request->toleransi_denda,
                'akun_kas_bank' => $request->akun_kas_bank,
                'akun_realisasi' => $request->akun_realisasi,
                'akun_angsuran' => $request->akun_angsuran,
                'akun_bunga' => $request->akun_bunga,
                'akun_administrasi' => $request->akun_administrasi,
                'akun_administrasi_bank' => $request->akun_administrasi_bank,
                'akun_administrasi_tambahan' => $request->akun_administrasi_tambahan,
                'akun_denda' => $request->akun_denda,
                'biaya_provinsi' => $request->biaya_provinsi,
                'akun_lain_lain' => $request->akun_lain_lain,
                'akun_hapus_pinjaman' => $request->akun_piutang_tak_tertagih,
                'akun_piutang_pinjaman' => $request->akun_piutang_pinjaman,
                'akun_tampungan_pinjaman' => $request->akun_tampungan_pinjaman,
                'akun_piutang_tak_tertagih' => $request->akun_piutang_tak_tertagih,
                'kode_awal_rekening' => $request->kode_awal_rekening,
                'jumlah_digit_rekening' => $request->jumlah_digit_rekening,
                'nomor_akhir_rekening' => $request->nomor_akhir_rekening,
                'gambar' => $filename,
                'gambar2' => $filename2
            ]);

            $format = 'm/d/Y';
            $tanggal_pengajuan = Carbon::createFromFormat($format,$request->tanggal_pengajuan)->toDateString();
            $jatuh_tempo = Carbon::createFromFormat($format,$request->jatuh_tempo)->toDateString();
            $pinjaman = Pinjaman::create([
                'nama_pinjaman'      => $pengaturan->id,
                'nomor_pinjaman'     => $this->generate($pengaturan->id),
                'anggota'            => $request->kode_anggota,
                'suku_bunga'         => $request->suku_bunga,
                'tanggal_pengajuan'  => $tanggal_pengajuan,
                'jumlah_pengajuan'   => $jpengajuan,
                'jangka_waktu'       => $request->jangka_waktu,
                'jatuh_tempo'        => $jatuh_tempo,
                'jumlah_angsuran_pokok'  => $jpengajuan / $request->jangka_waktu,
                'perhitungan_bunga'      => $request->perhitungan_bunga,
                'digunakan_untuk'        => $request->digunakan_untuk,
                'sumber_dana'            => $request->sumber_dana,
                'kolektibilitas'         => 1,
                'keterangan'             => $request->keterangan,
                'status_realisasi'       => "N",
                'status_lunas'           => "N",
                're'                     => 2
            ]);

            foreach ($pinj as $get) {
                $pinnya = Pinjaman::find($get->id);
                $pinnya->update(['re' => 0, 'parent' => $pinjaman->id]);
            }

            for ($i=0; $i < count($request['levels']); $i++) {
                $approve = Approverole::create([
                    'id_user'   => $request['users'][$i],
                    'id_for'    => $pengaturan->id,
                    'for'       => "pinjaman",
                    'level'     => $request['levels'][$i]
                ]);
            }

            date_default_timezone_set('Asia/Jakarta');
            $header4 = JurnalHeader::create([
                'tipe'      => "KREDIT",
                'kode_jurnal'   => "RSC".$this->_generatekodejurnal(),
                'tanggal'   => date('Y-m-d H:i:s'),
                'keterangan'=> 'RESCHEDULE PINJAMAN PENUTUPAN'
            ]);

            $detail41 = JurnalDetail::create([
                'id_header' => $header4->id,
                'id_akun' => $pinjaman->pengaturanid->akun_tampungan_pinjaman,
                'debet' => $s + $t + $u,
                'kredit' => "",
                'nominal' => $s + $t + $u,
            ]);

            foreach ($datanya as $item) {
                $pinjj = Pinjaman::find($item['idpnya']);
                $dendanya = 0;
                $dendanya = $item['dendanya'];
                $detail41 = JurnalDetail::create([
                    'id_header' => $header4->id,
                    'id_akun' => $pinjj->pengaturanid->akun_piutang_pinjaman,
                    'debet' => "",
                    'kredit' => $item['pokoknya'],
                    'nominal' => $item['pokoknya'],
                ]);

                $detail42 = JurnalDetail::create([
                    'id_header' => $header4->id,
                    'id_akun' => $pinjj->pengaturanid->akun_bunga,
                    'debet' => "",
                    'kredit' => $item['bunganya'],
                    'nominal' => $item['bunganya'],
                ]);

                if ($dendanya > 0) {
                    $detail42 = JurnalDetail::create([
                        'id_header' => $header4->id,
                        'id_akun' => $pinjj->pengaturanid->akun_denda,
                        'debet' => "",
                        'kredit' => $item['dendanya'],
                        'nominal' => $item['dendanya'],
                    ]);
                }
            }

            $header = JurnalHeader::create([
                'tipe'      => "KREDIT",
                'kode_jurnal'   => "RSC".$this->_generatekodejurnal(),
                'tanggal'   => date('Y-m-d H:i:s'),
                'keterangan'=> 'RESCHEDULE PINJAMAN BARU'
            ]);

            $detail = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $pinjaman->pengaturanid->akun_piutang_pinjaman,
                'debet' => $s + $t + $u,
                'kredit' => "",
                'nominal' => $s + $t + $u,
            ]);

            $detail2 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $pinjaman->pengaturanid->akun_tampungan_pinjaman,
                'debet' => "",
                'kredit' => $s + $t + $u,
                'nominal' => $s + $t + $u
            ]);

//            $detail3 = JurnalDetail::create([
//                'id_header' => $header->id,
//                'id_akun' => $pinj->pengaturanid->akun_bunga,
//                'debet' => "",
//                'kredit' => $t,
//                'nominal' => $t
//            ]);
//            if ($u > 0) {
//                $detail3 = JurnalDetail::create([
//                    'id_header' => $header->id,
//                    'id_akun' => $pinj->pengaturanid->akun_denda,
//                    'debet' => "",
//                    'kredit' => $u,
//                    'nominal' => $u
//                ]);
//            }

            $msg = "Data Berhasil di Ditambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Pinjaman", $options = []);
        } else {
            if ($request->kode == $valatur->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_pinjaman == $valatur->nama_pinjaman) {
                $dg = "dengan nama pinjaman : ".$request->nama_pinjaman;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Pinjaman", $options = []);
        }

        return redirect(url('pinjaman'))->with('alert', $alert);
    }
    
    public function addpinjaman(Request $request) {
        if(count($request->cbpilih)>0){
            $allpinjaman = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->get();
            foreach ($allpinjaman as $get) {
                $pinj = Pinjaman::find($get->id);
                $pinj->update(['re' => 0, 'parent' => 0]);
            }

            foreach ($request->cbpilih as $idpinjaman  => $siswaid) {
                $pinjaman = Pinjaman::find($idpinjaman);
                $pinjaman->update(['re' => 1, 'parent' => -1]);
            }

            $msg = "Berhasil! <br> Data Pinjaman berhasil DiPilih";
            $alert = Toastr::success($msg, $title = "Pilih Pinjaman", $options = []);

            return redirect(url('pinjaman/reschedule/create'))
                ->with('alert', $alert);
        } else if(count($request->cbpilih)<=0){
            $msg = "Gagal! <br> Tidak ada data pinjaman yang dipilih";
            $alert = Toastr::error($msg, $title = "Pilih Pinjaman", $options = []);

            return redirect(url('pinjaman/reschedule'))
                ->with('alert', $alert);
        }
    }

    public function generate($id) {
        $gen = Pengaturan::findOrNew($id);

        $last_data = Pinjaman::where('nama_pinjaman', $id)->orderBy('id', 'DESC')->first();
        $last_digit = 0;
        $last_length = 0;
        $l = 1;

        if(count($last_data) > 0){
            $nomor_pinjaman = explode('.', $last_data->nomor_pinjaman);
            $last_digit = (int) $nomor_pinjaman[1];
            $last_length = strlen($last_digit);
            $l = 0;
        }

        $digit = "";
        for ($i=$l; $i < $gen->jumlah_digit_rekening - $last_length; $i++) {
            $digit .= '0';
        }
        $digit .= intval($last_digit) + 1;
        $nomor = $gen->kode_awal_rekening .'.'. $digit;
        return $nomor;

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

    public function test() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $pinj = Pinjaman::where('re', '1')->where('status_lunas', 'N')->where('parent', '-1')->get();
        $pinjcount = Pinjaman::where('re', '1')->where('status_lunas', 'N')->where('parent', '-1')->count();
        $s = 0;
        $t = 0;
        $u = 0;
        foreach ($pinj as $get) {
            $pinjaman = Pinjaman::find($get->id);
//            $pinnya = Pinjaman::find($get->id);
//            $pinnya->update(['status_lunas' => 'Y', 'status_tutup' => 1]);
            $bayarnya = Pembayaran::where('id_pinjaman', $get->id)->where('start', 0)->get();
            foreach ($bayarnya as $key => $byr) {

                $pembayaran = Pembayaran::where('id_pinjaman', $get->id)->where('start', '1')->orderBy('id', 'desc')->first();
                $bayarnext = Pembayaran::find($byr->id);
                $bayarlast = Pembayaran::where('id_pinjaman', $get->id)->where('start', '1')->orderBy('bulan_ke', 'desc')->first();

                $toldenda = $pinjaman->pengaturanid->toleransi_denda;
                $mindenda = strtotime('+' . $toldenda . ' day', strtotime($bayarnext->tanggal));// jangka waktu + 365 hari
                $tgldenda = date("Y-m-d", $mindenda);//tanggal expired

                if ($today > $tgldenda) {
                    $hari = ((abs(strtotime($today) - strtotime($tgldenda))) / (60 * 60 * 24));
                    if ($pinjaman->pengaturanid->tipe_denda_perhari == "denda_nominal") {
                        $dendanya = $pinjaman->pengaturanid->jumlah_denda_perhari * $hari;
                    } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "saldo_X_persen%_X_hari") {
                        $bayarnya = Pembayaran::where('id_pinjaman', $get->id)->where('start', '1')->where('bulan_ke', $pembayaran->bulan_ke)->first();
                        $dendanya = $bayarnya->saldo * $pinjaman->pengaturanid->persen_denda_perhari / 100 * $hari;
                    } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "angsuran_X_persen%_X_hari") {
                        $dendanya = $bayarnext->pokok * $pinjaman->pengaturanid->persen_denda_perhari / 100 * $hari;
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
                    $bunganya = $bayarnext->bunga / $hari3 * $hari2;
                }

                $total = $bayarnext->pokok + $bunganya + $dendanya;
                $bayr = Pembayaran::find($bayarnext->id);
                $bayr->update(['bunga' => $bunganya, 'denda' => $dendanya, 'total' => $total]);
            }

            $bayarpokok = Pembayaran::where('id_pinjaman', $get->id)->where('start', '0')->sum('pokok');
            $bayarbunga = Pembayaran::where('id_pinjaman', $get->id)->where('start', '0')->sum('bunga');
            $bayardenda = Pembayaran::where('id_pinjaman', $get->id)->where('start', '0')->sum('denda');

            $s+=$bayarpokok;
            $t+=$bayarbunga;
            $u+=$bayardenda;

            $datanya[] = array(
                'pokoknya' => $bayarpokok
            );

        }
        $jpengajuan = $s;
//        dd($bayarpokok[130]);

        foreach ($datanya as $item) {
            echo $item['pokoknya']."<br>";
        }
    }

}
