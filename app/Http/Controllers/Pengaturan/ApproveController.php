<?php

namespace App\Http\Controllers\Pengaturan;

use App\Approve;
use App\Approverole;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Pengaturan\Nomor;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use narutimateum\Toastr\Facades\Toastr;

class ApproveController extends Controller
{
    public function index_simpanan() {
        $approve = Approve::where('for', 'simpanan')->paginate(20);
        $jml = Approve::where('for', 'simpanan')->count();
        return view('pengaturan.approve.approve_index_simpanan')->with('approve', $approve)->with('jml', $jml);
    }

    public function index_pinjaman() {
        $approve = Approve::where('for', 'pinjaman')->paginate(20);
        $jml = Approve::where('for', 'pinjaman')->count();
        return view('pengaturan.approve.approve_index_pinjaman')->with('approve', $approve)->with('jml', $jml);
    }

    public function index_waserda() {
        $approve = Approve::where('for', 'waserda')->paginate(20);
        $jml = Approve::where('for', 'waserda')->count();
        return view('pengaturan.approve.approve_index_waserda')->with('approve', $approve)->with('jml', $jml);
    }

    public function search_simpanan(Request $request) {
        $query = $request->input('query');

        $approve = Approve::where('for', 'simpanan')->whereHas('transimpid', function($querys) use ($query){
            $querys->whereHas('simpananid', function($queryss) use ($query) {
                $queryss->where('nomor_simpanan','like','%'.$query.'%')->orWhereHas('pengaturanid', function($querysss) use ($query){
                    $querysss->where('jenis_simpanan','like','%'.$query.'%');
                })->orWhereHas('anggotaid', function($queryssss) use ($query){
                    $queryssss->where('nama','like','%'.$query.'%');
                });
            });
        })->paginate(20);
        $jml = Approve::where('for', 'simpanan')->whereHas('transimpid', function($querys) use ($query){
            $querys->whereHas('simpananid', function($queryss) use ($query) {
                $queryss->where('nomor_simpanan','like','%'.$query.'%')->orWhereHas('pengaturanid', function($querysss) use ($query){
                    $querysss->where('jenis_simpanan','like','%'.$query.'%');
                })->orWhereHas('anggotaid', function($queryssss) use ($query){
                    $queryssss->where('nama','like','%'.$query.'%');
                });
            });
        })->count();
        return view('pengaturan.approve.approve_search_simpanan')->with('approve', $approve)->with('jml', $jml)->with('query', $query);
    }

    public function search_pinjaman(Request $request) {
        $query = $request->input('query');
        $approve = Approve::where('for', 'pinjaman')->whereHas('pinjamanid', function($querys) use ($query){
            $querys->where('nomor_pinjaman','like','%'.$query.'%')->orWhereHas('pengaturanid', function($queryss) use ($query){
                $queryss->where('nama_pinjaman','like','%'.$query.'%');
            })->orWhereHas('anggotaid', function($querysss) use ($query){
                $querysss->where('nama','like','%'.$query.'%');
            });
        })->paginate(20);
        $jml = Approve::where('for', 'pinjaman')->whereHas('pinjamanid', function($querys) use ($query){
            $querys->where('nomor_pinjaman','like','%'.$query.'%')->orWhereHas('pengaturanid', function($queryss) use ($query){
                $queryss->where('nama_pinjaman','like','%'.$query.'%');
            })->orWhereHas('anggotaid', function($querysss) use ($query){
                $querysss->where('nama','like','%'.$query.'%');
            });
        })->count();
        return view('pengaturan.approve.approve_search_pinjaman')->with('approve', $approve)->with('jml', $jml)->with('query', $query);
    }

    public function search_waserda(Request $request) {

        $query = $request->input('query');
        $approve = Approve::where('for', 'waserda')->whereHas('pembwasid', function($querys) use ($query){
            $querys->where('nopembelian','like','%'.$query.'%')->orWhere('tanggal','like','%'.$query.'%')->orWhereHas('cabang', function($querysss) use ($query){
                $querysss->where('nama','like','%'.$query.'%');
            });
        })->paginate(20);
        $jml = Approve::where('for', 'waserda')->whereHas('pembwasid', function($querys) use ($query){
            $querys->where('nopembelian','like','%'.$query.'%')->orWhere('tanggal','like','%'.$query.'%')->orWhereHas('cabang', function($querysss) use ($query){
                $querysss->where('nama','like','%'.$query.'%');
            });
        })->count();
        return view('pengaturan.approve.approve_search_waserda')->with('approve', $approve)->with('jml', $jml)->with('query', $query);
    }

