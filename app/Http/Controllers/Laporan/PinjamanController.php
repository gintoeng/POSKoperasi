<?php

namespace App\Http\Controllers\Laporan;

use App\Model\Master\Anggota;
use App\Model\Master\Kolektibilitas;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pengaturan;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Pinjaman\Realisasi;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PinjamanController extends Controller
{
    public function dtpin() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $pinjaman = Pinjaman::all();
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        $kolektibilitas = Kolektibilitas::all();
        return view('laporan.pinjaman.data_pinjaman')->with('today', $today)
            ->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('kolektibilitas', $kolektibilitas)
            ->with('customer', $customer);
    }

    public function cetakdtpin(Request $request) {

        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
//            $df = explode('/', $request->dari);
//            $dt = explode('/', $request->ke);
//            $dfrom = $df[2] . '-' . $df[0] . '-' . $df[1];
//            $dto = $dt[2] . '-' . $dt[0] . '-' . $dt[1];
        } else {
            $dfrom = "";
            $dto = "";
        }

        $datenya = $dfrom." s/d ".$dto;

        $csdari = $request->csdari;
        $cske = $request->cske;
        $daripinj = $request->daripinj;
        $kepinj = $request->kepinj;

        $jp = $request->jenis_pinjaman;
        $jc = $request->jenis_customer;
        $kl = $request->kolektibilitas;
        $rea = $request->realisasi;

        $urut = $request->urut;
        $urutan = $request->urutan;

        if ($rea != "") {
            if ($kl != "") {
                if ($jc != "") {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                } else {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                }
            } else {
                if ($jc != "") {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                } else {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                }
            }
        } else {
            if ($kl != "") {
                if ($jc != "") {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                } else {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('kolektibilitas', $kl)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                }
            } else {
                if ($jc != "") {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('jenis_nasabah', $jc);
                                })->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                } else {
                    if ($csdari > 0 && $cske > 0) {
                        $c1 = Anggota::find($csdari);
                        $c2 = Anggota::find($cske);
                        $csnya = $c1->kode." - ".$c2->kode;
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                    $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                                })->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    } else {
                        $csnya = "-";
                        if ($jp != "") {
                            $pengaturan = Pengaturan::find($jp);
                            $jpnya = $pengaturan->nama_pinjaman;
                            if($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('nama_pinjaman', $jp)->orderBy($request->urut, $request->urutan)->get();
                            }
                        } else {
                            $jpnya = "";
                            if ($daripinj > 0 && $kepinj > 0) {
                                $p1 = Pinjaman::find($daripinj);
                                $p2 = Pinjaman::find($kepinj);
                                $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->orderBy($request->urut, $request->urutan)->get();
                            } else {
                                $pinjnya = "-";
                                $pinj = Pinjaman::where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                            }
                        }
                    }
                }
            }
        }


        if ($jp != "") {
            $pengaturan = Pengaturan::find($jp);
            $jpnya = $pengaturan->nama_pinjaman;
            if ($jc != "") {
                if ($csdari > 0 && $cske > 0) {
                    $c1 = Anggota::find($csdari);
                    $c2 = Anggota::find($cske);
                    $csnya = $c1->kode." - ".$c2->kode;
                    $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc)->get();
                } else {
                    $csnya = "-";
                    $customer = Anggota::where('jenis_nasabah', $jc)->get();
                }
            } else {
                if ($csdari > 0 && $cske > 0) {
                    $c1 = Anggota::find($csdari);
                    $c2 = Anggota::find($cske);
                    $csnya = $c1->kode." - ".$c2->kode;
                    $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->get();
                } else {
                    $csnya = "-";
                    $customer = Anggota::all();
                }
            }

            foreach($customer as $get) {
                if ($rea != "") {
                    if ($kl != "") {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        }
                    } else {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->orderBy($urut, $urutan)->get();
                        }
                    }
                } else {
                    if ($kl != "") {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        }
                    } else {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->orderBy($urut, $urutan)->get();
                        }
                    }
                }

                $pinjaman[] = $this->_forpinj($pinj);

            }
        } else {
            $jpnya = "";
            if ($jc != "") {
                if ($csdari > 0 && $cske > 0) {
                    $c1 = Anggota::find($csdari);
                    $c2 = Anggota::find($cske);
                    $csnya = $c1->kode." - ".$c2->kode;
                    $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', $jc)->get();
                } else {
                    $csnya = "-";
                    $customer = Anggota::where('jenis_nasabah', $jc)->get();
                }
            } else {
                if ($csdari > 0 && $cske > 0) {
                    $c1 = Anggota::find($csdari);
                    $c2 = Anggota::find($cske);
                    $csnya = $c1->kode." - ".$c2->kode;
                    $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->get();
                } else {
                    $csnya = "-";
                    $customer = Anggota::all();
                }
            }

            foreach($customer as $get) {
                if ($rea != "") {
                    if ($kl != "") {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        }
                    } else {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('status_realisasi', $rea)->orderBy($urut, $urutan)->get();
                        }
                    }
                } else {
                    if ($kl != "") {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->where('kolektibilitas', $kl)->orderBy($urut, $urutan)->get();
                        }
                    } else {
                        if ($daripinj > 0 && $kepinj > 0) {
                            $p1 = Pinjaman::find($daripinj);
                            $p2 = Pinjaman::find($kepinj);
                            $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                            $pinj = Pinjaman::where('anggota', $get->id)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->orderBy($urut, $urutan)->get();
                        } else {
                            $pinjnya = "-";
                            $pinj = Pinjaman::where('anggota', $get->id)->where('tanggal_pengajuan', '>=', $dfrom)->where('tanggal_pengajuan', '<=', $dto)->orderBy($urut, $urutan)->get();
                        }
                    }
                }
                $pinjaman[] = $this->_forpinj($pinj);

            }
        }

        $pdf = PDF::loadView('laporan.pinjaman.data_pinjaman_print', ['pinjaman' => $pinjaman, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'datenya' => $datenya]);

        if ($request->print == "preview") {
            return $pdf->setPaper('a4', 'landscape')->stream('Daftar-Pinjaman.pdf');
        } else {
            return $pdf->setPaper('a4', 'landscape')->download('Daftar-Pinjaman.pdf');
        }
    }

    public function _forpinj($pinj) {
        if ($pinj->count() > 0) {
            foreach ($pinj as $get2) {
                if ($get2->perhitungan_bunga == "bulanan") {
                    $b = "BULAN";
                } else {
                    $b = "HARI";
                }
                $data = array(
                    'nopinj' => $get2->nomor_pinjaman,
                    'nama' => $get2->anggotaid->nama,
                    'alamat' => $get2->anggotaid->alamat,
                    'telp' => $get2->anggotaid->telepon,
                    'waktu' => $get2->jangka_waktu . " " . $b,
                    'bunga' => $get2->suku_bunga,
                    'tgl' => $get2->tanggal_pengajuan,
                    'jml' => number_format($get2->jumlah_pengajuan, 2, '.', ','),
                    'jenis' => $get2->pengaturanid->nama_pinjaman,
                    'kolek' => $get2->kolektibilitasid->keterangan,
                );
            }
        } else {
            $data = array(
                'nopinj' => "",
                'nama' => "",
                'alamat' => "",
                'telp' => "",
                'waktu' => "",
                'bunga' => "",
                'tgl' => "",
                'jml' => "",
                'jenis' => "",
                'kolek' => "",
            );
        }

        return $data;
    }






    public function kopin() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $pinjaman = Pinjaman::all();
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        $kolektibilitas = Kolektibilitas::all();
        return view('laporan.pinjaman.kolektibilitas_pinjaman')->with('today', $today)
            ->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('kolektibilitas', $kolektibilitas)
            ->with('customer', $customer);
    }

    public function cetakkopin(Request $request) {

        if ($request->tgl != "") {
            $dfrom = date("Y-m-d", strtotime($request->tgl));
//            $df = explode('/', $request->tgl);
//            $dfrom = $df[2] . '-' . $df[0] . '-' . $df[1];
        } else {
            $dfrom = "";
        }

        $csdari = $request->csdari;
        $cske = $request->cske;
        $daripinj = $request->daripinj;
        $kepinj = $request->kepinj;

        $jp = $request->jenis_pinjaman;
        $jc = $request->jenis_customer;

        if ($jc != "") {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                $customer = Anggota::where('jenis_nasabah', $jc)->get();
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        } else {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        }

        $pinjaman = $this->_forkolek($pinj, $dfrom);
        $kolektibilitas = Kolektibilitas::all();
        foreach($kolektibilitas as $gg) {
            $data[] = array(
                'id'    => $gg->id,
                'idk'   => $gg->id,
                'kode'  => $gg->kode,
                'ket'    => $gg->keterangan
            );
        }

        $kolek = $data;

        if ($request->pilih == "dekolek") {
            $pdf = PDF::loadView('laporan.pinjaman.kolektibilitas_pinjaman_print', ['pinjaman' => $pinjaman, 'kolek' => $kolek, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'dfrom' => $dfrom]);
        } else {
            $pdf = PDF::loadView('laporan.pinjaman.kolektibilitas_pinjaman_print2', ['pinjaman' => $pinjaman, 'kolek' => $kolek, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'dfrom' => $dfrom]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Kolektibilitas-Pinjaman.pdf');
        } else {
            return $pdf->download('Daftar-Kolektibilitas-Pinjaman.pdf');
        }
    }

    public function _forkolek($pinj, $dfrom) {
        if ($pinj->count() > 0) {
            foreach ($pinj as $get2) {
                $real = Realisasi::where('id_pinjaman', $get2->id)->first();

                if ($real != null) {
                    $pembayaran = Pembayaran::where('id_pinjaman', $get2->id)->where('start', 1)->orderBy('bulan_ke', 'desc')->take(1)->get();
                    foreach ($pembayaran as $bayar) {
                        $ss = $bayar->saldo;
                    }
                    $saldo = $ss;
                } else {
                    $saldo = $get2->jumlah_pengajuan;
                }

                $dp = $get2->tanggal_pengajuan;
                $selisih = ((abs(strtotime($dfrom) - strtotime($dp))) / (60 * 60 * 24));
                $data[] = array(
                    'nopinj' => $get2->nomor_pinjaman,
                    'nama' => $get2->anggotaid->nama,
                    'saldo' => number_format($saldo, 2, '.', ','),
                    'sld' => $saldo,
                    'selisih' => $selisih,
                    'kolek' => $get2->kolektibilitas
                );
            }
        } else {
            $data[] = array(
                'nopinj' => "",
                'nama' => "",
                'saldo' => "",
                'sld' => 0,
                'selisih' => 0,
                'kolek' => ""
            );
        }

        return $data;
    }





    public function realpin() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $pinjaman = Pinjaman::all();
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        $kolektibilitas = Kolektibilitas::all();
        return view('laporan.pinjaman.realisasi_pinjaman')->with('today', $today)
            ->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('kolektibilitas', $kolektibilitas)
            ->with('customer', $customer);
    }

    public function cetakrealpin(Request $request) {

        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
//            $df = explode('/', $request->dari);
//            $dt = explode('/', $request->ke);
//            $dfrom = $df[2] . '-' . $df[0] . '-' . $df[1];
//            $dto = $dt[2] . '-' . $dt[0] . '-' . $dt[1];
        } else {
            $dfrom = "";
            $dto = "";
        }

        $datenya = $dfrom." s/d ".$dto;

        $csdari = $request->csdari;
        $cske = $request->cske;
        $daripinj = $request->daripinj;
        $kepinj = $request->kepinj;

        $jp = $request->jenis_pinjaman;
        $jc = $request->jenis_customer;

        if ($jc != "") {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('jenis_nasabah', $jc);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        } else {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                                $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            });
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('nama_pinjaman', $jp);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->whereHas('pinjamanid', function($querys) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske) {
                            $querys->where('id', '>=', $daripinj)->where('id', '<=', $kepinj);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $real = Realisasi::where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto)->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        }



            $realcount = $real->count();
            $realnya = $this->_forrea($real);

        $pdf = PDF::loadView('laporan.pinjaman.realisasi_pinjaman_print', ['realcount' => $realcount, 'realnya' => $realnya, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'datenya' => $datenya]);

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Realisasi-Pinjaman.pdf');
        } else {
            return $pdf->download('Daftar-Realisasi-Pinjaman.pdf');
        }
    }

    public function _forrea($real) {
        if ($real->count() > 0) {
            foreach ($real as $get3) {
                $data[] = array(
                    'nopinj' => $get3->pinjamanid->nomor_pinjaman,
                    'nama' => $get3->pinjamanid->anggotaid->nama,
                    'alamat' => $get3->pinjamanid->anggotaid->alamat,
                    'tgl' => $get3->tanggal_realisasi,
                    'jenis' => $get3->pinjamanid->pengaturanid->nama_pinjaman,
                    'jml' => number_format($get3->realisasi, 2, '.', ','),
                    'rea' => $get3->realisasi
                );
            }
        } else {
            $data[] = array(
                'nopinj' => "",
                'nama' => "",
                'alamat' => "",
                'tgl' => "",
                'jenis' => "",
                'jml' => "",
                'rea' => ""
            );
        }

        return $data;
    }





    public function saldopin() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $pinjaman = Pinjaman::all();
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        return view('laporan.pinjaman.saldo_pinjaman')->with('today', $today)
            ->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('customer', $customer);
    }

    public function cetaksaldopin(Request $request) {
        if ($request->tgl != "") {
            $dfrom = date("Y-m-d", strtotime($request->tgl));
//            $df = explode('/', $request->tgl);
//            $dfrom = $df[2] . '-' . $df[0] . '-' . $df[1];
        } else {
            $dfrom = "";
        }

        $csdari = $request->csdari;
        $cske = $request->cske;
        $daripinj = $request->daripinj;
        $kepinj = $request->kepinj;

        $jp = $request->jenis_pinjaman;
        $jc = $request->jenis_customer;

        if ($jc != "") {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('jenis_nasabah', $jc);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        } else {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::whereHas('anggotaid', function($query) use ($jc,$csdari,$cske) {
                            $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                        })->orderBy($request->urut, $request->urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::where('nama_pinjaman', $jp)->orderBy($request->urut, $request->urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pinj = Pinjaman::where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->orderBy($request->urut, $request->urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pinj = Pinjaman::orderBy($request->urut, $request->urutan)->get();
                    }
                }
            }
        }
        $pinjaman = $this->_forsaldo($pinj, $dfrom);

        if ($request->pilih == "lsld") {
            $pdf = PDF::loadView('laporan.pinjaman.saldo_pinjaman_print', ['pinjaman' => $pinjaman, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'dfrom' => $dfrom]);
        } else if($request->pilih == "lsldjeniscs") {
            $s = 0;
            $t = 0;
            $u = 0;
            foreach($pinjaman as $item) {
                if ($item['jcs'] == "UMUM") {
                    $s+=$item['sld'];
                } else if ($item['jcs'] == "BIASA") {
                    $t+=$item['sld'];
                } else {
                    $u+=$item['sld'];
                }
            }
            $sld['s'] = $s;
            $sld['t'] = $t;
            $sld['u'] = $u;
            $sld['z'] = $s+$t+$u;
            $pdf = PDF::loadView('laporan.pinjaman.saldo_pinjaman_print2', ['sld' => $sld,'pinjaman' => $pinjaman, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'dfrom' => $dfrom]);
        } else {
            $pengaturan = Pengaturan::all();
            foreach($pengaturan as $item) {
                $data[] = array(
                    'idp' => $item->id,
                    'idj' => $item->id,
                    'jenis' => $item->nama_pinjaman
                );
            }

            $aturan = $data;
            $pdf = PDF::loadView('laporan.pinjaman.saldo_pinjaman_print3', ['aturan' => $aturan, 'pinjaman' => $pinjaman, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'dfrom' => $dfrom]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Saldo-Pinjaman.pdf');
        } else {
            return $pdf->download('Daftar-Saldo-Pinjaman.pdf');
        }
    }

    public function _forsaldo($pinj, $dfrom) {
        if ($pinj->count() > 0) {
            foreach ($pinj as $get2) {
                $real = Realisasi::where('id_pinjaman', $get2->id)->first();

                if ($real != null) {
                    $pembayaran = Pembayaran::where('id_pinjaman', $get2->id)->where('start', 1)->orderBy('bulan_ke', 'desc')->take(1)->get();
                    foreach ($pembayaran as $bayar) {
                        $ss = $bayar->saldo;
                    }
                    $saldo = $ss;
                } else {
                    $saldo = $get2->jumlah_pengajuan;
                }

                $dp = $get2->tanggal_pengajuan;
                $selisih = ((abs(strtotime($dfrom) - strtotime($dp))) / (60 * 60 * 24));

                $data[] = array(
                    'nopinj' => $get2->nomor_pinjaman,
                    'nama' => $get2->anggotaid->nama,
                    'saldo' => number_format($saldo, 2, '.', ','),
                    'sld' => $saldo,
                    'selisih' => $selisih,
                    'jcs' => $get2->anggotaid->jenis_nasabah,
                    'idj' => $get2->nama_pinjaman
                );
            }
        } else {
            $data[] = array(
                'nopinj' => "",
                'nama' => "",
                'saldo' => "",
                'sld' => 0,
                'selisih' => 0,
                'jcs' => 0,
                'idj' => ""
            );

        }
        return $data;
    }





    public function tranpin() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $pinjaman = Pinjaman::all();
        $pengaturan = Pengaturan::all();
        $customer = Anggota::all();
        return view('laporan.pinjaman.transaksi_pinjaman')->with('today', $today)
            ->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('customer', $customer);
    }

    public function cetaktranpin(Request $request) {

        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
        } else {
            $dfrom = "";
            $dto = "";
        }

        $datenya = $dfrom." s/d ".$dto;

        $csdari = $request->csdari;
        $cske = $request->cske;
        $daripinj = $request->daripinj;
        $kepinj = $request->kepinj;

        $jp = $request->jenis_pinjaman;
        $jc = $request->jenis_customer;

        $urut = $request->urut;
        $urutan = $request->urutan;

