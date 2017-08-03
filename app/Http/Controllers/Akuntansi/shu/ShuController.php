<?php

namespace App\Http\Controllers\Akuntansi\shu;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\TransaksiHeader;
use App\Model\Akuntansi\PengaturanSHU;
use App\Model\Akuntansi\TabunganTransaksi;

use App\Model\Master\Barang;
use App\Model\Master\Katshudetail;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pos\Transaksidetail;
use App\Model\Simpanan\Prosesdetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use narutimateum\Toastr\Facades\Toastr;

class ShuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $tahunterpilih = date('Y');
            $tanggal_pembagian = "";
            $idshusimpan = "";
            $jumlahshu = "0";
            $isempty = "yes";
            $totalakhir_persen = "0";
            $totalakhiranggota_persen = "0";

            $danacadangan_persen = "";
            $shuanggota_persen = "";
            $jasausaha_persen = "";
            $jasamodal_persen = "";
            $danapengurus_persen = "";
            $danakaryawan_persen = "";
            $danapendidikan_persen = "";
            $danasosial_persen = "";
            $danapembangunan_persen = "";
            $danadll_persen = "";


            $danacadangan_rp = "0.00";
            $shuanggota_rp = "0.00";
            $jasausaha_rp = "0.00";
            $jasamodal_rp = "0.00";
            $danapengurus_rp = "0.00";
            $danakaryawan_rp = "0.00";
            $danapendidikan_rp = "0.00";
            $danasosial_rp = "0.00";
            $danapembangunan_rp = "0.00";
            $danadll_rp = "0.00";

        return view('Akuntansi.SHU.hitung_shu')->with('tahunterpilih', $tahunterpilih)
                                                ->with('tanggal_pembagian', $tanggal_pembagian)
                                                ->with('idshusimpan', $idshusimpan)
                                                ->with('jumlahshu', $jumlahshu)
                                                ->with('isempty', $isempty)
                                                ->with('totalakhir_persen', $totalakhir_persen)
                                                ->with('totalakhiranggota_persen', $totalakhiranggota_persen)
                                                ->with('danacadangan_persen', $danacadangan_persen)
                                                ->with('shuanggota_persen', $shuanggota_persen)
                                                ->with('jasausaha_persen', $jasausaha_persen)
                                                ->with('jasamodal_persen', $jasamodal_persen)
                                                ->with('danapengurus_persen', $danapengurus_persen)
                                                ->with('danakaryawan_persen', $danakaryawan_persen)
                                                ->with('danapendidikan_persen', $danapendidikan_persen)
                                                ->with('danasosial_persen', $danasosial_persen)
                                                ->with('danapembangunan_persen', $danapembangunan_persen)
                                                ->with('danadll_persen', $danadll_persen)
                                                ->with('danacadangan_rp', $danacadangan_rp)
                                                ->with('shuanggota_rp', $shuanggota_rp)
                                                ->with('jasausaha_rp', $jasausaha_rp)
                                                ->with('jasamodal_rp', $jasamodal_rp)
                                                ->with('danakaryawan_rp', $danakaryawan_rp)
                                                ->with('danapengurus_rp', $danapengurus_rp)
                                                ->with('danapendidikan_rp', $danapendidikan_rp)
                                                ->with('danasosial_rp', $danasosial_rp)
                                                ->with('danapembangunan_rp', $danapembangunan_rp)
                                                ->with('danadll_rp', $danadll_rp);
    }


    public function cek(Request $request)
    {
        $tahunterpilih = $request->tahun_shu;
        $shu = PengaturanSHU::where('tahun', $tahunterpilih)->first();
        $idakun= '12';
        $jurnalheader = JurnalHeader::where('tanggal', 'LIKE', '%'.$tahunterpilih.'-%')->where('posting', '1')->get();

        $totalshukredit = "0";
        $totalshudebet = "0";
        foreach ($jurnalheader as $row) {
            $totalshukredit = JurnalDetail::where('id_header', $row->id)->where('id_akun', $idakun)->where('posting', '1')->sum('kredit');
            $totalshudebet = JurnalDetail::where('id_header', $row->id)->where('id_akun', $idakun)->where('posting', '1')->sum('debet');
        }

//        $kwas = 0;
//        $ksimp = 0;
//        $kpinj = 0;
//        $shunya = Katshudetail::where('masuk_shu', 1)->get();
//        foreach ($shunya as $item) {
//            $idshu = $item->id;
//
//            $produk = Barang::where('id_shu', $idshu)->get();
//            foreach ($produk as $get) {
//                $cektran = Transaksidetail::where('barcode', $get->barcode)->first();
//                if ($cektran != null) {
//                    $waserda = Transaksidetail::where('bayarstat', 1)->sum($item->field);
//                    $waserdanya = $waserda * $item->percent / 100;
//                    $kwas+=$waserdanya;
//                }
//            }
//
//            $simpanan = Prosesdetail::whereHas('simpananid', function($query) use($idshu) {
//                $query->whereHas('pengaturanid', function($querys) use($idshu) {
//                    $querys->where('id_shu');
//                });
//            })->sum($item->field);
//            $simpanannya = $simpanan * $item->percent / 100;
//            $ksimp+=$simpanannya;
//
//            $pinjaman = Pembayaran::whereHas('pinjamanid', function($query) use($idshu) {
//                $query->whereHas('pengaturanid', function($querys) use($idshu) {
//                    $querys->where('id_shu', $idshu);
//                });
//            })->where('stat', 1)->sum($item->field);
//            $pinjamannya = $pinjaman * $item->percent / 100;
//            $kpinj+=$pinjamannya;
//
//        }
        //$jumlahshu = $totalshukredit - $totalshudebet;
        $jumlahshu = '10000000';
//        $jumlahshu = $kwas + $ksimp + $kpinj;

        if(count($shu)==0){
            $tanggal_pembagian = "";
            $idshusimpan = "";
            $isempty = "yes";
            $totalakhir_persen = "0";
            $totalakhiranggota_persen = "0";

            $danacadangan_persen = "";
            $shuanggota_persen = "";
            $jasausaha_persen = "";
            $jasamodal_persen = "";
            $danapengurus_persen = "";
            $danakaryawan_persen = "";
            $danapendidikan_persen = "";
            $danasosial_persen = "";
            $danapembangunan_persen = "";
            $danadll_persen = "";


            $danacadangan_rp = "0.00";
            $shuanggota_rp = "0.00";
            $jasausaha_rp = "0.00";
            $jasamodal_rp = "0.00";
            $danapengurus_rp = "0.00";
            $danakaryawan_rp = "0.00";
            $danapendidikan_rp = "0.00";
            $danasosial_rp = "0.00";
            $danapembangunan_rp = "0.00";
            $danadll_rp = "0.00";

        } else {

            $tanggal_pembagian = $shu->tanggal_pembagian;
            $idshusimpan = $shu->id;
            $isempty = "no";
            $totalakhir_persen = "100";
            $totalakhiranggota_persen = "100";

            $danacadangan_persen = $shu->dana_cadangan;
            $shuanggota_persen = $shu->shu_anggota;
            $jasausaha_persen = $shu->jasa_usaha;
            $jasamodal_persen = $shu->jasa_modal;
            $danapengurus_persen = $shu->dana_pengurus;
            $danakaryawan_persen = $shu->dana_karyawan;
            $danapendidikan_persen = $shu->dana_pendidikan;
            $danasosial_persen = $shu->dana_sosial;
            $danapembangunan_persen = $shu->dana_pembangunan;
            $danadll_persen = $shu->dana_lain2;


            $danacadangan_rp = number_format($jumlahshu * $danacadangan_persen / 100, '2');
            $shuanggota_rp = number_format($jumlahshu * $shuanggota_persen / 100, '2');
            $shuanggota_rp_real = $jumlahshu * $shuanggota_persen / 100;
            $jasausaha_rp = number_format($shuanggota_rp_real * $jasausaha_persen / 100, '2');
            $jasamodal_rp = number_format($shuanggota_rp_real * $jasamodal_persen / 100, '2');
            $danapengurus_rp = number_format($jumlahshu * $danapengurus_persen / 100, '2');
            $danakaryawan_rp = number_format($jumlahshu * $danakaryawan_persen / 100, '2');
            $danapendidikan_rp = number_format($jumlahshu * $danapendidikan_persen / 100, '2');
            $danasosial_rp = number_format($jumlahshu * $danasosial_persen / 100, '2');
            $danapembangunan_rp = number_format($jumlahshu * $danapembangunan_persen / 100, '2');
            $danadll_rp = number_format($jumlahshu * $danadll_persen / 100, '2');
        }


        return view('Akuntansi.SHU.hitung_shu')->with('tahunterpilih', $tahunterpilih)
        ->with('tanggal_pembagian', $tanggal_pembagian)
        ->with('idshusimpan', $idshusimpan)
        ->with('jumlahshu', $jumlahshu)
        ->with('isempty', $isempty)
        ->with('totalakhir_persen', $totalakhir_persen)
        ->with('totalakhiranggota_persen', $totalakhiranggota_persen)
        ->with('danacadangan_persen', $danacadangan_persen)
        ->with('shuanggota_persen', $shuanggota_persen)
        ->with('jasausaha_persen', $jasausaha_persen)
        ->with('jasamodal_persen', $jasamodal_persen)
        ->with('danapengurus_persen', $danapengurus_persen)
        ->with('danakaryawan_persen', $danakaryawan_persen)
        ->with('danapendidikan_persen', $danapendidikan_persen)
        ->with('danasosial_persen', $danasosial_persen)
        ->with('danapembangunan_persen', $danapembangunan_persen)
        ->with('danadll_persen', $danadll_persen)
        ->with('danacadangan_rp', $danacadangan_rp)
        ->with('shuanggota_rp', $shuanggota_rp)
        ->with('jasausaha_rp', $jasausaha_rp)
        ->with('jasamodal_rp', $jasamodal_rp)
        ->with('danakaryawan_rp', $danakaryawan_rp)
        ->with('danapengurus_rp', $danapengurus_rp)
        ->with('danapendidikan_rp', $danapendidikan_rp)
        ->with('danasosial_rp', $danasosial_rp)
        ->with('danapembangunan_rp', $danapembangunan_rp)
        ->with('danadll_rp', $danadll_rp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $SHUCEK = PengaturanSHU::where('tahun', $request->tahun)->first();
        if($request->totalakhiranggota_persen!=100){
            $msg = "Gagal! <br> Total Akhir harus 100%";
            $alert = Toastr::error($msg, $title = "Pengaturan SHU", $options = []);
        } else {
            if(count($SHUCEK)==0)
            {
                $msg = "Berhasil! <br> Anda berhasil menambahkan Pengaturan SHU";
                $alert = Toastr::success($msg, $title = "Tambah Pengaturan SHU", $options = []);

                $pengaturanSHU = new PengaturanSHU;
                $pengaturanSHU->tahun = $request->tahun;
                $pengaturanSHU->jumlah_shulabarugi = str_replace(',', '', $request->jumlah_shu);
                $pengaturanSHU->tanggal_pembagian = date("Y-m-d", strtotime($request->tanggal_pembagian));
                $pengaturanSHU->dana_cadangan = $request->dana_cadangan_persen;
                $pengaturanSHU->shu_anggota = $request->shu_anggota_persen;
                $pengaturanSHU->dana_pengurus = $request->dana_pengurus_persen;
                $pengaturanSHU->dana_karyawan = $request->dana_karyawan_persen;
                $pengaturanSHU->dana_pendidikan = $request->dana_pendidikan_persen;
                $pengaturanSHU->dana_sosial = $request->dana_sosial_persen;
                $pengaturanSHU->dana_pembangunan = $request->dana_pembangunan_persen;
                $pengaturanSHU->dana_lain2 = $request->dana_lain2_persen;
                $pengaturanSHU->jasa_usaha = $request->jasa_usaha_persen;
                $pengaturanSHU->jasa_modal = $request->jasa_modal_persen;
                $pengaturanSHU->save();
            } else {
                $msg = "Berhasil! <br> Anda berhasil mengubah Pengaturan SHU";
                $alert = Toastr::success($msg, $title = "Ubah Pengaturan SHU", $options = []);

                $pengaturanSHU = PengaturanSHU::find($SHUCEK->id);
                $pengaturanSHU->tahun = $request->tahun;
                $pengaturanSHU->jumlah_shulabarugi = str_replace(',', '', $request->jumlah_shu);
                $pengaturanSHU->tanggal_pembagian = date("Y-m-d", strtotime($request->tanggal_pembagian));
                $pengaturanSHU->dana_cadangan = $request->dana_cadangan_persen;
                $pengaturanSHU->shu_anggota = $request->shu_anggota_persen;
                $pengaturanSHU->dana_pengurus = $request->dana_pengurus_persen;
                $pengaturanSHU->dana_karyawan = $request->dana_karyawan_persen;
                $pengaturanSHU->dana_pendidikan = $request->dana_pendidikan_persen;
                $pengaturanSHU->dana_sosial = $request->dana_sosial_persen;
                $pengaturanSHU->dana_pembangunan = $request->dana_pembangunan_persen;
                $pengaturanSHU->dana_lain2 = $request->dana_lain2_persen;
                $pengaturanSHU->jasa_usaha = $request->jasa_usaha_persen;
                $pengaturanSHU->jasa_modal = $request->jasa_modal_persen;
                $pengaturanSHU->save();
            }
        }

        return redirect(url('akuntansi/hitungshu'))
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $msg = "Berhasil! <br> Anda berhasil menghapus Pengaturan SHU";
        $alert = Toastr::success($msg, $title = "Hapus Pengaturan SHU", $options = []);

        $pengaturanshu = PengaturanSHU::find($id);
        $pengaturanshu->delete();

        return redirect(url('akuntansi/hitungshu'))
                                    ->with('alert', $alert);

    }

}