    public function level1($id) {
        $approve = Approve::find($id);
        $approve->update(['lev1' => 1]);

        if ($approve->for == "simpanan") {
            $approle = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->max('level');
            if ($approle == 1) {
                $jsimp = $this->__approvesimpanan($approve);
            }
        } elseif ($approve->for == "pinjaman") {
            $approle = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->max('level');
            if ($approle == 1) {
                $jpinj = $this->__approvepinjaman($approve);
            }
        } else {
            $approle = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->max('level');
            if ($approle == 1) {
                $jpemb = $this->__approvewaserda($approve);
            }
        }

        $msg = "LEVEL 1 Approved";
        $alert = Toastr::success($msg, $title = "L E V E L 1", $options = []);
        return redirect(url()->previous())->with('alert', $alert);
    }

    public function level2($id) {
        $approve = Approve::find($id);

        if ($approve->for == "simpanan") {
            $cekrole3 = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->where('level', '1')->first();
        } else if ($approve->for == "waserda"){
            $cekrole3 = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->where('level', '1')->first();
        } else {
            $cekrole3 = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->where('level', '1')->first();
        }
        if ($cekrole3 == null) {
            $rev = "OK";
            $no = 0;
        } else {
            if ($approve->lev1 == 1) {
                $rev = "OK";
                $no = 0;
            } else {
                $rev = "FAIL";
                $no = 1;
            }
        }

        if ($rev == "OK") {
            $approve->update(['lev2' => 1]);

            if ($approve->for == "simpanan") {
                $approle = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->max('level');
                if ($approle == 2) {
                    $jsimp = $this->__approvesimpanan($approve);
                }
            } elseif ($approve->for == "pinjaman") {
                $approle = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->max('level');
                if ($approle == 2) {
                    $jpinj = $this->__approvepinjaman($approve);
                }
            } else {
                $approle = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->max('level');
                if ($approle == 2) {
                    $jpemb = $this->__approvewaserda($approve);
                }
            }

            $msg = "LEVEL 2 Approved";
            $alert = Toastr::success($msg, $title = "L E V E L 2", $options = []);
        } else {
            $msg = "LEVEL ".$no." NOT Approved";
            $alert = Toastr::error($msg, $title = "L E V E L 2", $options = []);
        }
        return redirect(url()->previous())->with('alert', $alert);
    }

    public function level3($id) {
        $approve = Approve::find($id);

        if ($approve->for == "simpanan") {
            $cekrole2 = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->where('level', '2')->first();
        } else if ($approve->for == "pinjaman"){
            $cekrole2 = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->where('level', '2')->first();
        } else {
            $cekrole2 = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->where('level', '2')->first();
        }
        if ($cekrole2 == null) {
            if ($approve->for == "simpanan") {
                $cekrole3 = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->where('level', '1')->first();
            } else if ($approve->for == "pinjaman"){
                $cekrole3 = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->where('level', '1')->first();
            } else {
                $cekrole3 = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->where('level', '1')->first();
            }
            if ($cekrole3 == null) {
                $rev = "OK";
                $no = 0;
            } else {
                if ($approve->lev1 == 1) {
                    $rev = "OK";
                    $no = 0;
                } else {
                    $rev = "FAIL";
                    $no = 1;
                }
            }
        } else {
            if ($approve->lev2 == 1) {
                $rev = "OK";
                $no = 0;
            } else {
                $rev = "FAIL";
                $no = 2;
            }
        }

        if ($rev == "OK") {
            $approve->update(['lev3' => 1]);

            if ($approve->for == "simpanan") {
                $approle = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->max('level');
                if ($approle == 3) {
                    $jsimp = $this->__approvesimpanan($approve);
                }
            } elseif ($approve->for == "pinjaman") {
                $approle = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->max('level');
                if ($approle == 3) {
                    $jpinj = $this->__approvepinjaman($approve);
                }
            } else {
                $approle = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->max('level');
                if ($approle == 3) {
                    $jpemb = $this->__approvewaserda($approve);
                }
            }

            $msg = "LEVEL 3 Approved";
            $alert = Toastr::success($msg, $title = "L E V E L 3", $options = []);
        } else {
            $msg = "LEVEL ".$no." NOT Approved";
            $alert = Toastr::error($msg, $title = "L E V E L 3", $options = []);
        }
        return redirect(url()->previous())->with('alert', $alert);
    }

