<?php

namespace App\Http\Controllers\Simpanan;

use App\Model\Master\Anggota;
use App\Model\Master\Koderecab;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Pengaturan;
use App\Model\Simpanan\Simpanan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $simpanan = Simpanan::orderBy('id','asc')->paginate(20);
        $jml = Simpanan::count();
        return view('simpanan.daftar_simpanan')->with('simpanan', $simpanan)->with('jml',$jml);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $simpanan = Simpanan::where('nomor_simpanan','like','%'.$query.'%')->orWhereHas('anggotaid', function($querys) use ($query) {
            $querys->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
        })->orderBy('id','asc')->paginate(20);
        $jml = Simpanan::where('nomor_simpanan','like','%'.$query.'%')->orWhereHas('anggotaid', function($querys) use ($query) {
            $querys->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
        })->count();
        return view('simpanan.cari_simpanan')->with('simpanan', $simpanan)->with('query',$query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pengaturan = Pengaturan::all();
        $anggota = Anggota::where('status', 'AKTIF')->get();
        date_default_timezone_set('Asia/Jakarta');
        $today = date('m/d/Y');
        return view('simpanan.tambah_simpanan')->with('today', $today)
            ->with('pengaturan', $pengaturan)
            ->with('anggota', $anggota);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setorbulan = $request->setoran_bulanan;
        $setorbulan2 = str_replace(",","",$setorbulan);
        $setorb = str_replace(".00","",$setorbulan2);

        $saldoblokir = $request->saldo_blokir;
        $saldoblokir2 = str_replace(",","",$saldoblokir);
        $saldob = str_replace(".00","",$saldoblokir2);

        if ($request->tanggal_pembuatan == "") {
            $pembuatan = "00/00/0000";
        } else {
            $pembuatan = $request->tanggal_pembuatan;
        }

        if ($request->tanggal_status == "") {
            $status = "00/00/0000";
        } else {
            $status = $request->tanggal_status;
        }
        $tanggal_pembuatan = explode('/', $pembuatan);
        $tanggal_status = explode('/', $status);

        $pengaturan = Pengaturan::find($request->jenis_simpanan);

            $simp = Simpanan::create([
                'jenis_simpanan'     => $request->jenis_simpanan,
                'nomor_simpanan'     => $request->nomor_simpanan,
                'anggota'            => $request->kode_anggota,
                'suku_bunga'         => $pengaturan->suku_bunga,
                'sistem_bunga'       => $pengaturan->sistem_bunga,
                'tanggal_pembuatan'  => $tanggal_pembuatan[2].'-'.$tanggal_pembuatan[0].'-'.$tanggal_pembuatan[1],
                'setoran_bulanan'    => $setorb,
                'jangka_waktu'       => $request->jangka_waktu,
                'status'             => $request->status,
                'tanggal_status'     => $tanggal_status[2].'-'.$tanggal_status[0].'-'.$tanggal_status[1],
                'saldo_blokir'       => $saldob,
                'keterangan'         => $request->keterangan
            ]);

            Akumulasi::create([
                'id_simpanan' => $simp->id,
                'saldo'       => '0'
            ]);

        $msg = "Data Berhasil di Ditambahkan";
        $alert = Toastr::success($msg, $title = "Tambah Simpanan", $options = []);
            return redirect(url('simpanan'))
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
        $simpanan = Simpanan::findOrNew($id);
        $pengaturan = Pengaturan::all();
        $anggota = Anggota::where('status', 'AKTIF')->get();
        foreach($pengaturan as $sel) {
            $simpanan['selected_no1'] = $simpanan['jenis_simpanan'] == $sel->id ? 'selected' : '';
        }

//        $pemb = explode('-', $simpanan->tanggal_pembuatan);
//        $simpanan['pemb'] = $pemb[1].'/'.$pemb[2].'/'.$pemb[0];
        if ($simpanan->tanggal_pembuatan == "0000-00-00") {
            $simpanan['pemb'] = "";
        } else {
            $simpanan['pemb'] = date("m/d/Y", strtotime($simpanan->tanggal_pembuatan));
        }

//        $stat = explode('-', $simpanan->tanggal_status);
//        $simpanan['stat'] = $stat[1].'/'.$stat[2].'/'.$stat[0];
        if ($simpanan->tanggal_status == "0000-00-00") {
            $simpanan['stat'] = "";
        } else {
            $simpanan['stat'] = date("m/d/Y", strtotime($simpanan->tanggal_status));
        }
        return view('simpanan.ubah_simpanan')->with('simpanan', $simpanan)
            ->with('pengaturan', $pengaturan)
            ->with('anggota', $anggota);
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
        $setorbulan = $request->setoran_bulanan;
        $setorbulan2 = str_replace(",","",$setorbulan);
        $setorb = str_replace(".00","",$setorbulan2);

        $saldoblokir = $request->saldo_blokir;
        $saldoblokir2 = str_replace(",","",$saldoblokir);
        $saldob = str_replace(".00","",$saldoblokir2);

        if ($request->tanggal_pembuatan == "") {
            $pembuatan = "00/00/0000";
        } else {
            $pembuatan = $request->tanggal_pembuatan;
        }

        if ($request->tanggal_status == "") {
            $status = "00/00/0000";
        } else {
            $status = $request->tanggal_status;
        }
        $tanggal_pembuatan = explode('/', $pembuatan);
        $tanggal_status = explode('/', $status);

        $pengaturan = Pengaturan::find($request->jenis_simpanan);

        $simpanan = Simpanan::findOrNew($id);
        $simpanan->update([
            'jenis_simpanan'     => $request->jenis_simpanan,
            'nomor_simpanan'     => $request->nomor_simpanan,
            'anggota'            => $request->kode_anggota,
            'suku_bunga'         => $pengaturan->suku_bunga,
            'sistem_bunga'         => $pengaturan->sistem_bunga,
            'tanggal_pembuatan'  => $tanggal_pembuatan[2].'-'.$tanggal_pembuatan[0].'-'.$tanggal_pembuatan[1],
            'setoran_bulanan'    => $setorb,
            'jangka_waktu'       => $request->jangka_waktu,
            'status'             => $request->status,
            'tanggal_status'     => $tanggal_status[2].'-'.$tanggal_status[0].'-'.$tanggal_status[1],
            'saldo_blokir'       => $saldob,
            'keterangan'         => $request->keterangan
        ]);
        $msg = "Data Berhasil di Ubah";
        $alert = Toastr::success($msg, $title = "Ubah Simpanan", $options = []);
//        return redirect(url('simpanan'))
        return redirect($request->urlnya)
            ->with('alert', $alert);
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
        $alert = Toastr::success($msg, $title = "Hapus Simpanan", $options = []);
        Simpanan::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('simpanan.import_simpanan');
    }

    public function postimport(Request $request)
    {
        $no = 0;
        if ($request->hasFile('import'))
        {
            $file     = $request->import;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/';
            $file->move($destinationPath, $filename);

        }

        $xls = explode(".", $filename);

        if ($xls[1] == "xls" || $xls[1] == "csv") {
            $z = 0;
            $w = 0;
            $result = Excel::load('public/foto/'.$filename)->get();
            foreach ($result as $value) {
                if ($value->no_simpanan != "") {
                    $z+=1;
                    $pengaturan = Pengaturan::where('kode', $value->kd_pengaturan)->first();
                    if ($pengaturan != null) {
//                        $simp = Simpanan::where('jenis_simpanan', $pengaturan->id)->where('anggota', $value->no_anggota)->orWhere('nomor_simpanan', $value->no_simpanan)->first();
                        $simp = Simpanan::where('nomor_simpanan', $value->no_simpanan)->first();
                        if ($request->konf == "cekdata") {
                            if ($simp != null) {
                                $data[] = array('nos' => $value->no_simpanan);
                            } else {
                                $w+=1;
                            }
                        } else if ($request->konf == "skip") {
                            if ($simp == null) {
                                $anggota = Anggota::where('kode', $value->kd_anggota)->first();
                                if ($anggota != null) {
                                    $no++;
                                    $your_date = date("Y-m-d", strtotime($value->tanggal_pembuatan));
                                    $simpanan = Simpanan::create([
                                        'jenis_simpanan' => $pengaturan->id,
                                        'nomor_simpanan' => $value->no_simpanan,
                                        'anggota' => $anggota->id,
                                        'suku_bunga' => $pengaturan->suku_bunga,
                                        'tanggal_pembuatan' => $your_date,
                                        'keterangan' => $value->keterangan
                                    ]);

                                    Akumulasi::create([
                                        'id_simpanan' => $simpanan->id,
                                        'saldo' => $value->saldo_akhir
                                    ]);
                                }
                            }
                        } else {
                            $your_date = date("Y-m-d", strtotime($value->tanggal_pembuatan));
                            $anggota = Anggota::where('kode', $value->kd_anggota)->first();
                            if ($anggota == null) {
                                $recab = Koderecab::where('kode', '007')->first();
                                if ($recab == null) {
                                    $recab = Koderecab::create(['kode' => '007', 'nama' => '007']);
                                }
                                $anggota = Anggota::create([
                                    'kode' => $value->kd_anggota,
                                    'jenis_nasabah' => "BIASA",
                                    'nama' => $value->kd_anggota,
                                    'tanggal_registrasi' => $your_date,
                                    'kode_rekening' => $recab->id
                                ]);
                            }
                            $no++;
                            $datanya = [
                                'jenis_simpanan' => $pengaturan->id,
                                'nomor_simpanan' => $value->no_simpanan,
                                'anggota' => $anggota->id,
                                'suku_bunga' => $pengaturan->suku_bunga,
                                'tanggal_pembuatan' => $your_date,
                                'keterangan' => $value->keterangan
                            ];
                            if ($simp == null) {
                                $simpanan = Simpanan::create($datanya);
                                Akumulasi::create([
                                    'id_simpanan' => $simpanan->id,
                                    'saldo' => $value->saldo_akhir
                                ]);
                            } else {
                                $simpanan = Simpanan::find($simp->id);
                                $simpanan->update($datanya);
                            }
                        }
                    }
                }
            }
            if ($request->konf == "cekdata") {
                if ($w == $z) {
                    $msg = "Tidak ada data yang sama.";
                    $alert = Toastr::success($msg, $title = null, $options = []);
                } else {
                    foreach ($data as $item) {
                        $msg = $item["nos"] . "<br>";
                        $alert = Toastr::warning($msg, $title = null, $options = []);
                    }
                }
            } else {
                $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : " . $no;
                $alert = Toastr::success($msg, $title = "Import Simpanan", $options = []);
            }
        } else {
            $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Simpanan", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('simpanan/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_simpanan_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('SMP.0004', 'ANG001', 'SMP', '6', '2015-08-24', '0', 'sdjjkshds'),
                    array('SMP.0005', 'ANG002', 'AMW', '8', '2015-11-11', '0', 'kdfidffdio')
                ), null, 'A2', false, false);
                $sheet->row(1, array('NO_SIMPANAN', 'KD_ANGGOTA', 'KD_PENGATURAN', 'SUKU_BUNGA', 'TGL_PEMBUATAN', 'SALDO_AKHIR', 'KETERANGAN'));

                $sheet->setBorder('A1:G1', 'thin');
                $sheet->cells('A1:G1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setWidth('A', '20');
                $sheet->setWidth('B', '20');
                $sheet->setWidth('C', '20');
                $sheet->setWidth('D', '20');
                $sheet->setWidth('E', '20');
                $sheet->setWidth('F', '20');
                $sheet->setWidth('G', '50');
            });
            return redirect(url('simpanan/import'));
        })->download('xls');
    }

    public function ajaxanggota($id) {
        $anggota = Anggota::findOrNew($id);
        $data[] = array(
            'nama' => $anggota->nama,
            'alamat' => $anggota->provinsi
        );

        return json_encode($data);
    }

    public function ajaxcekstatus($id) {
        $pengaturan = Pengaturan::find($id);
        $data[] = array(
            'status' => $pengaturan->wajibpokok
        );

        return json_encode($data);
    }

    public function cekaturan($ida, $idp, $setorb, $saldob) {
        $setorbulan2 = str_replace(",","",$setorb);
        $bsetor = str_replace(".00","",$setorbulan2);

        $saldoblokir2 = str_replace(",","",$saldob);
        $bsaldo = str_replace(".00","",$saldoblokir2);

        $pengaturan = Pengaturan::findOrNew($idp);

        $simpanan = Simpanan::where('jenis_simpanan', $idp)->where('anggota', $ida)->where('status', '0')->first();
        if($bsetor < $pengaturan->setoran_minimum) {
            $stat = "FAIL";
            $title = "Setoran Bulanan";
            $psg = "Setoran Bulanan tidak boleh kurang dari Setoran Minimum : ".number_format($pengaturan->setoran_minimum, 2, '.', ',');
        } else if($bsaldo < $pengaturan->saldo_minimum) {
            $stat = "FAIL";
            $title = "Saldo Blokir";
            $psg = "Saldo Blokir tidak boleh kurang dari Saldo Minimum : ".number_format($pengaturan->saldo_minimum, 2, '.', ',');
        } else if($simpanan != null) {
            $stat = "FAIL";
            $title = "Tambah Simpanan";
            $psg = "Simpanan dengan Jenis Simpanan: ".$simpanan->pengaturanid->jenis_simpanan." <br> dan Anggota : ".$simpanan->anggotaid->kode." - ".$simpanan->anggotaid->nama." sudah terdaftar / masih AKTIF";
        }else {
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

    public function tutupsimpanan($id, $status) {
        $simpanan = Simpanan::find($id);
        $simpanan->update(['status' => $status]);

        $msg = "Simpanan Berhasil Di Tutup";
        $alert = Toastr::success($msg, $title = "Tutup Simpanan", $options = []);

        return redirect(url()->previous())->with('alert', $alert);
    }
}
