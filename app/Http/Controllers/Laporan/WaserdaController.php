<?php

namespace App\Http\Controllers\Laporan;

use App\Model\Master\Anggota;
use App\Model\Master\Barang;
use App\Model\Master\Cabang;
use App\Model\Master\Kategori;
use App\Model\Master\Katshudetail;
use App\Model\Master\Mappingbarang;
use App\Model\Master\Unit;
use App\Model\Pos\Hpp;
use App\Model\Pos\Transaksiheader;
use App\Model\Simpanan\Transaksi;
use App\User;
use PDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WaserdaController extends Controller
{
    public function dtstok() {
        $unit = Unit::all();
        $kategori = Kategori::all();
        $shu = Katshudetail::where('id_header', 3)->get();
        $cabang = Cabang::all();
        return view('laporan.waserda.stok_barang')->with('unit', $unit)->with('shu', $shu)->with('kategori', $kategori)->with('cabang', $cabang);
    }

    public function cetakdtstok(Request $request)  {
        $cbdari = $request->cbdari;
        $cbke = $request->cbke;
        $status = $request->status;
        $kategori = $request->kategori;
        $unit = $request->unit;
        $urut = $request->urut;
        $urutan = $request->urutan;

        if ($cbdari > 0 && $cbke > 0) {
            $cabang = Cabang::where('id', '>=', $cbdari)->where('id', '<=', $cbke)->get();
            $cb1 = Cabang::find($cbdari);
            $cb2 = Cabang::find($cbke);
            $cbnya = $cb1->nama. " - ".$cb2->nama;
            if ($status != "") {
                $stnya = $status;
                if ($unit > 0) {
                    $un = Unit::find($unit);
                    $unnya = $un->nama;
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->where('unit', $unit)->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->where('unit', $unit)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                } else {
                    $unnya = "";
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                }
            } else {
                $stnya = "";
                if ($unit > 0) {
                    $un = Unit::find($unit);
                    $unnya = $un->nama;
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('unit', $unit)->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('unit', $unit)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                } else {
                    $unnya = "";
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::where('id_cabang', '>=', $cbdari)->where('id_cabang', '<=', $cbke)->whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                }
            }
        } else {
            $cabang = Cabang::all();
            $cbnya = "-";
            if ($status != "") {
                $stnya = $status;
                if ($unit > 0) {
                    $un = Unit::find($unit);
                    $unnya = $un->nama;
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->where('unit', $unit)->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->where('unit', $unit)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                } else {
                    $unnya = "";
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('status', $status)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                }
            } else {
                $stnya = "";
                if ($unit > 0) {
                    $un = Unit::find($unit);
                    $unnya = $un->nama;
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('unit', $unit)->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('unit', $unit)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                } else {
                    $unnya = "";
                    if ($kategori > 0) {
                        $kt = Kategori::find($kategori);
                        $ktnya = $kt->nama;
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->where('kategori', $kategori)->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    } else {
                        $ktnya = "";
                        $produk = Mappingbarang::whereHas('produkid', function ($query) use ($status, $kategori, $unit, $urut, $urutan) {
                            $query->orderBy($urut, $urutan);
                        })->orderBy('id_produk', 'asc')->get();
                    }
                }
            }
        }
        if($request->pilih == "stok") {
            $pdf = PDF::loadView('laporan.waserda.stok_barang_print', ['produk' => $produk, 'cbnya' => $cbnya, 'stnya' => $stnya, 'unnya' => $unnya, 'ktnya' => $ktnya]);
        } else {
            $pdf = PDF::loadView('laporan.waserda.stok_barang_print2', ['produk' => $produk, 'cbnya' => $cbnya, 'stnya' => $stnya, 'unnya' => $unnya, 'ktnya' => $ktnya, 'cabang' => $cabang]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Stok-Barang.pdf');
        } else {
            return $pdf->download('Daftar-Stok-Barang.pdf');
        }
    }


    public function jual() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $cabang = Cabang::all();
        $kasir = User::whereHas('roleid', function ($query) {
            $query->where('akses', 'kasir');
        })->get();
        $customer = Anggota::where('npk', '!=', '')->get();
        return view('laporan.waserda.penjualan')->with('cabang', $cabang)->with('kasir', $kasir)->with('customer', $customer)->with('today', $today);
    }

    public function cetakjual(Request $request) {
        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
        } else {
            $dfrom = "";
            $dto = "";
        }
        $datenya = $dfrom." s/d ".$dto;

        $cbdari = $request->cbdari;
        $cbke = $request->cbke;
        $ksdari = $request->ksdari;
        $kske = $request->kske;
        $urut = $request->urut;
        $urutan = $request->urutan;
        $status = $request->status;

        if ($cbdari > 0 && $cbke > 0) {
            $cabang = Cabang::where('id', '>=', $cbdari)->where('id', '<=', $cbke)->get();
            $cb1 = Cabang::find($cbdari);
            $cb2 = Cabang::find($cbke);
            $cbnya = $cb1->nama. " - ".$cb2->nama;
            if ($ksdari > 0 && $kske > 0) {
                $user = User::where('id', '>=', $ksdari)->where('id', '<=', $kske)->whereHas('roleid', function ($query) {
                    $query->where('akses', 'kasir');
                })->get();
                $ks1 = User::find($cbdari);
                $ks2 = User::find($cbke);
                $ksnya = $ks1->username." - ".$ks2->username;
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('kasir', '>=', $ksdari)->where('kasir', '<=', $kske)->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('kasir', '>=', $ksdari)->where('kasir', '<=', $kske)->orderBy($urut, $urutan)->get();
                }
            } else {
                $user = User::whereHas('roleid', function ($query) {
                    $query->where('akses', 'kasir');
                })->get();
                $ksnya = "-";
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->orderBy($urut, $urutan)->get();
                }
            }
        } else {
            $cabang = Cabang::all();
            $cbnya = "-";
            if ($ksdari > 0 && $kske > 0) {
                $user = User::where('id', '>=', $ksdari)->where('id', '<=', $kske)->whereHas('roleid', function ($query) {
                    $query->where('akses', 'kasir');
                })->get();
                $ks1 = User::find($cbdari);
                $ks2 = User::find($cbke);
                $ksnya = $ks1->username." - ".$ks2->username;
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('kasir', '>=', $ksdari)->where('kasir', '<=', $kske)->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('kasir', '>=', $ksdari)->where('kasir', '<=', $kske)->orderBy($urut, $urutan)->get();
                }
            } else {
                $user = User::whereHas('roleid', function ($query) {
                    $query->where('akses', 'kasir');
                })->get();
                $ksnya = "-";
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::orderBy($urut, $urutan)->get();
                }
            }
        }

        if($request->pilih == "tranjual") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya,'datenya' => $datenya]);
        } else if($request->pilih == "retrantipe") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print2', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya,'datenya' => $datenya]);
        } else if($request->pilih == "detrantipe") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print3', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya,'datenya' => $datenya]);
        } else if($request->pilih == "retrancab") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print4', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya, 'cabang' => $cabang,'datenya' => $datenya]);
        } else if($request->pilih == "detrancab") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print5', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya, 'cabang' => $cabang,'datenya' => $datenya]);
        }else if($request->pilih == "retrankas") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print6', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya, 'user' => $user,'datenya' => $datenya]);
        } else {
            $pdf = PDF::loadView('laporan.waserda.penjualan_print7', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'ksnya' => $ksnya, 'user' => $user,'datenya' => $datenya]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Penjualan.pdf');
        } else {
            return $pdf->download('Daftar-Penjualan.pdf');
        }
    }


    public function jualcs() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $cabang = Cabang::all();
        $kasir = User::whereHas('roleid', function ($query) {
            $query->where('akses', 'kasir');
        })->get();
        $customer = Anggota::where('npk', '!=', '')->get();

        return view('laporan.waserda.penjualan_anggota')->with('cabang', $cabang)->with('today', $today)->with('kasir', $kasir)->with('customer', $customer);
    }

    public function cetakjualcs(Request $request) {
        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
        } else {
            $dfrom = "";
            $dto = "";
        }
        $datenya = $dfrom." s/d ".$dto;

        $cbdari = $request->cbdari;
        $cbke = $request->cbke;
        $csdari = $request->csdari;
        $cske = $request->cske;
        $urut = $request->urut;
        $urutan = $request->urutan;
        $status = $request->status;

        if ($cbdari > 0 && $cbke > 0) {
            $cabang = Cabang::where('id', '>=', $cbdari)->where('id', '<=', $cbke)->get();
            $cb1 = Cabang::find($cbdari);
            $cb2 = Cabang::find($cbke);
            $cbnya = $cb1->nama. " - ".$cb2->nama;
            if ($csdari > 0 && $cske > 0) {
                $csnya = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', '!=', 'UMUM')->get();
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('npk', '!=', '000')->whereHas('anggotaid', function ($query) use ($csdari, $cske) {
                        $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                    })->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('npk', '!=', '000')->whereHas('anggotaid', function ($query) use ($csdari, $cske) {
                        $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                    })->orderBy($urut, $urutan)->get();
                }
            } else {
                $csnya = Anggota::where('jenis_nasabah', '!=', 'UMUM')->get();
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('npk', '!=', '000')->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('npk', '!=', '000')->orderBy($urut, $urutan)->get();
                }
            }
        } else {
            $cabang = Cabang::all();
            $cbnya = "-";
            if ($csdari > 0 && $cske > 0) {
                $csnya = Anggota::where('id', '>=', $csdari)->where('id', '<=', $cske)->where('jenis_nasabah', '!=', 'UMUM')->get();
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('npk', '!=', '000')->whereHas('anggotaid', function ($query) use ($csdari, $cske) {
                        $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                    })->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('npk', '!=', '000')->whereHas('anggotaid', function ($query) use ($csdari, $cske) {
                        $query->where('id', '>=', $csdari)->where('id', '<=', $cske);
                    })->orderBy($urut, $urutan)->get();
                }
            } else {
                $csnya = Anggota::where('jenis_nasabah', '!=', 'UMUM')->get();
                if ($status != "") {
                    $stnya = $status;
                    $transaksi = Transaksiheader::where('npk', '!=', '000')->where('type_pembayaran', $status)->orderBy($urut, $urutan)->get();
                } else {
                    $stnya = "";
                    $transaksi = Transaksiheader::where('npk', '!=', '000')->orderBy($urut, $urutan)->get();
                }
            }
        }

        if($request->pilih == "tranjual") {
            $pdf = PDF::loadView('laporan.waserda.penjualan_anggota_print', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya,'datenya' => $datenya]);
        } else {
            $pdf = PDF::loadView('laporan.waserda.penjualan_anggota_print2', ['transaksi' => $transaksi, 'cbnya' => $cbnya, 'stnya' => $stnya, 'csnya' => $csnya,'datenya' => $datenya]);
        }

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Penjualan-Anggota.pdf');
        } else {
            return $pdf->download('Daftar-Penjualan-Anggota.pdf');
        }
    }

    public function jualhpp() {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        $cabang = Cabang::all();
        $produk = Barang::all();
        return view('laporan.waserda.penjualan_hpp')->with('cabang', $cabang)->with('produk', $produk)->with('today', $today);
    }

    public function cetakjualhpp(Request $request) {
        if ($request->dari != "" || $request->ke != "") {
            $dfrom = date("Y-m-d", strtotime($request->dari));
            $dto = date("Y-m-d", strtotime($request->ke));
        } else {
            $dfrom = "";
            $dto = "";
        }
        $datenya = $dfrom." s/d ".$dto;

        $cbdari = $request->cbdari;
        $cbke = $request->cbke;
        $brdari = $request->brdari;
        $brke = $request->brke;
        $urut = $request->urut;
        $urutan = $request->urutan;

        if ($cbdari > 0 && $cbke > 0) {
            $cb1 = Cabang::find($cbdari);
            $cb2 = Cabang::find($cbke);
            $cbnya = $cb1->nama. " - ".$cb2->nama;
            if ($brdari > 0 && $brke > 0) {
                $br1 = Barang::find($brdari);
                $br2 = Barang::find($brke);
                $brnya = $br1->nama." - ".$br2->nama;
                $hpp = Hpp::where('tanggal', '>=', $dfrom)->where('tanggal', '<=', $dto)->where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->where('produk', '>=', $brdari)->where('produk', '<=', $brke)->orderBy($urut, $urutan)->get();
            } else {
                $brnya = "-";
                $hpp = Hpp::where('tanggal', '>=', $dfrom)->where('tanggal', '<=', $dto)->where('cabang', '>=', $cbdari)->where('cabang', '<=', $cbke)->orderBy($urut, $urutan)->get();
            }
        } else {
            $cbnya = "-";
            if ($brdari > 0 && $brke > 0) {
                $br1 = Barang::find($brdari);
                $br2 = Barang::find($brke);
                $brnya = $br1->nama." - ".$br2->nama;
                $hpp = Hpp::where('tanggal', '>=', $dfrom)->where('tanggal', '<=', $dto)->where('produk', '>=', $brdari)->where('produk', '<=', $brke)->orderBy($urut, $urutan)->get();
            } else {
                $brnya = "-";
                $hpp = Hpp::where('tanggal', '>=', $dfrom)->where('tanggal', '<=', $dto)->orderBy($urut, $urutan)->get();
            }
        }

        $pdf = PDF::loadView('laporan.waserda.penjualan_hpp_print', ['hpp' => $hpp, 'cbnya' => $cbnya, 'brnya' => $brnya, 'datenya' => $datenya]);

        if ($request->print == "preview") {
            return $pdf->stream('Daftar-Penjualan-HPP.pdf');
        } else {
            return $pdf->download('Daftar-Penjualan-HPP.pdf');
        }
    }
}
