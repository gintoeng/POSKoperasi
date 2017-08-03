<?php
/**
 * Created by PhpStorm.
 * User: rahman
 * Date: 1/4/16
 * Time: 10:27
 */

namespace app\Http\Controllers\Dashboard;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Penyusutandetail;
use App\Model\Master\Anggota;
use App\Http\Controllers\Controller;
use App\Model\Pengaturan\Nomor;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Pos\Transaksiheader;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
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

    public function _generatekodejurnal() {
        $nom = Nomor::where('modul', 'Penyusutan Aset')->first();

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

    public function home()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $penyusutan = Penyusutandetail::where('stat', 0)->get();
        foreach ($penyusutan as $get) {
            if ($get->tanggal == $today) {
                date_default_timezone_set('Asia/Jakarta');
                $header = JurnalHeader::create([
                    'tipe' => "ASET",
                    'kode_jurnal' => "PAST".$this->_generatekodejurnal(),
                    'tanggal' => date('Y-m-d H:i:s'),
                    'keterangan' => 'Penyusutan Aset'
                ]);

                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $penyusutan->asetid->akun_biaya_penyusutan,
                    'debet' => $penyusutan->penyusutan,
                    'kredit' => "",
                    'nominal' => $penyusutan->penyusutan
                ]);

                $detail2 = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $penyusutan->asetid->akun_akumulasi_penyusutan,
                    'debet' => "",
                    'kredit' => $penyusutan->penyusutan,
                    'nominal' => $penyusutan->penyusutan
                ]);
            }
        }

        if (Auth::user()->roleid->akses == "kasir") {
            if (Auth::user()->cabang == "") {
                $msgclass = "warning";
                $msg = "Cabang belum Disetting";
                Auth::logout();
                return redirect('login')->with('msgclass', $msgclass)->with('msg', $msg)->withInput();
            }
          return redirect(url('pos/penjualan'));
            
        } else if (Auth::user()->roleid->akses == "pos") {
            if (Auth::user()->cabang == "") {
                $msgclass = "warning";
                $msg = "Cabang belum Disetting";
                Auth::logout();
                return redirect('login')->with('msgclass', $msgclass)->with('msg', $msg)->withInput();
            }
          return redirect(url('pos/index'));

        } else {

            $tahun = date("Y");
            $tahun1 = $tahun - 1;
            $tahun2 = $tahun - 2;
            $tahun3 = $tahun - 3;

            $POSth1 = Transaksiheader::where('tanggal', 'like', '%'.$tahun1.'-%')->count();
            $POSth2 = Transaksiheader::where('tanggal', 'like', '%'.$tahun2.'-%')->count();
            $POSth3 = Transaksiheader::where('tanggal', 'like', '%'.$tahun3.'-%')->count();

            $jumHari = date('t', mktime(0, 0, 0, 01, 1, $tahun));
            $jumHari2 = date('t', mktime(0, 0, 0, 02, 1, $tahun));
            $jumHari3 = date('t', mktime(0, 0, 0, 03, 1, $tahun));
            $jumHari4 = date('t', mktime(0, 0, 0, 04, 1, $tahun));
            $jumHari5 = date('t', mktime(0, 0, 0, 05, 1, $tahun));
            $jumHari6 = date('t', mktime(0, 0, 0, 06, 1, $tahun));
            $jumHari7 = date('t', mktime(0, 0, 0, 07, 1, $tahun));
            $jumHari8 = date('t', mktime(0, 0, 0, '08', 1, $tahun));
            $jumHari9 = date('t', mktime(0, 0, 0, '09', 1, $tahun));
            $jumHari10 = date('t', mktime(0, 0, 0, 10, 1, $tahun));
            $jumHari11 = date('t', mktime(0, 0, 0, 11, 1, $tahun));
            $jumHari12 = date('t', mktime(0, 0, 0, 12, 1, $tahun));

            $CSjan = Anggota::where('tanggal_registrasi', '<=', $tahun."-01-".$jumHari)->count();
            $CSfeb = Anggota::where('tanggal_registrasi', '<=', $tahun."-02-".$jumHari2)->count();
            $CSmar = Anggota::where('tanggal_registrasi', '<=', $tahun."-03-".$jumHari3)->count();
            $CSapr = Anggota::where('tanggal_registrasi', '<=', $tahun."-04-".$jumHari4)->count();
            $CSmay = Anggota::where('tanggal_registrasi', '<=', $tahun."-05-".$jumHari5)->count();
            $CSjun = Anggota::where('tanggal_registrasi', '<=', $tahun."-06-".$jumHari6)->count();
            $CSjul = Anggota::where('tanggal_registrasi', '<=', $tahun."-07-".$jumHari7)->count();
            $CSaug = Anggota::where('tanggal_registrasi', '<=', $tahun."-08-".$jumHari8)->count();
            $CSsep = Anggota::where('tanggal_registrasi', '<=', $tahun."-09-".$jumHari9)->count();
            $CSoct = Anggota::where('tanggal_registrasi', '<=', $tahun."-10-".$jumHari10)->count();
            $CSnov = Anggota::where('tanggal_registrasi', '<=', $tahun."-11-".$jumHari11)->count();
            $CSdec = Anggota::where('tanggal_registrasi', '<=', $tahun."-12-".$jumHari12)->count();

            $Pinjan = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-01-%')->count();
            $Pinfeb = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-02-%')->count();
            $Pinmar = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-03-%')->count();
            $Pinapr = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-04-%')->count();
            $Pinmay = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-05-%')->count();
            $Pinjun = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-06-%')->count();
            $Pinjul = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-07-%')->count();
            $Pinaug = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-08-%')->count();
            $Pinsep = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-09-%')->count();
            $Pinoct = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-10-%')->count();
            $Pinnov = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-11-%')->count();
            $Pindec = Pinjaman::where('tanggal_pengajuan', 'like', '%'.$tahun.'-12-%')->count();

            $PinW = Pinjaman::where('status_realisasi', 'N')->where('status_lunas', 'N')->count();
            $PinR = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'N')->count();
            $PinL = Pinjaman::where('status_realisasi', 'Y')->where('status_lunas', 'Y')->count();

            $PinK1 = Pinjaman::where('kolektibilitas', 1)->count();
            $PinK2 = Pinjaman::where('kolektibilitas', 2)->count();
            $PinK3 = Pinjaman::where('kolektibilitas', 3)->count();
            $PinK4 = Pinjaman::where('kolektibilitas', 4)->count();
            $PinK5 = Pinjaman::where('kolektibilitas', 5)->count();

            return view('dashboard.home')->with('Pinjan', $Pinjan)->with('Pinfeb', $Pinfeb)->with('Pinmar', $Pinmar)->with('Pinapr', $Pinapr)->with('Pinmay', $Pinmay)->with('Pinjun', $Pinjun)->with('Pinjul', $Pinjul)->with('Pinaug', $Pinaug)->with('Pinsep', $Pinsep)->with('Pinoct', $Pinoct)->with('Pinnov', $Pinnov)->with('Pindec', $Pindec)
                ->with('CSjan', $CSjan)->with('CSfeb', $CSfeb)->with('CSmar', $CSmar)->with('CSapr', $CSapr)->with('CSmay', $CSmay)->with('CSjun', $CSjun)->with('CSjul', $CSjul)->with('CSaug', $CSaug)->with('CSsep', $CSsep)->with('CSoct', $CSoct)->with('CSnov', $CSnov)->with('CSdec', $CSdec)
                ->with('POSth1', $POSth1)->with('POSth2', $POSth2)->with('POSth3', $POSth3)->with('PinW', $PinW)->with('PinR', $PinR)->with('PinL', $PinL)
                ->with('PinK1', $PinK1)->with('PinK2', $PinK2)->with('PinK3', $PinK3)->with('PinK4', $PinK4)->with('PinK5', $PinK5);
        }
    }
}