    public function release($id) {
        $approve = Approve::find($id);

        if ($approve->for == "simpanan") {
            $cekrole = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->where('level', '3')->first();
        } else if($approve->for == "pinjaman"){
            $cekrole = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->where('level', '3')->first();
        } else {
            $cekrole = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->where('level', '3')->first();
        }
        if ($cekrole == null) {
            if ($approve->for == "simpanan") {
                $cekrole2 = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->where('level', '2')->first();
            } else if($approve->for == "pinjaman"){
                $cekrole2 = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->where('level', '2')->first();
            } else {
                $cekrole2 = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->where('level', '2')->first();
            }
            if ($cekrole2 == null) {
                if ($approve->for == "simpanan") {
                    $cekrole3 = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->where('level', '1')->first();
                } else if($approve->for == "pinjaman"){
                    $cekrole3 = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->where('level', '1')->first();
                } else {
                    $cekrole3 = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->where('level', '1')->first();
                }
                if ($cekrole3 == null) {
                    $rev = "OK";
                    $no = 0;
                } else {
                    if ($approve->lev1 == 1) {
                        $rev = "OK";
                        $no = 0;
                    } else {
                        $rev = "FAIL";
                        $no = 1;
                    }
                }
            } else {
                if ($approve->lev2 == 1) {
                    $rev = "OK";
                    $no = 0;
                } else {
                    $rev = "FAIL";
                    $no = 2;
                }
            }
        } else {
            if ($approve->lev3 == 1) {
                $rev = "OK";
                $no = 0;
            } else {
                $rev = "FAIL";
                $no = 3;
            }
        }
        if ($rev == "OK") {
            $approve->update(['release' => 1]);

            if ($approve->for == "simpanan") {
                $approle = Approverole::where('for', 'simpanan')->where('id_for', $approve->transimpid->simpananid->jenis_simpanan)->max('level');
                if ($approle == 4) {
                    $jsimp = $this->__approvesimpanan($approve);
                }
            } elseif ($approve->for == "pinjaman") {
                $approle = Approverole::where('for', 'pinjaman')->where('id_for', $approve->pinjamanid->nama_pinjaman)->max('level');
                if ($approle == 4) {
                    $jpinj = $this->__approvepinjaman($approve);
                }
            } else {
                $approle = Approverole::where('for', 'waserda')->where('id_for', $approve->pembwasid->id_cabang)->max('level');
                if ($approle == 4) {
                    $jpemb = $this->__approvewaserda($approve);
                }
            }

            $msg = "RELEASE Approved";
            $alert = Toastr::success($msg, $title = "R E L E A S E", $options = []);
        } else {
            $msg = "LEVEL ".$no." NOT Approved";
            $alert = Toastr::error($msg, $title = "R E L E A S E", $options = []);
        }
        return redirect(url()->previous())->with('alert', $alert);
    }

    public function __approvesimpanan($approve) {

        $transimp = Transaksi::find($approve->id_for);
        $transimp->update(['approved' => 1]);

        $ids3 = $approve->transimpid->id_simpanan;
        $nominal = $approve->transimpid->nominal;

        $ak3 = Akumulasi::where('id_simpanan', $ids3)->first();
        $tipe = "TARIK";
        $saldo3 = $ak3->saldo - $nominal;

        $tr3 = Akumulasi::findOrNew($ak3->id);
        $tr3->update(['saldo' => $saldo3]);

        $tp3 = $tipe;
        $header3 = $this->_jurnalheader($tp3);
        $jurnal3 = $this->_isijurnalsimp($header3, $ids3, $tp3, $nominal);

        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return "OK";
    }

    public function __approvepinjaman($approve) {

        $pinjaman = Pinjaman::find($approve->id_for);
        $pinjaman->update(['approved' => 1]);

        $idp = $approve->id_for;
        $real = $approve->pinjamanid->realisasiid->realisasi;
        $biayaa = $approve->pinjamanid->realisasiid->biaya_administrasi;
        $biayaab = $approve->pinjamanid->realisasiid->biaya_administrasi_bank;
        $biayaat = $approve->pinjamanid->realisasiid->biaya_administrasi_tambahan;
        $biayap = $approve->pinjamanid->realisasiid->biaya_provinsi;
        $biayal = $approve->pinjamanid->realisasiid->biaya_lain;
        $uangd = $approve->pinjamanid->realisasiid->uang_diterima;

        $this->_isijurnalpinj($real, $biayaa,$biayaab,$biayaat, $biayap, $biayal, $uangd,  $idp);

        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return "OK";
    }

    public function __approvewaserda($approve) {
        $beli = pembelianSupplierHeader::find($approve->id_for);
        $beli->update(['approved' => 1]);

        return "OK";
    }

    public function _isijurnalsimp($header, $ids, $tp, $nominal) {

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
            JurnalDetail::create($detail1);
            JurnalDetail::create($detail2);
        }

        $jurnal = "OKE";
        return $jurnal;
    }

    public function _jurnalheader($tpt) {
        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "TABUNGAN",
            'kode_jurnal'   => "SIMP".$this->_generatekodejurnal(),
            'tanggal'   => date('Y-m-d H:i:s'),
            'keterangan'=> $tpt
        ]);

        $idh = $header->id;
        return $idh;
    }

    public function _isijurnalpinj($real, $biayaa,$biayaab,$biayaat, $biayap, $biayal, $uangd,  $idp){
        $pinj = Pinjaman::find($idp);

        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "KREDIT",
            'kode_jurnal'   => "REAPINJ".$this->_generatekodejurnal(),
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

        return "OK";
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
}