//        dd($urut."  ||  ".$urutan);

        if ($jc != "") {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc)->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                $customer = Anggota::where('jenis_nasabah', $jc)->get();
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('jenis_nasabah', $jc);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                }
            }
        } else {
            if ($csdari > 0 && $cske > 0) {
                $c1 = Anggota::find($csdari);
                $c2 = Anggota::find($cske);
                $csnya = $c1->kode." - ".$c2->kode;
                $customer = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->get();
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->whereHas('anggotaid', function($querys) use ($jc,$csdari,$cske) {
                                $querys->where('id', '>=', $csdari)->where('id', '<=', $cske);
                            })->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                }
            } else {
                $csnya = "-";
                $customer = Anggota::all();
                if ($jp != "") {
                    $pengaturan = Pengaturan::find($jp);
                    $jpnya = $pengaturan->nama_pinjaman;
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('nama_pinjaman', $jp)->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                } else {
                    $jpnya = "";
                    if ($daripinj > 0 && $kepinj > 0) {
                        $p1 = Pinjaman::find($daripinj);
                        $p2 = Pinjaman::find($kepinj);
                        $pinjnya = $p1->nomor_pinjaman." - ".$p2->nomor_pinjaman;
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->where('id', '>=', $daripinj)->where('id', '<=', $kepinj)->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    } else {
                        $pinjnya = "-";
                        $pembayaran = Pembayaran::where('start', 1)->where('bulan_ke', '>', 0)->whereHas('pinjamanid', function($query) use ($jp,$daripinj,$kepinj, $jc,$csdari,$cske, $dfrom,$dto) {
                            $query->whereHas('realisasiid', function($queryss) use ($dfrom, $dto) {
                                $queryss->where('tanggal_realisasi', '>=', $dfrom)->where('tanggal_realisasi', '<=', $dto);
                            });
                        })->orderBy($urut, $urutan)->get();
                    }
                }
            }
        }
        $realcount = $pembayaran->count();
        $realnya  = $this->_fortran($pembayaran);


        if ($request->pilih == "tranpinj") {
            $pdf = PDF::loadView('laporan.pinjaman.transaksi_pinjaman_print', ['realcount' => $realcount, 'realnya' => $realnya, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'datenya' => $datenya]);
        } else if($request->pilih == "tranpinjre") {
            $pdf = PDF::loadView('laporan.pinjaman.transaksi_pinjaman_print2', ['realcount' => $realcount, 'realnya' => $realnya, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'datenya' => $datenya]);
        } else {
            $pdf = PDF::loadView('laporan.pinjaman.transaksi_pinjaman_print3', ['realcount' => $realcount, 'realnya' => $realnya, 'pinjnya' => $pinjnya, 'csnya' => $csnya, 'jc' => $jc, 'jpnya' => $jpnya, 'datenya' => $datenya]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Transaksi-Pinjaman.pdf');
        } else {
            return $pdf->download('Daftar-Transaksi-Pinjaman.pdf');
        }
    }

    public function _fortran($pembayaran) {
        if ($pembayaran->count() > 0) {
            foreach ($pembayaran as $get4) {
                $ppp = 0;
                $bbb = 0;
                $ddd = 0;
                $ttt = 0;
                $bayar = Pembayaran::where('id_pinjaman', $get4->id_pinjaman)->where('bulan_ke', '>', '0')->where('start', '1')->get();
                foreach ($bayar as $item) {
                    $ppp += $item->pokok;
                    $bbb += $item->bunga;
                    $ddd += $item->denda;
                    $ttt += $item->total;
                }
                $data[] = array(
                    'nopinj' => $get4->pinjamanid->nomor_pinjaman,
                    'nama' => $get4->pinjamanid->anggotaid->nama,
                    'tgl' => $get4->tanggal_bayar,
                    'pokok' => $get4->pokok,
                    'bunga' => $get4->bunga,
                    'denda' => $get4->denda,
                    'saldo' => $get4->saldo,
                    'total' => $get4->total,
                    'pokok2' => $ppp,
                    'bunga2' => $bbb,
                    'denda2' => $ddd,
                    'total2' => $ttt,
                    'idp' => $get4->id,
                    'idb' => $get4->bulan_ke
                );
            }
        } else {
            $data[] = array(
                'nopinj' => '',
                'nama' => '',
                'tgl' => '',
                'pokok' => 0,
                'bunga' => 0,
                'denda' => 0,
                'saldo' => 0,
                'total' => 0,
                'pokok2' => 0,
                'bunga2' => 0,
                'denda2' => 0,
                'total2' => 0,
                'idp' => '',
                'idb' => ''
            );
        }

        return $data;
    }
}
