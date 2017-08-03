<?php

namespace App\Http\Controllers\Pinjaman;

use App\Approve;
use App\Attach;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Master\Anggota;
use App\Model\Master\Kolektibilitas;
use App\Model\Pinjaman\Jaminan;
use App\Model\Pinjaman\Jaminanbangunan;
use App\Model\Pinjaman\Jaminanelektronik;
use App\Model\Pinjaman\Jaminanemas;
use App\Model\Pinjaman\Jaminankendaraan;
use App\Model\Pinjaman\Jaminansimpanan;
use App\Model\Pinjaman\Jaminantanpa;
use App\Model\Pinjaman\Jenisjaminan;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pinjaman\Pengaturan;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Pinjaman\Realisasi;
use App\Model\Sistembunga;
use Illuminate\Http\Request;

use Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pinj = Pinjaman::all();
        foreach ($pinj as $get) {
            $this->_setkolektibilitas($get->id);
        }

        $kolektibilitas = Kolektibilitas::all();
        $pinjaman = Pinjaman::where('status_tutup', 0)->orderBy('id','asc')->paginate(20);
        $jml = Pinjaman::where('status_tutup', 0)->count();
        return view('pinjaman.daftar_pinjaman')->with('pinjaman', $pinjaman)
            ->with('kolektibilitas', $kolektibilitas)->with('jml',$jml);
    }

    public function search(Request $r)
    {
        $query = $r->input('query');
        $kolektibilitas = Kolektibilitas::all();
        $pinjaman = Pinjaman::where('status_tutup', 0)->where('nama_pinjaman','like','%'.$query.'%')->orWhere('nomor_pinjaman','like','%'.$query.'%')->orWhereHas('anggotaid', function($querys) use ($query){
            $querys->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
        })->orderBy('id','asc')->paginate(20);
        $jml = Pinjaman::where('status_tutup', 0)->where('nama_pinjaman','like','%'.$query.'%')->orWhere('nomor_pinjaman','like','%'.$query.'%')->orWhereHas('anggotaid', function($querys) use ($query){
            $querys->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%');
        })->count();
        return view('pinjaman.cari_pinjaman')->with('query',$query)->with('pinjaman', $pinjaman)
            ->with('kolektibilitas', $kolektibilitas)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = Jenisjaminan::all();
        $jaminan = Jaminan::whereNull('id_pinjaman')->get();
        $pengaturan = Pengaturan::all();
        $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
        $anggota = Anggota::where('status', 'AKTIF')->get();
        $kolektibilitas = Kolektibilitas::all();
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now()->format('m/d/Y');
        return view('pinjaman.tambah_pinjaman')->with('today', $today)
            ->with('pengaturan', $pengaturan)
            ->with('anggota', $anggota)
            ->with('kolektibilitas', $kolektibilitas)
            ->with('jaminan', $jaminan)
            ->with('jenis', $jenis)
            ->with('sistem_bunga', $sistem_bunga);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jmlpengajuan = str_replace(",","",$request->jumlah_pengajuan);
        $jpengajuan = str_replace(".00","",$jmlpengajuan);

        $jmlangsuranpokok = str_replace(",","",$request->jumlah_angsuran_pokok);
        $japokok = str_replace(".00","",$jmlangsuranpokok);

        $format = 'm/d/Y';
        $tanggal_pengajuan = Carbon::createFromFormat($format,$request->tanggal_pengajuan)->toDateString();
        $jatuh_tempo = Carbon::createFromFormat($format,$request->jatuh_tempo)->toDateString();

        $pengaturan = Pengaturan::find($request->nama_pinjaman);

        $pinjaman = Pinjaman::create([
            'nama_pinjaman'      => $request->nama_pinjaman,
            'nomor_pinjaman'     => $request->nomor_pinjaman,
            'anggota'            => $request->kode_anggota,
            'suku_bunga'         => $pengaturan->suku_bunga,
            'sistem_bunga'         => $pengaturan->sistem_bunga,
            'tanggal_pengajuan'  => $tanggal_pengajuan,
            'jumlah_pengajuan'   => $jpengajuan,
            'jangka_waktu'       => $request->jangka_waktu,
            'jatuh_tempo'        => $jatuh_tempo,
            'jumlah_angsuran_pokok'  => $japokok,
            'perhitungan_bunga'      => $request->perhitungan_bunga,
            'digunakan_untuk'        => $request->digunakan_untuk,
            'sumber_dana'            => $request->sumber_dana,
            'kolektibilitas'         => 1,
            'keterangan'             => $request->keterangan,
            'status_realisasi'       => "N",
            'status_lunas'           => "N",
            'status_pasangan'        => $request->status_pasangan,
            'nama_pasangan'          => $request->nama_pasangan,
            'pekerjaan_pasangan'     => $request->pekerjaan_pasangan,
            'alamat_pasangan'        => $request->alamat_pasangan,
            'nomor_telepon_pasangan' => $request->nomor_telepon_pasangan,
            'nama_penjamin'          => $request->nama_penjamin,
            'pekerjaan_penjamin'     => $request->pekerjaan_penjamin,
            'alamat_penjamin'        => $request->alamat_penjamin,
            'nomor_telepon_penjamin' => $request->nomor_telepon_penjamin,
            'nomor_ktp_penjamin'     => $request->nomor_telepon_penjamin
        ]);

        $jaminan = Jaminan::whereNull('id_pinjaman')->get();
        foreach($jaminan as $item) {
            $jamin = Jaminan::findOrNew($item->id);
            $jamin->update([
                'id_pinjaman' => $pinjaman->id
            ]);
        }

        $msg = "Data Berhasil di Ditambahkan";
        $alert = Toastr::success($msg, $title = "Tambah Pinjaman", $options = []);
        if ($request->pstat == "SELESAI") {
            return redirect(url('pinjaman'))->with('alert', $alert);
        } else {
            return redirect(url('pinjaman/'.$pinjaman->id.'/edit/jaminan'))->with('alert', $alert);
//            $jenis = Jenisjaminan::all();
//            $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
//            $pinjaman = Pinjaman::findOrNew($pinjaman->id);
//            $jaminan = Jaminan::where('id_pinjaman', $pinjaman->id)->get();
//            $pengaturan = Pengaturan::all();
//            $anggota = Anggota::all();
//            $kolektibilitas = Kolektibilitas::all();
//            foreach($pengaturan as $sel) {
//                $pinjaman['selected_no1'] = $pinjaman['nama_pinjaman'] == $sel->id ? 'selected' : '';
//            }
//            foreach($anggota as $sel2) {
//                $pinjaman['selected_no2'] = $pinjaman['kode_anggota'] == $sel2->id ? 'selected' : '';
//            }
//            foreach($kolektibilitas as $sel3) {
//                $pinjaman['selected_no3'] = $pinjaman['kolektibilitas'] == $sel3->id ? 'selected' : '';
//            }
//            return view('pinjaman.ubah_pinjaman2')->with('pinjaman', $pinjaman)
//                ->with('pengaturan', $pengaturan)
//                ->with('anggota', $anggota)
//                ->with('kolektibilitas', $kolektibilitas)
//                ->with('jaminan', $jaminan)
//                ->with('jenis', $jenis)
//                ->with('sistem_bunga', $sistem_bunga)
//                ->with('alert', $alert);
        }
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
        $jenis = Jenisjaminan::all();
        $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
         $pinjaman = Pinjaman::findOrNew($id);
        $jaminan = Jaminan::where('id_pinjaman', $id)->get();
        $pengaturan = Pengaturan::all();
        $anggota = Anggota::where('status', 'AKTIF')->get();
        $kolektibilitas = Kolektibilitas::all();
        return view('pinjaman.ubah_pinjaman')->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('anggota', $anggota)
            ->with('kolektibilitas', $kolektibilitas)
            ->with('jaminan', $jaminan)
            ->with('jenis', $jenis)
            ->with('sistem_bunga', $sistem_bunga);
    }

    public function edit2($id)
    {
        $jenis = Jenisjaminan::all();
        $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
        $pinjaman = Pinjaman::findOrNew($id);
        $jaminan = Jaminan::where('id_pinjaman', $id)->get();
        $pengaturan = Pengaturan::all();
        $anggota = Anggota::where('status', 'AKTIF')->get();
        $kolektibilitas = Kolektibilitas::all();
        return view('pinjaman.ubah_pinjaman2')->with('pinjaman', $pinjaman)
            ->with('pengaturan', $pengaturan)
            ->with('anggota', $anggota)
            ->with('kolektibilitas', $kolektibilitas)
            ->with('jaminan', $jaminan)
            ->with('jenis', $jenis)
            ->with('sistem_bunga', $sistem_bunga);
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
        $jmlpengajuan = str_replace(",","",$request->jumlah_pengajuan);
        $jpengajuan = str_replace(".00","",$jmlpengajuan);

        $jmlangsuranpokok = str_replace(",","",$request->jumlah_angsuran_pokok);
        $japokok = str_replace(".00","",$jmlangsuranpokok);

        $format = 'm/d/Y';
        $tanggal_pengajuan = Carbon::createFromFormat($format,$request->tanggal_pengajuan)->toDateString();
        $jatuh_tempo = Carbon::createFromFormat($format,$request->jatuh_tempo)->toDateString();

        $pengaturan = Pengaturan::find($request->nama_pinjaman);

        $pinjaman = Pinjaman::findOrNew($id);
        $pinjaman->update([
            'nama_pinjaman'      => $request->nama_pinjaman,
            'nomor_pinjaman'     => $request->nomor_pinjaman,
            'anggota'            => $request->kode_anggota,
            'suku_bunga'         => $pengaturan->suku_bunga,
            'sistem_bunga'         => $pengaturan->sistem_bunga,
            'tanggal_pengajuan'  => $tanggal_pengajuan,
            'jumlah_pengajuan'   => $jpengajuan,
            'jangka_waktu'       => $request->jangka_waktu,
            'jatuh_tempo'        => $jatuh_tempo,
            'jumlah_angsuran_pokok'  => $japokok,
            'perhitungan_bunga'      => $request->perhitungan_bunga,
            'digunakan_untuk'        => $request->digunakan_untuk,
            'sumber_dana'            => $request->sumber_dana,
            'keterangan'             => $request->keterangan,
            'status_realisasi'       => $request->status_realisasi,
            'status_lunas'           => $request->status_lunas,
            'status_pasangan'        => $request->status_pasangan,
            'nama_pasangan'          => $request->nama_pasangan,
            'pekerjaan_pasangan'     => $request->pekerjaan_pasangan,
            'alamat_pasangan'        => $request->alamat_pasangan,
            'nomor_telepon_pasangan' => $request->nomor_telepon_pasangan,
            'nama_penjamin'          => $request->nama_penjamin,
            'pekerjaan_penjamin'     => $request->pekerjaan_penjamin,
            'alamat_penjamin'        => $request->alamat_penjamin,
            'nomor_telepon_penjamin' => $request->nomor_telepon_penjamin,
            'nomor_ktp_penjamin'     => $request->nomor_telepon_penjamin
        ]);

//        $jaminan = Jaminan::whereNull('id_pinjaman')->get();
//        foreach($jaminan as $item) {
//            $jamin = Jaminan::findOrNew($item->id);
//            $jamin->update([
//                'id_pinjaman' => $pinjaman->id
//            ]);
//        }

        $msg = "Data Berhasil di Ubah";
        $alert = Toastr::success($msg, $title = "Ubah Pinjaman", $options = []);
        return redirect(url('pinjaman'))
            ->with('alert', $alert);
    }

    public function cekreal($idp) {
        $pinj = Pinjaman::find($idp);

        $data[] = array(
            'statreal'   => $pinj->status_realisasi
        );

        return json_encode($data);
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
        $alert = Toastr::success($msg, $title = "Hapus Pinjaman", $options = []);
        $att = Attach::where('id_pengaturan', $id)->get();
        foreach ($att as $get) {
            Attach::destroy($get->id);
        }
        $app = Approve::where('id_for', $id)->first();
        if ($app != null) {
            Approve::destroy($app->id);
        }
        Pinjaman::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('pinjaman.import_pinjaman');
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

            $result = Excel::load('public/foto/'.$filename)->get();
            foreach ($result as $value) {
//                if ($value->kode != "") {
//                    Pengaturan::create([
//                        'kode'  => $value->kode,
//                        'nama_pinjaman' => $value->nama,
//                        'sistem_bunga'  => 4,
//                        'akun_kas_bank' => 72,
//                        'akun_realisasi' => 72,
//                        'akun_angsuran' => 72,
//                        'akun_bunga' => 72,
//                        'akun_administrasi' => 72,
//                        'akun_denda' => 72,
//                        'biaya_provinsi' => 72,
//                        'akun_lain_lain' => 72,
//                        'akun_hapus_pinjaman' => 72
//                    ]);
//                }
                if ($value->no_pinjaman != "") {
                    $pinj = Pinjaman::where('nomor_pinjaman', $value->no_pinjaman)->first();
                    if ($pinj == null) {
                        $pin = Pinjaman::where('nama_pinjaman', $value->jenis_pinjaman)->where('anggota', $value->no_anggota)->where('status_lunas', 'N')->first();
                        if ($pin == null) {
                            $no++;
                            $pengaturan = Pengaturan::find($value->jenis_pinjaman);
                            $your_date = date("Y-m-d", strtotime($value->tgl_pengajuan));
                            $your_date2 = date("Y-m-d", strtotime($value->tgl_realisasi));
                            $pinjaman = Pinjaman::create([
                                'nama_pinjaman' => $value->jenis_pinjaman,
                                'nomor_pinjaman' => $value->no_pinjaman,
                                //'anggota' => $anggota->id,
                                'anggota' => $value->no_anggota,
                                'suku_bunga' => $pengaturan->suku_bunga,
                                'tanggal_pengajuan' => $your_date,
                                'jumlah_pengajuan' => $value->jml_pengajuan,
                                'jangka_waktu' => $value->waktu_pinjaman,
                                'perhitungan_bunga' => $value->sistem_bunga,
                                'jatuh_tempo' => $value->tgl_bayar_akhir,
                                'jumlah_angsuran_pokok' => $value->angsuran,
                                'status_realisasi' => $value->realisasi,
                                'status_lunas' => $value->lunas,
                                'digunakan_untuk' => $value->digunakan_untuk,
                                'sumber_dana' => $value->sumber_dana,
                                'kolektibilitas' => 1,
                                'keterangan' => $value->keterangan
                            ]);

                            if ($value->realisasi == "Y") {
                                $realisasi = Realisasi::create([
                                    'id_pinjaman' => $pinjaman->id,
                                    'tanggal_realisasi' => $your_date2,
                                    'suku_bunga' => $pengaturan->suku_bunga,
                                    'jangka_waktu' => $value->waktu_pinjaman,
                                    'realisasi' => $value->jml_pengajuan,
                                    'angsuran' => $value->angsuran
                                ]);
                            }
                        }
                    }
                }
            }
            $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : ".$no;
            $alert = Toastr::success($msg, $title = "Import Pinjaman", $options = []);
        } else {
            $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Pinjaman", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('pinjaman/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_pinjaman_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
//                $pinjaman = Pinjaman::all();
//                foreach($pinjaman as $item){
//                    $data=[];
//                    array_push($data, array(
//                        $item->nomor_pinjaman,
//                        $item->anggota
//                    ));
//                    $sheet->fromArray($data, null, 'A2', false, false);
//                }
                $sheet->fromArray(array(
                    array('PJ.0008', '1', '1', '9', '8', 'bulanan', '2015-05-11', '2015-07-23', '70000000', '70100000', '1000000', 'N', 'N', '2016-12-12', '0', 'modal usaha', 'bank', 'sdjjkshds'),
                    array('PJ.0009', '2', '1', '12', '9', 'bulanan', '2015-06-01', '2015-07-08', '100000000', '101000000', '2000000',  'N', 'N', '2016-11-27', '0', 'perang', 'bank', 'kdfidffdio')
                ), null, 'A2', false, false);
                $sheet->row(1, array('NO_PINJAMAN', 'NO_ANGGOTA', 'JENIS_PINJAMAN', 'SUKU_BUNGA', 'WAKTU_PINJAMAN', 'SISTEM_BUNGA', 'TGL_PENGAJUAN', 'TGL_REALISASI', 'JML_PENGAJUAN', 'ANGSURAN', 'JML_REALISASI','REALISASI', 'LUNAS', 'TGL_BAYAR_AKHIR', 'SALDO_AKHIR', 'DIGUNAKAN_UNTUK', 'SUMBER_DANA', 'KETERANGAN'));

                $sheet->setBorder('A1:R1', 'thin');
                $sheet->cells('A1:R1', function($cells){
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
                $sheet->setWidth('G', '20');
                $sheet->setWidth('H', '20');
                $sheet->setWidth('I', '20');
                $sheet->setWidth('J', '20');
                $sheet->setWidth('K', '20');
                $sheet->setWidth('L', '20');
                $sheet->setWidth('M', '20');
                $sheet->setWidth('N', '20');
                $sheet->setWidth('O', '20');
                $sheet->setWidth('P', '20');
                $sheet->setWidth('Q', '20');
                $sheet->setWidth('R', '20');
            });
            return redirect(url('pinjaman/import'));
        })->download('xls');
    }

    public function jaminanpost(Request $request)
    {
        //dd($request->foto);
        $nilai2 = str_replace(",","",$request->nilai);
        $nilai = str_replace(".00","",$nilai2);

        if ($request->foto != "" || $request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/jaminan/';
            $file->move($destinationPath, $filename);

        } else {
            if($request->fot == "fot") {
                $filename = "avatar.jpg";
            } else {
                $filename = $request->fot;
            }
        }

        if ($request->foto2 != "" || $request->hasFile('foto2'))
        {
            $file     = $request->foto2;
            $filename2 = $file->getClientOriginalName();

            $destinationPath = 'foto/jaminan/';
            $file->move($destinationPath, $filename);

        } else {
            if($request->fot2 == "fot2") {
                $filename2 = "avatar.jpg";
            } else {
                $filename2 = $request->fot2;
            }
        }

        $uid = $request->pinid;

        $dataj = [
            'id_pinjaman'   => $uid,
            'jenis_jaminan'     => $request->jenis_jaminan,
            'ikatan_hukum'      => $request->ikatan_hukum,
            'nama_pemilik'      => $request->nama_pemilik,
            'alamat_pemilik'    => $request->alamat_pemilik,
            'nilai'         => $nilai,
            'nomor_arsip'   => $request->nomor_arsip,
            'keterangan'    => $request->keterangan_jamin,
            'foto'          => $filename,
            'foto2'          => $filename2
        ];

        if ($request->pid != "tos") {
            $jaminan = Jaminan::findOrNew($request->pid);
            $jaminan->update($dataj);

        } else {
            $jaminan = Jaminan::create($dataj);
        }


        $jenis = $request->jenis_jaminan;
        $idj = $jaminan->id;
        $jamjenis = Jenisjaminan::findOrNew($jenis);

        if($jamjenis->tabel == "jaminan_simpanan") {
            if($request->pid != "tos") {
                $jemas = Jaminanemas::where('id_jaminan')->first();
                if($jemas != null) {
                    Jaminanemas::destroy($jemas->id);
                }

                $jelektronik = Jaminanelektronik::where('id_jaminan')->first();
                if($jelektronik != null) {
                    Jaminanelektronik::destroy($jelektronik->id);
                }

                $jkendaraan = Jaminankendaraan::where('id_jaminan')->first();
                if($jkendaraan != null) {
                    Jaminankendaraan::destroy($jkendaraan->id);
                }

                $jbangunan = Jaminanbangunan::where('id_jaminan')->first();
                if($jbangunan != null) {
                    Jaminanbangunan::destroy($jbangunan->id);
                }

                $jtanpa = Jaminantanpa::where('id_jaminan')->first();
                if($jtanpa != null) {
                    Jaminantanpa::destroy($jtanpa->id);
                }
            }
            $dtsimpanan = [
                'nomor_simpanan' => $request->nomor_simpanan,
                'id_jaminan'     => $idj,
                'bank'           => $request->bank,
                'jumlah'         => $request->jumlah
            ];
            Jaminansimpanan::create($dtsimpanan);
        }else if($jamjenis->tabel == "jaminan_emas") {
            if($request->pid != "tos") {
                $jsimpanan = Jaminansimpanan::where('id_jaminan')->first();
                if($jsimpanan != null) {
                    Jaminansimpanan::destroy($jsimpanan->id);
                }

                $jelektronik = Jaminanelektronik::where('id_jaminan')->first();
                if($jelektronik != null) {
                    Jaminanelektronik::destroy($jelektronik->id);
                }

                $jkendaraan = Jaminankendaraan::where('id_jaminan')->first();
                if($jkendaraan != null) {
                    Jaminankendaraan::destroy($jkendaraan->id);
                }

                $jbangunan = Jaminanbangunan::where('id_jaminan')->first();
                if($jbangunan != null) {
                    Jaminanbangunan::destroy($jbangunan->id);
                }

                $jtanpa = Jaminantanpa::where('id_jaminan')->first();
                if($jtanpa != null) {
                    Jaminantanpa::destroy($jtanpa->id);
                }
            }
            $dtemas = [
                'nomor_sertifikat' => $request->nomor_sertifikat_emas,
                'id_jaminan'     => $idj,
                'berat'          => $request->berat,
                'karat'          => $request->karat
            ];
            Jaminanemas::create($dtemas);
        }else if($jamjenis->tabel == "jaminan_elektronik") {
            if($request->pid != "tos") {
                $jemas = Jaminanemas::where('id_jaminan')->first();
                if($jemas != null) {
                    Jaminanemas::destroy($jemas->id);
                }

                $jsimpanan = Jaminansimpanan::where('id_jaminan')->first();
                if($jsimpanan != null) {
                    Jaminansimpanan::destroy($jsimpanan->id);
                }

                $jkendaraan = Jaminankendaraan::where('id_jaminan')->first();
                if($jkendaraan != null) {
                    Jaminankendaraan::destroy($jkendaraan->id);
                }

                $jbangunan = Jaminanbangunan::where('id_jaminan')->first();
                if($jbangunan != null) {
                    Jaminanbangunan::destroy($jbangunan->id);
                }

                $jtanpa = Jaminantanpa::where('id_jaminan')->first();
                if($jtanpa != null) {
                    Jaminantanpa::destroy($jtanpa->id);
                }
            }
            $dtelektronik = [
                'nomor_serial'   => $request->nomor_serial,
                'id_jaminan'     => $idj,
                'tipe'           => $request->tipee,
                'merek'          => $request->mereke
            ];
            Jaminanelektronik::create($dtelektronik);
        }else if($jamjenis->tabel == "jaminan_kendaraan") {
            if($request->pid != "tos") {
                $jemas = Jaminanemas::where('id_jaminan')->first();
                if($jemas != null) {
                    Jaminanemas::destroy($jemas->id);
                }

                $jelektronik = Jaminanelektronik::where('id_jaminan')->first();
                if($jelektronik != null) {
                    Jaminanelektronik::destroy($jelektronik->id);
                }

                $jsimpanan = Jaminansimpanan::where('id_jaminan')->first();
                if($jsimpanan != null) {
                    Jaminansimpanan::destroy($jsimpanan->id);
                }

                $jbangunan = Jaminanbangunan::where('id_jaminan')->first();
                if($jbangunan != null) {
                    Jaminanbangunan::destroy($jbangunan->id);
                }

                $jtanpa = Jaminantanpa::where('id_jaminan')->first();
                if($jtanpa != null) {
                    Jaminantanpa::destroy($jtanpa->id);
                }
            }
            $dtkendaraan = [
                'nomor_plat'    => $request->nomor_plat,
                'id_jaminan'    => $idj,
                'nomor_bpkb'    => $request->nomor_bpkb,
                'merek'           => $request->merekk,
                'jenis'           => $request->jenis,
                'tahun'           => $request->tahun,
                'warna'           => $request->warna,
                'nomor_rangka'    => $request->nomor_rangka,
                'bahan_bakar'     => $request->bahan_bakar,
                'tipe'            => $request->tipek,
                'model'           => $request->model,
                'cc'              => $request->cc,
                'jumlah_roda'     => $request->jml_roda,
                'nomor_mesin'     => $request->nomor_mesin
            ];
            Jaminankendaraan::create($dtkendaraan);
        }else if($jamjenis->tabel == "jaminan_bangunan") {
            if($request->pid != "tos") {
                $jemas = Jaminanemas::where('id_jaminan')->first();
                if($jemas != null) {
                    Jaminanemas::destroy($jemas->id);
                }

                $jelektronik = Jaminanelektronik::where('id_jaminan')->first();
                if($jelektronik != null) {
                    Jaminanelektronik::destroy($jelektronik->id);
                }

                $jkendaraan = Jaminankendaraan::where('id_jaminan')->first();
                if($jkendaraan != null) {
                    Jaminankendaraan::destroy($jkendaraan->id);
                }

                $jsimpanan = Jaminansimpanan::where('id_jaminan')->first();
                if($jsimpanan != null) {
                    Jaminansimpanan::destroy($jsimpanan->id);
                }

                $jtanpa = Jaminantanpa::where('id_jaminan')->first();
                if($jtanpa != null) {
                    Jaminantanpa::destroy($jtanpa->id);
                }
            }
            $dtbangunan = [
                'nomor_sertifikat' => $request->nomor_sertifikat_tanah,
                'id_jaminan'     => $idj,
                'kelurahan'      => $request->kelurahan,
                'kecamatan'      => $request->kecamatan,
                'kota'           => $request->kota,
                'provinsi'       => $request->provinsi,
                'nib'            => $request->nib,
                'peruntukan'     => $request->peruntukan,
                'ser_hak'        => $request->ser_hak,
                'luas_tanah'     => $request->luas_tanah,
            ];
            Jaminanbangunan::create($dtbangunan);
        }else {
            if($request->pid != "tos") {
                $jemas = Jaminanemas::where('id_jaminan')->first();
                if($jemas != null) {
                    Jaminanemas::destroy($jemas->id);
                }

                $jelektronik = Jaminanelektronik::where('id_jaminan')->first();
                if($jelektronik != null) {
                    Jaminanelektronik::destroy($jelektronik->id);
                }

                $jkendaraan = Jaminankendaraan::where('id_jaminan')->first();
                if($jkendaraan != null) {
                    Jaminankendaraan::destroy($jkendaraan->id);
                }

                $jbangunan = Jaminanbangunan::where('id_jaminan')->first();
                if($jbangunan != null) {
                    Jaminanbangunan::destroy($jbangunan->id);
                }

                $jsimpanan = Jaminansimpanan::where('id_jaminan')->first();
                if($jsimpanan != null) {
                    Jaminansimpanan::destroy($jsimpanan->id);
                }
            }
            $dttanpa = [
                'nomor' => $request->nomor,
                'id_jaminan'     => $idj
            ];
            Jaminantanpa::create($dttanpa);
        }

        $msg = "Data Jaminan Berhasil di Ditambahkan";
        $alert = Toastr::success($msg, $title = "Jaminan", $options = []);

        return redirect(url('pinjaman/'.$uid.'/edit/jaminan'))->with('alert', $alert);
//        $jenis = Jenisjaminan::all();
//        $sistem_bunga = Sistembunga::where('untuk', 'pinjaman')->get();
//        $pinjaman = Pinjaman::findOrNew($uid);
//        $jaminan = Jaminan::where('id_pinjaman', $uid)->get();
//        $pengaturan = Pengaturan::all();
//        $anggota = Anggota::all();
//        $kolektibilitas = Kolektibilitas::all();
//        foreach($pengaturan as $sel) {
//            $pinjaman['selected_no1'] = $pinjaman['nama_pinjaman'] == $sel->id ? 'selected' : '';
//        }
//        foreach($anggota as $sel2) {
//            $pinjaman['selected_no2'] = $pinjaman['kode_anggota'] == $sel2->id ? 'selected' : '';
//        }
//        foreach($kolektibilitas as $sel3) {
//            $pinjaman['selected_no3'] = $pinjaman['kolektibilitas'] == $sel3->id ? 'selected' : '';
//        }
//        return view('pinjaman.ubah_pinjaman')->with('pinjaman', $pinjaman)
//            ->with('pengaturan', $pengaturan)
//            ->with('anggota', $anggota)
//            ->with('kolektibilitas', $kolektibilitas)
//            ->with('jaminan', $jaminan)
//            ->with('jenis', $jenis)
//            ->with('sistem_bunga', $sistem_bunga)
//            ->with('alert', $alert);
    }

    public function jaminandelete($id, $aksi) {
        Jaminan::destroy($id);
        $jsimpanan = Jaminansimpanan::where('id_jaminan', $id)->get();
        foreach($jsimpanan as $get) {
            Jaminansimpanan::destroy($get->id);
        }

        $jemas = Jaminanemas::where('id_jaminan', $id)->get();
        foreach($jemas as $get2) {
            Jaminanemas::destroy($get2->id);
        }

        $jelektronik = Jaminanelektronik::where('id_jaminan', $id)->get();
        foreach($jelektronik as $get3) {
            Jaminanelektronik::destroy($get3->id);
        }

        $jkendaraan = Jaminankendaraan::where('id_jaminan', $id)->get();
        foreach($jkendaraan as $get4) {
            Jaminankendaraan::destroy($get4->id);
        }

        $jbangunan = Jaminanbangunan::where('id_jaminan', $id)->get();
        foreach($jbangunan as $get5) {
            Jaminanbangunan::destroy($get5->id);
        }

        $jtanpa = Jaminantanpa::where('id_jaminan', $id)->get();
        foreach($jtanpa as $get6) {
            Jaminantanpa::destroy($get6->id);
        }
        return $this->_tablejaminan($aksi);
    }

    public function jaminanedit($id) {
        $jaminan = Jaminan::findOrNew($id);
        $jamjen = Jenisjaminan::findOrNew($jaminan->jenis_jaminan);

        $jaminansimpanan = Jaminansimpanan::where('id_jaminan', $id)->first();
        $jaminanemas = Jaminanemas::where('id_jaminan', $id)->first();
        $jaminanelektronik = Jaminanelektronik::where('id_jaminan', $id)->first();
        $jaminankendaraan = Jaminankendaraan::where('id_jaminan', $id)->first();
        $jaminanbangunan = Jaminanbangunan::where('id_jaminan', $id)->first();
        $jaminantanpa = Jaminantanpa::where('id_jaminan', $id)->first();

        if($jaminansimpanan != null){
            $nosimpanan = $jaminansimpanan->nomor_simpanan;
            $jumlah     = $jaminansimpanan->jumlah;
            $bank       = $jaminansimpanan->bank;
        } else {
            $nosimpanan = "";
            $jumlah     = "";
            $bank       = "";
        }

        if($jaminanemas != null) {
            $nosertifikatemas = $jaminanemas->nomor_sertifikat;
            $berat            = $jaminanemas->berat;
            $karat            = $jaminanemas->karat;
        } else {
            $nosertifikatemas = "";
            $berat            = "";
            $karat            = "";
        }

        if($jaminanelektronik != null) {
            $noserial         = $jaminanelektronik->nomor_serial;
            $tipee            = $jaminanelektronik->tipe;
            $mereke           = $jaminanelektronik->merek;
        } else {
            $noserial         = "";
            $tipee            = "";
            $mereke           = "";
        }

        if($jaminantanpa != null) {
            $nomor = $jaminantanpa->nomor;
        } else {
            $nomor = "";
        }

        if($jaminanbangunan != null) {
            $nosertifikattanah  = $jaminanbangunan->nomor_sertifikat;
            $kelurahan          = $jaminanbangunan->kelurahan;
            $kecamatan          = $jaminanbangunan->kecamatan;
            $kota               = $jaminanbangunan->kota;
            $provinsi           = $jaminanbangunan->provinsi;
            $nib                = $jaminanbangunan->nib;
            $peruntukan         = $jaminanbangunan->peruntukan;
            $serhak             = $jaminanbangunan->se_hak;
            $luastanah          = $jaminanbangunan->luas_tanah;
        } else {
            $nosertifikattanah  = "";
            $kelurahan          = "";
            $kecamatan          = "";
            $kota               = "";
            $provinsi           = "";
            $nib                = "";
            $peruntukan         = "";
            $serhak             = "";
            $luastanah          = "";
        }

        if($jaminankendaraan != null) {
            $noplat         = $jaminankendaraan->nomor_plat;
            $nobpkb         = $jaminankendaraan->nomor_bpkb;
            $merekk         = $jaminankendaraan->merek;
            $jenis          = $jaminankendaraan->jenis;
            $tahun          = $jaminankendaraan->tahun;
            $warna          = $jaminankendaraan->warna;
            $norangka       = $jaminankendaraan->nomor_rangka;
            $bahanbakar     = $jaminankendaraan->bahan_bakar;
            $tipek          = $jaminankendaraan->tipe;
            $model          = $jaminankendaraan->model;
            $cc             = $jaminankendaraan->cc;
            $jmlroda        = $jaminankendaraan->jumlah_roda;
            $nomesin        = $jaminankendaraan->nomor_mesin;
        } else {
            $noplat         = "";
            $nobpkb         = "";
            $merekk         = "";
            $jenis          = "";
            $tahun          = "";
            $warna          = "";
            $norangka       = "";
            $bahanbakar     = "";
            $tipek          = "";
            $model          = "";
            $cc             = "";
            $jmlroda        = "";
            $nomesin        = "";
        }

        if($jaminan->id_pinjaman != null){
            $nopin = $jaminan->pinjamanid->nomor_pinjaman;
        }else {
            $nopin = "Nomor Pinjaman";
        }
        $data[] = array(
            'fot'               => $jaminan->foto,
            'fot2'               => $jaminan->foto2,
            'yyy'               => $jamjen->tabel,
            'nopinjaman'        => $nopin,
            'jenis_jaminan'     => $jaminan->jenis_jaminan,
            'ikatan_hukum'      => $jaminan->ikatan_hukum,
            'nama_pemilik'      => $jaminan->nama_pemilik,
            'alamat_pemilik'    => $jaminan->alamat_pemilik,
            'nilai'         => number_format($jaminan->nilai, 2, '.', ','),
            'nomor_arsip'   => $jaminan->nomor_arsip,
            'keterangan'    => $jaminan->keterangan,
            'nosimpanan'    => $nosimpanan,
            'jumlah'        => $jumlah,
            'bank'          => $bank,
            'nosertifikatemas'  => $nosertifikatemas,
            'berat'             => $berat,
            'karat'             => $karat,
            'noserial'          => $noserial,
            'tipee'              => $tipee,
            'mereke'             => $mereke,
            'nosertifikattanah'     => $nosertifikattanah,
            'kelurahan'             => $kelurahan,
            'kecamatan'             => $kecamatan,
            'kota'                  => $kota,
            'provinsi'              => $provinsi,
            'nib'                   => $nib,
            'peruntukan'            => $peruntukan,
            'serhak'                => $serhak,
            'luastanah'             => $luastanah,
            'noplat'        => $noplat,
            'nobpkb'        => $nobpkb,
            'merekk'        => $merekk,
            'jenis'         => $jenis,
            'tahun'         => $tahun,
            'warna'         => $warna,
            'norangka'      => $norangka,
            'bahanbakar'    => $bahanbakar,
            'tipek'         =>$tipek,
            'model'         =>$model,
            'cc'            =>$cc,
            'jmlroda'       =>$jmlroda,
            'nomesin'       =>$nomesin,
            'nomor'  => $nomor
        );

        return json_encode($data);
    }

    public function jaminanedit2($id)
    {
        $jenis = Jenisjaminan::all();
        echo '<select name="jenis_jaminan" type="text" class="form-control" id="jenis_jaminan" placeholder="Jenis" style="width: 100%">';
        foreach ($jenis as $tampil) {
            $pilih = $tampil->id == $id ? 'selected' : '';
            echo '<option value="'.$tampil->id.'" '.$pilih.'>'.$tampil->jenis.'</option>';
        }
        echo '</select>';
    }

    public function jaminanedit3($id) {
        $simpanan = $id == "simpanan" ? 'selected' : '';
        $apht = $id == "apht" ? 'selected' : '';
        $skmht = $id == "skmht" ? 'selected' : '';
        $fiducia = $id == "fiducia" ? 'selected' : '';
        $kuasa = $id == "kuasa" ? 'selected' : '';

        echo '<select name="ikatan_hukum" type="text" class="form-control" id="ikatan_hukum" placeholder="Ikatan Hukum" style="width: 100%">';
        echo '<option value="simpanan" '.$simpanan.'>Simpanan</option>';
        echo '<option value="apht" '.$apht.'>apht</option>';
        echo '<option value="skmht" '.$skmht.'>skmht</option>';
        echo '<option value="fiducia" '.$fiducia.'>fiducia</option>';
        echo '<option value="kuasa" '.$kuasa.'>Surat Kuasa Menjual</option>';
        echo '</select>';
    }

    public function _tablejaminan($aksi) {
        $jaminan = Jaminan::where('id_pinjaman', $aksi)->get();
        return $this->_table($jaminan);
    }

    public function _table($jaminan) {
        echo '<table class="table table-bordered table-striped mg-t datatable editable-datatable" id="table">';
        echo '<thead>';
        echo '<tr style="background-color: dodgerblue; color: white">';
        echo '<th class="text-center" width="20">No</th>';
        echo '<th class="text-center">Jenis Agunan</th>';
        echo '<th class="text-center">Ikatan Hukum</th>';
        echo '<th class="text-center">Pemilik</th>';
        echo '<th class="text-center">Alamat</th>';
        echo '<th class="text-center">Keterangan</th>';
        echo '<th class="text-center">Option</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $i = 1;
        foreach ($jaminan as $value) {
            echo '<tr>';
            echo '<td class="text-center">'.$i++.'</td>';
            echo '<td>'.$value->jenisid->jenis.'</td>';
            echo '<td>'.$value->ikatan_hukum.'</td>';
            echo '<td>'.$value->nama_pemilik.'</td>';
            echo '<td>'.$value->alamat_pemilik.'</td>';
            echo '<td>'.$value->keterangan.'</td>';
            echo '<td align="center fa-hover">';
            echo '<a href="#" onclick="isedit({!! $value->id !!})" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>';
            echo '<a href="#" onclick="isdelete({!! $value->id !!})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function search2($pilih, $radio) {
        if($radio == "all") {
            if ($pilih > 0) {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->orderBy('id','asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->count();
            } else {
                $pinjaman = Pinjaman::where('status_tutup', 0)->orderBy('id', 'asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->count();
            }
        } else if($radio == "belum") {
            $statr = "N";
            $statl = "N";
            if ($pilih > 0) {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->where('status_lunas', $statl)->orderBy('id', 'asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->where('status_lunas', $statl)->count();
            } else {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('status_realisasi', $statr)->where('status_lunas', $statl)->orderBy('id', 'asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('status_realisasi', $statr)->where('status_lunas', $statl)->count();
            }
        }else if($radio == "sudah") {
            $statr = "Y";
            if ($pilih > 0) {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->orderBy('id', 'asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->count();
            } else {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('status_realisasi', $statr)->orderBy('id', 'asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('status_realisasi', $statr)->count();
            }
        }else {
            $statr = "Y";
            $statl = "Y";
            if ($pilih > 0) {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->where('status_lunas', $statl)->orderBy('id', 'asc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->where('status_lunas', $statl)->count();
            } else {
                $pinjaman = Pinjaman::where('status_tutup', 0)->where('status_realisasi', $statr)->where('status_lunas', $statl)->orderBy('id', 'desc')->paginate(20);
                $jml = Pinjaman::where('status_tutup', 0)->where('status_realisasi', $statr)->where('status_lunas', $statl)->count();
            }
        }

        $kolektibilitas = Kolektibilitas::all();

            //$pinjaman = Pinjaman::where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->where('status_lunas', $statl)->orderBy('id','desc')->paginate(20);
            //$jml = Pinjaman::where('kolektibilitas', $pilih)->where('status_realisasi', $statr)->where('status_lunas', $statl)->orderBy('id','desc')->count();

        return view('pinjaman.cari2_pinjaman')->with('pinjaman', $pinjaman)
            ->with('kolektibilitas', $kolektibilitas)->with('jml',$jml)
            ->with('pilih', $pilih)->with('radio', $radio);
    }

    public function ajaxpinjaman(Request $request) {

        $jmlpengajuan = str_replace(",","",$request->pengajuan);
        $pengajuan = str_replace(".00","",$jmlpengajuan);

        $jangkawaktu = str_replace(",","",$request->waktu);
        $waktu = str_replace(".00","",$jangkawaktu);

        $total = $pengajuan / $waktu;

        $data[] = array(
            'angsur' => number_format($total, 2, '.', ',')
        );

        return json_encode($data);
    }

    public function testSimulasi(Request $request, $ids, $idp) {

        $pengaturan = Pengaturan::findOrNew($idp);
        $sistem_bunga = Sistembunga::findOrNew($ids);
        $hitung = $request->hitung;

        if (count($sistem_bunga)==0) {
            echo '<tr class="bungatr"><td colspan="5" style="text-align:center">Data pinjaman tidak ditemukan</td></tr>';
        }

        else {

            $jmlpengajuan = str_replace(",","",$request->pengajuan);
            $jpengajuan = str_replace(".00","",$jmlpengajuan);

            $jangkawaktu = str_replace(",","",$request->waktu);
            $jwaktu = str_replace(".00","",$jangkawaktu);

            $sukubunga = str_replace(",","",$request->bunga);
            $sbunga = str_replace(".00","",$sukubunga);

            if ($sistem_bunga->sistem=='Bunga Tetap') {
                $pokok = $jpengajuan/$jwaktu;
                if ($pengaturan->tipe_maksimum_waktu == "bulan") {
                    $bunga = $jpengajuan / $jwaktu * $sbunga / 100 / 12;
                }else {
                    $bunga = $jpengajuan / $jwaktu * $sbunga / 100 / 365;
                }
                $angsuran = $pokok+$bunga;
                $no = 0;

                for ($i = 0; $i <= $jwaktu; $i++) {
                    if ($no==0) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($jpengajuan, 2, '.', ',');
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
                        echo number_format($jpengajuan-=$pokok, 2, '.', ',');
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
                $pokok = $jpengajuan/$jwaktu;
                $bungath = $jpengajuan*$sbunga/100;
                if ($pengaturan->tipe_maksimum_waktu == "bulan") {
                    $bunga = $bungath / 12;
                }else {
                    $bunga = $bungath / 365;
                }
//                if($hitung == "bulanan") {
//                    $bunga = $jpengajuan*$sbunga/100/12;
//                } else {
//                    $bunga = $jpengajuan*$sbunga/100*30/360;
//                }
                $bunga2 = $bunga/$jwaktu;
                $angsuran = $pokok+$bunga;
                $no = 0;

                for ($i=0; $i <= $jwaktu; $i++) {
                    if ($no==0) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($jpengajuan, 2, '.', ',');
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
                        echo number_format($jpengajuan-=$pokok, 2, '.', ',');
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
                        echo number_format($jpengajuan-=$pokok, 2, '.', ',');
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

                $bungath = $jpengajuan*$sbunga/100;

                $angsuran = $jpengajuan*$sbunga/100/12/(1-1/(pow(1+($sbunga/100/12),$jwaktu)));
                if ($pengaturan->tipe_maksimum_waktu == "bulan") {
                    $bunga = $bungath / 12;
                }else {
                    $bunga = $bungath / 365;
                }
//                if($hitung == "bulanan") {
//                    $bunga = $jpengajuan*$sbunga/100/12;
//                } else {
//                    $bunga = $jpengajuan*$sbunga/100*30/360;
//                }
                $pokok = $angsuran-$bunga;
                // Other variable
                $pokok_pinjaman = $jpengajuan-$pokok;
                $bungath2 = $pokok_pinjaman*$sbunga/100;
                if ($pengaturan->tipe_maksimum_waktu == "bulan") {
                    $dummy_bunga = $bungath2 / 12;
                }else {
                    $dummy_bunga = $bungath2 / 365;
                }
//                if($hitung == "bulanan") {
//                    $dummy_bunga = $pokok_pinjaman*$sbunga/100/12;
//                } else {
//                    $dummy_bunga = $pokok_pinjaman*$sbunga/100*30/360;
//                }
                $dummy_pokok = $angsuran-$dummy_bunga;

                for ($i=0; $i <= $jwaktu; $i++) {
                    if ($no==0) {
                        echo '<tr class="bungatr">';
                        echo '<td class="text-center">';
                        echo $no++;
                        echo '</td>';
                        echo '<td class="text-right">';
                        echo number_format($jpengajuan, 2, '.', ',');
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
                        $ppi = $pokok_pinjaman;
                        if($hitung == "bulanan") {
                            $dummy_bunga2 = $ppi*$sbunga/100/12;
                        } else {
                            $dummy_bunga2 = $ppi*$sbunga/100*30/360;
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

    public function cekpinjam($ida) {
        $pinjaman = Pinjaman::where('anggota', $ida)->where('status_realisasi', 'Y')->where('status_lunas', 'N')->first();

        if ($pinjaman != null){
            $stat = "FAIL";
            $title = "Tambah Pinjaman";
            $psg = "Pinjaman yang dilakukan oleh anggota : ".$pinjaman->anggotaid->kode." - ".$pinjaman->anggotaid->nama."<br> dengan nomor pinjaman : ".$pinjaman->nomor_pinjaman." belum LUNAS";
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

    public function cektempo($tgl, $sel, $idp) {
        $pengaturan = Pengaturan::find($idp);
        if ($pengaturan->tipe_maksimum_waktu == "bulan") {
            $bln = "month";
        } else {
            if ($sel == 1) {
                $bln = "day";
            } else {
                $bln = "days";
            }
        }
        $jtempo2 = strtotime('+'.$sel.' '.$bln, strtotime($tgl));// jangka waktu + 365 hari
        $tgltempo=date("m/d/Y",$jtempo2);//tanggal expired

        $data[] = array(
            'tgl' => $tgltempo
        );

        return json_encode($data);
    }

    public function _setkolektibilitas($idp) {

        $kolek1 = Kolektibilitas::orderBy('batas_hari', 'asc')->take(1)->first();
        $kol1 = $kolek1->batas_hari;
        $kolid1 = $kolek1->id;
        $kolek2 = Kolektibilitas::orderBy('batas_hari', 'asc')->take(2)->get();
        foreach ($kolek2 as $get) {
            $kol2 = $get->batas_hari;
            $kolid2 = $get->id;
        }
        $kolek3 = Kolektibilitas::orderBy('batas_hari', 'asc')->take(3)->get();
        foreach ($kolek3 as $get2) {
            $kol3 = $get2->batas_hari;
            $kolid3 = $get2->id;
        }
        $kolek4 = Kolektibilitas::orderBy('batas_hari', 'asc')->take(4)->get();
        foreach ($kolek4 as $get3) {
            $kol4 = $get3->batas_hari;
            $kolid4 = $get3->id;
        }
        $kolek5 = Kolektibilitas::orderBy('batas_hari', 'asc')->take(5)->get();
        foreach ($kolek5 as $get4) {
            $kol5 = $get4->batas_hari;
            $kolid5 = $get4->id;
        }

        $bayarpinjaman = Pembayaran::where('id_pinjaman', $idp)->where('start', '1')->get();

        $s = 0;
        foreach ($bayarpinjaman as $key => $item) {
            $jml = ((abs(strtotime($item->tanggal_bayar) - strtotime($item->tanggal))) / (60 * 60 * 24));
            if ($item->tanggal_bayar > $item->tanggal) {
                $j = "plus";
                $s+=$jml;
            } else {
                $j = "minus";
            }
        }

        if ($s <= $kol1) {
            $idkol = $kolid1;
        } else if ($s <= $kol2 && $s > $kol1) {
            $idkol = $kolid2;
        } else if ($s <= $kol3 && $s > $kol2) {
            $idkol = $kolid3;
        } else if ($s <= $kol4 && $s > $kol3) {
            $idkol = $kolid4;
        } else if ($s <= $kol5 && $s > $kol4) {
            $idkol = $kolid5;
        }

        $pinjaman = Pinjaman::find($idp);
        $pinjaman->update(['kolektibilitas' => $idkol]);

        $data[] = array('stat' => 'OK');

        return json_encode($data);
    }

    public function tutuppinjaman($id){
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $pinjaman = Pinjaman::find($id);
        $pinnya = Pinjaman::find($id);
        $pinnya->update(['status_lunas' => 'Y', 'status_tutup' => 1]);
        $bayarnya = Pembayaran::where('id_pinjaman', $id)->where('start', 0)->get();
        foreach ($bayarnya as $byr) {

            $pembayaran = Pembayaran::where('id_pinjaman', $id)->where('start', '1')->orderBy('id', 'desc')->first();
            $bayarnext = Pembayaran::find($byr->id);
            $bayarlast = Pembayaran::where('id_pinjaman', $id)->where('start', '1')->orderBy('bulan_ke', 'desc')->first();

            $toldenda = $pinjaman->pengaturanid->toleransi_denda;
            $mindenda = strtotime('+' . $toldenda . ' day', strtotime($bayarnext->tanggal));// jangka waktu + 365 hari
            $tgldenda = date("Y-m-d", $mindenda);//tanggal expired

            if ($today > $tgldenda) {
                $hari = ((abs(strtotime($today) - strtotime($tgldenda))) / (60 * 60 * 24));
                if ($pinjaman->pengaturanid->tipe_denda_perhari == "denda_nominal") {
                    $dendanya = $pinjaman->pengaturanid->jumlah_denda_perhari * $hari;
                } else if ($pinjaman->pengaturanid->tipe_denda_perhari == "saldo_X_persen%_X_hari") {
                    $bayarnya = Pembayaran::where('id_pinjaman', $id)->where('start', '1')->where('bulan_ke', $pembayaran->bulan_ke)->first();
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

        $dendab = 0;
        $bayarpokok = Pembayaran::where('id_pinjaman', $id)->where('start', '0')->sum('pokok');
        $bayarbunga = Pembayaran::where('id_pinjaman', $id)->where('start', '0')->sum('bunga');
        $bayardenda = Pembayaran::where('id_pinjaman', $id)->where('start', '0')->sum('denda');
        $dendab = $bayardenda;

        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe'      => "KREDIT",
            'kode_jurnal'   => "TTP".$this->_generatekodejurnal(),
            'tanggal'   => date('Y-m-d H:i:s'),
            'keterangan'=> 'TUTUP PINJAMAN'
        ]);

        $detail = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $pinjaman->pengaturanid->akun_piutang_tak_tertagih,
            'debet' => $bayarpokok + $bayarbunga + $dendab,
            'kredit' => "",
            'nominal' => $bayarpokok + $bayarbunga + $dendab
        ]);

        $detail2 = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $pinjaman->pengaturanid->akun_piutang_pinjaman,
            'debet' => "",
            'kredit' => $bayarpokok,
            'nominal' => $bayarpokok
        ]);

        $detail3 = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $pinjaman->pengaturanid->akun_bunga,
            'debet' => "",
            'kredit' => $bayarbunga,
            'nominal' => $bayarbunga
        ]);

        if ($dendab > 0) {
            $detail4 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $pinjaman->pengaturanid->akun_denda,
                'debet' => "",
                'kredit' => $dendab,
                'nominal' => $dendab
            ]);
        }

        $msg = "Pinjaman Berhasil Di Tutup";
        $alert = Toastr::success($msg, $title = "Tutup Pinjaman", $options = []);
        return redirect(url()->previous())->with('alert', $alert);
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

    public function rejectpinjaman($id) {
        Realisasi::where('id_pinjaman', $id)->delete();
        Approve::where('id_for', $id)->delete();

        $pinjaman = Pinjaman::find($id);
        $pinjaman->update(['status_realisasi' => 'N']);

        $msg = "Pinjaman Berhasil Di Reject";
        $alert = Toastr::success($msg, $title = "Reject Pinjaman", $options = []);
        return redirect(url()->previous())->with('alert', $alert);
    }

}
