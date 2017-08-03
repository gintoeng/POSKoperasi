<?php

namespace App\Http\Controllers\Pinjaman;

use App\Aksestutup;
use App\Approverole;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Master\Katshudetail;
use App\Model\Pinjaman\Pengaturan;
use App\Model\Pinjaman\Pinjaman;
use App\Model\Sistembunga;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengaturan = Pengaturan::orderBy('id','asc')->paginate(20);
        $jml = Pengaturan::count();
        return view('pinjaman.pengaturan.daftar_pengaturan')->with('pengaturan', $pengaturan)->with('jml',$jml);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $pengaturan = Pengaturan::where('kode','like','%'.$query.'%')->orWhere('nama_pinjaman','like','%'.$query.'%')->orWhere('kode_awal_rekening','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Pengaturan::where('kode','like','%'.$query.'%')->orWhere('nama_pinjaman','like','%'.$query.'%')->orWhere('kode_awal_rekening','like','%'.$query.'%')->count();
        return view('pinjaman.pengaturan.cari_pengaturan')->with('pengaturan', $pengaturan)->with('query',$query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sistem = Sistembunga::where('untuk', 'pinjaman')->get();
//        $shu = Katshudetail::where('id_header', '2')->get();
        $shu = Katshudetail::all();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        return view('pinjaman.pengaturan.tambah_pengaturan')->with('sistem', $sistem)->with('shu', $shu)
            ->with('perkiraan', $perkiraan)->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $adminbank = str_replace(",","",$request->admin_bank);
        $adminb = str_replace(".00","",$adminbank);

        $valatur = Pengaturan::where('kode', $request->kode)->orWhere('nama_pinjaman', $request->nama_pinjaman)->first();
        if ($valatur == null) {
            $pengaturan = Pengaturan::create([
                'kode' => $request->kode,
                'nama_pinjaman' => $request->nama_pinjaman,
                'suku_bunga' => $request->suku_bunga,
                'sistem_bunga' => $request->sistem_bunga,
                'maksimum_waktu' => $request->maksimum_waktu,
//                'tipe_maksimum_waktu' => $request->tipe_maksimum_waktu,
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
                'gambar2' => $filename2,
                'id_shu' => $request->shu,
                'tipe_pinjaman' => $request->tipe_pinjaman,
                'biaya_admin_bank' => $adminb,
                'biaya_admin_fee'  => $request->admin_fee,
                'biaya_admin_tambahan' => $request->admin_tambahan
            ]);

            if (count($request['levels']) > 0) {
                for ($i = 0; $i < count($request['levels']); $i++) {
                    $approve = Approverole::create([
                        'id_user' => $request['users'][$i],
                        'id_for' => $pengaturan->id,
                        'for' => "pinjaman",
                        'level' => $request['levels'][$i]
                    ]);
                }
            }

            if (count($request['users2']) > 0) {
                for ($i = 0; $i < count($request['users2']); $i++) {
                    $akses = Aksestutup::create([
                        'id_user' => $request['users2'][$i],
                        'id_for' => $pengaturan->id,
                        'tutup' => "pinjaman"
                    ]);
                }
            }

            $msg = "Data Berhasil di Ditambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Pengaturan", $options = []);
        } else {
            if ($request->kode == $valatur->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_pinjaman == $valatur->nama_pinjaman) {
                $dg = "dengan nama pinjaman : ".$request->nama_pinjaman;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Pengaturan", $options = []);
        }

        return redirect(url('pinjaman/pengaturan'))
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
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        $pengaturan = Pengaturan::findOrNew($id);
        $sistem = Sistembunga::where('untuk', 'pinjaman')->get();
//        $shu = Katshudetail::where('id_header', '2')->get();
        $shu = Katshudetail::all();
        $approve = Approverole::where('for', 'pinjaman')->where('id_for', $id)->get();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $akses2 = Aksestutup::where('tutup', 'pinjaman')->where('id_for', $id)->get();
        return view('pinjaman.pengaturan.ubah_pengaturan')->with('pengaturan', $pengaturan)
            ->with('sistem', $sistem)
            ->with('shu', $shu)
            ->with('user', $user)
            ->with('approve', $approve)
            ->with('akses2', $akses2)
            ->with('perkiraan', $perkiraan);

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
        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/pinjaman/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = $request->gambar;
        }

        if ($request->hasFile('foto2'))
        {
            $file     = $request->foto2;
            $filename2 = $file->getClientOriginalName();

            $destinationPath = 'foto/pinjaman/';
            $file->move($destinationPath, $filename2);

        } else {
            $filename2 = $request->gambar2;
        }
        $dendaperhari = str_replace(",","",$request->jumlah_denda_perhari);
        $dendap = str_replace(".00","",$dendaperhari);

        $adminbank = str_replace(",","",$request->admin_bank);
        $adminb = str_replace(".00","",$adminbank);

        $valatur = Pengaturan::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama_pinjaman', $request->nama_pinjaman)->where('id', '!=', $id)->first();
        if ($valatur == null) {
            $pengaturan = Pengaturan::findOrNew($id);
            $pengaturan->update([
                'kode' => $request->kode,
                'nama_pinjaman' => $request->nama_pinjaman,
                'suku_bunga' => $request->suku_bunga,
                'sistem_bunga' => $request->sistem_bunga,
                'maksimum_waktu' => $request->maksimum_waktu,
//                'tipe_maksimum_waktu' => $request->tipe_maksimum_waktu,
                'tipe_maksimum_waktu' => "bulan",
                'tipe_denda_perhari' => $request->tipe_denda_perhari,
                'jumlah_denda_perhari' => $request->dendap,
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
                'akun_pinjaman' => $request->akun_pinjaman,
                'akun_piutang_baru' => $request->akun_piutang_baru,
                'akun_piutang_lama' => $request->akun_piutang_lama,
                'akun_piutang_tak_tertagih' => $request->akun_piutang_tak_tertagih,
                'kode_awal_rekening' => $request->kode_awal_rekening,
                'jumlah_digit_rekening' => $request->jumlah_digit_rekening,
                'nomor_akhir_rekening' => $request->nomor_akhir_rekening,
                'gambar' => $filename,
                'gambar2' => $filename2,
                'id_shu' => $request->shu,
                'tipe_pinjaman' => $request->tipe_pinjaman,
                'biaya_admin_bank' => $adminb,
                'biaya_admin_fee'  => $request->admin_fee,
                'biaya_admin_tambahan' => $request->admin_tambahan
            ]);

            if (count($request['levels']) > 0) {
                for ($i = 0; $i < count($request['levels']); $i++) {
                    $app = Approverole::where('for', 'pinjaman')->where('id_for', $id)->where('id_user', $request['users'][$i])->where('level', $request['levels'][$i])->first();
                    if ($app == null) {
                        $data = [
                            'id_user' => $request['users'][$i],
                            'id_for' => $pengaturan->id,
                            'for' => "pinjaman",
                            'level' => $request['levels'][$i]
                        ];

                        if (count($request['levels']) > count($request['ida'])) {
                            $approve = Approverole::create($data);
                        } else {
                            $app2 = Approverole::find($request['ida'][$i]);
                            $app2->update($data);
                        }

                    }
                }
            }

            if (count($request['users2']) > 0) {
                for ($i = 0; $i < count($request['users2']); $i++) {
                    $app = Aksestutup::where('tutup', 'pinjaman')->where('id_for', $id)->where('id_user', $request['users2'][$i])->first();
                    if ($app == null) {
                        $data = [
                            'id_user' => $request['users2'][$i],
                            'id_for' => $pengaturan->id,
                            'tutup' => "pinjaman"
                        ];
                        if (count($request['users2']) > count($request['ida2'])) {
                            $akses = Aksestutup::create($data);
                        } else {
                            $app2 = Aksestutup::find($request['ida2'][$i]);
                            $app2->update($data);
                        }

                    }
                }
            }

            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Pengaturan", $options = []);
        } else {
            if ($request->kode == $valatur->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_pinjaman == $valatur->nama_pinjaman) {
                $dg = "dengan nama pinjaman : ".$request->nama_pinjaman;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Pengaturan", $options = []);
        }
//        return redirect(url('pinjaman/pengaturan'))
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
        $app = Approverole::where('for', 'pinjaman')->where('id_for', $id)->get();
        foreach ($app as $get) {
            Approverole::destroy($get->id);
        }

        $app2 = Aksestutup::where('tutup', 'pinjaman')->where('id_for', $id)->get();
        foreach ($app2 as $get2) {
            Aksestutup::destroy($get2->id);
        }

        $msg = "Data Berhasil di Hapus";
        $alert = Toastr::success($msg, $title = "Hapus Pengaturan", $options = []);
        Pengaturan::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }

    public function destroyapprove($id)
    {
        Approverole::destroy($id);
        $data[] = array('stat' => "OK");
        return json_encode($data);
    }

    public function destroyakses($id)
    {
        Aksestutup::destroy($id);
        $data[] = array('stat' => "OK");
        return json_encode($data);
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
        echo '<input name="nomor_pinjaman" type="text" class="form-control disabled" id="no_pinjaman" placeholder="Nomor Pinjaman" readonly value="'.$nomor.'">';
        echo '<span class="input-group-addon"><i class="ti-lock"></i></span>';

    }

    public function sukubunga($id) {
        $sb = Pengaturan::findOrNew($id);
        echo '<input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" placeholder="Suku Bunga" value="'.$sb->suku_bunga.'" readonly>';
        echo '<span class="input-group-addon">% PA</span>';
    }

    public function sistembunga($id) {
        $sb = Pengaturan::findOrNew($id);
        echo '<input type="hidden" id="simbid" value="'.$sb->sistem_bunga.'">';
        echo '<input type="hidden" id="simb" value="'.$sb->sbunga->sistem.'">';
        echo '<input type="hidden" id="tw" name="tw" value="'.$sb->tipe_maksimum_waktu.'">';
        echo '<input name="sistem_bunga" id="sistem_bunga" value="'.$sb->sbunga->sistem.'" type="text" class="form-control disabled" placeholder="Sistem Bunga" readonly>';
    }

    public function jkredit($id) {
        $sb = Pengaturan::findOrNew($id);
        
        if ($sb->tipe_maksimum_waktu == "bulan") {
            echo '<span id="adtw" class="input-group-addon">Bulan</span>';
        } else {
            echo '<span id="adtw" class="input-group-addon">Hari</span>';
        }
        
    }

    public function jkredit2($id) {
        $sb = Pengaturan::findOrNew($id);

        if ($sb->tipe_maksimum_waktu == "bulan") {
            $tr = "bulanan";
        } else {
            $tr = "harian";
        }

        $data[] = array(
            'type' => $tr
        );

        return json_encode($data);
    }

    public function wwk($id, $wk){
        $pengaturan = Pengaturan::find($id);

        //if ($pengaturan->tipe_maksimum_waktu == "bulan") {
            $bagi = $pengaturan->maksimum_waktu;
//        } else {
//            $bagi = $pengaturan->maksimum_waktu/30;
//        }

        if ($wk > $bagi) {
            $hs = $bagi;
            $data[] = array('stat' => 'FAIL', 'hs' => $hs);
        } else {
            $hs = $wk;
            $data[] = array('stat' => 'OK', 'hs' => $hs);
        }

        return json_encode($data);
    }
}
