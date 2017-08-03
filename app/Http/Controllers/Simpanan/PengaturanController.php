<?php

namespace App\Http\Controllers\Simpanan;

use App\Aksestutup;
use App\Approverole;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Master\Katshudetail;
use App\Model\Simpanan\Pengaturan;
use App\Model\Simpanan\Simpanan;
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
        $pengaturan = Pengaturan::orderBy('id', 'asc')->paginate(20);
        $jml = Pengaturan::count();
        return view('simpanan.pengaturan.daftar_pengaturan')->with('pengaturan', $pengaturan)->with('jml', $jml);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $pengaturan = Pengaturan::where('kode','like','%'.$query.'%')->orWhere('jenis_simpanan','like','%'.$query.'%')->orWhere('kode_awal_rekening','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Pengaturan::where('kode','like','%'.$query.'%')->orWhere('jenis_simpanan','like','%'.$query.'%')->orWhere('kode_awal_rekening','like','%'.$query.'%')->count();
        return view('simpanan.pengaturan.cari_pengaturan')->with('pengaturan', $pengaturan)->with('query',$query)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        $sistem = Sistembunga::where('untuk', 'simpanan')->get();
//        $shu = Katshudetail::where('id_header', 1)->get();
        $shu = Katshudetail::all();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        return view('simpanan.pengaturan.tambah_pengaturan')->with('sistem', $sistem)->with('shu', $shu)->with('user', $user)
            ->with('perkiraan', $perkiraan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->autocreate == 1) {
            $auto = $request->autocreate;
        } else {
            $auto = 0;
        }
        $saldominbunga = str_replace(",","",$request->saldo_minimum_bunga);
        $samb = str_replace(".00","",$saldominbunga);

        $saldomin = str_replace(",","",$request->saldo_minimum);
        $sam = str_replace(".00","",$saldomin);

        $saldominpajak = str_replace(",","",$request->saldo_minimum_pajak);
        $samp = str_replace(".00","",$saldominpajak);

        $saldominshu = str_replace(",","",$request->saldo_minimum_shu);
        $sams = str_replace(".00","",$saldominshu);

        $setoranmin = str_replace(",","",$request->setoran_minimum);
        $sem = str_replace(".00","",$setoranmin);

        $administrasi = str_replace(",","",$request->administrasi);
        $adm = str_replace(".00","",$administrasi);

        $valatur = Pengaturan::where('kode', $request->kode)->orWhere('jenis_simpanan', $request->jenis_simpanan)->first();
        if ($valatur == null) {
            $pengaturan = Pengaturan::create([
                'kode' => $request->kode,
                'jenis_simpanan' => $request->jenis_simpanan,
                'suku_bunga' => $request->suku_bunga,
                'sistem_bunga' => $request->sistem_bunga,
                'saldo_minimum_bunga' => $samb,
                'saldo_minimum' => $sam,
                'setoran_minimum' => $sem,
                'saldo_minimum_pajak' => $samp,
                'saldo_minimum_shu' => $sams,
                'autocreate' => $auto,
                'id_shu'    => $request->shu,
                'administrasi' => $adm,
                'persen_pajak' => $request->persen_pajak,
                'akun_kas_bank' => $request->akun_kas_bank,
                'akun_setoran' => $request->akun_setoran,
                'akun_penarikan' => $request->akun_penarikan,
                'akun_bunga' => $request->akun_bunga,
                'akun_administrasi' => $request->akun_administrasi,
                'akun_pajak' => $request->akun_pajak,
                'kode_awal_rekening' => $request->kode_awal_rekening,
                'jumlah_digit_rekening' => $request->jumlah_digit_rekening,
                'nomor_akhir_rekening' => $request->nomor_akhir_rekening,
                'wajibpokok'  => $request->status
            ]);

            if (count($request['levels']) > 0) {
                for ($i = 0; $i < count($request['levels']); $i++) {
                    $approve = Approverole::create([
                        'id_user' => $request['users'][$i],
                        'id_for' => $pengaturan->id,
                        'for' => "simpanan",
                        'level' => $request['levels'][$i]
                    ]);
                }
            }

            if (count($request['aksess2']) > 0) {
                for ($i = 0; $i < count($request['aksess2']); $i++) {
                    $akses = Aksestutup::create([
                        'id_user' => $request['users2'][$i],
                        'id_for' => $pengaturan->id,
                        'tutup' => "simpanan",
                        'jenis' => $request['aksess2'][$i]
                    ]);
                }
            }

            $msg = "Data Berhasil di Ditambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Pengaturan", $options = []);
        } else {
            if ($request->kode == $valatur->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->jenis_simpanan == $valatur->jenis_simpanan) {
                $dg = "dengan jenis simpanan : ".$request->jenis_simpanan;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Pengaturan", $options = []);
        }
        return redirect(url('simpanan/pengaturan'))
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
        $sistem = Sistembunga::where('untuk', 'simpanan')->get();
//        $shu = Katshudetail::where('id_header', 1)->get();
        $shu = Katshudetail::all();
        $approve = Approverole::where('id_for', $id)->get();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $pengaturan = Pengaturan::findOrNew($id);
        $akses2 = Aksestutup::where('tutup', 'simpanan')->where('id_for', $id)->get();
        return view('simpanan.pengaturan.ubah_pengaturan')->with('pengaturan', $pengaturan)
            ->with('sistem', $sistem)
            ->with('shu', $shu)
            ->with('user', $user)
            ->with('approve', $approve)
            ->with('perkiraan', $perkiraan)
            ->with('akses2', $akses2);
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
        if ($request->autocreate == 1) {
            $auto = $request->autocreate;
        } else {
            $auto = 0;
        }
        $saldominbunga = str_replace(",","",$request->saldo_minimum_bunga);
        $samb = str_replace(".00","",$saldominbunga);

        $saldomin = str_replace(",","",$request->saldo_minimum);
        $sam = str_replace(".00","",$saldomin);

        $saldominpajak = str_replace(",","",$request->saldo_minimum_pajak);
        $samp = str_replace(".00","",$saldominpajak);

        $saldominshu = str_replace(",","",$request->saldo_minimum_shu);
        $sams = str_replace(".00","",$saldominshu);

        $setoranmin = str_replace(",","",$request->setoran_minimum);
        $sem = str_replace(".00","",$setoranmin);

        $administrasi = str_replace(",","",$request->administrasi);
        $adm = str_replace(".00","",$administrasi);

        $valatur = Pengaturan::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('jenis_simpanan', $request->jenis_simpanan)->where('id', '!=', $id)->first();
        if ($valatur == null) {
            $pengaturan = Pengaturan::findOrNew($id);
            $pengaturan->update([
                'kode' => $request->kode,
                'jenis_simpanan' => $request->jenis_simpanan,
                'suku_bunga' => $request->suku_bunga,
                'sistem_bunga' => $request->sistem_bunga,
                'saldo_minimum_bunga' => $samb,
                'saldo_minimum' => $sam,
                'setoran_minimum' => $sem,
                'saldo_minimum_pajak' => $samp,
                'saldo_minimum_shu' => $sams,
                'autocreate' => $auto,
                'id_shu'       => $request->shu,
                'administrasi' => $adm,
                'persen_pajak' => $request->persen_pajak,
                'akun_kas_bank' => $request->akun_kas_bank,
                'akun_setoran' => $request->akun_setoran,
                'akun_penarikan' => $request->akun_penarikan,
                'akun_bunga' => $request->akun_bunga,
                'akun_administrasi' => $request->akun_administrasi,
                'akun_pajak' => $request->akun_pajak,
                'kode_awal_rekening' => $request->kode_awal_rekening,
                'jumlah_digit_rekening' => $request->jumlah_digit_rekening,
                'nomor_akhir_rekening' => $request->nomor_akhir_rekening,
                'wajibpokok'  => $request->status
            ]);
            if (count($request['levels']) > 0) {
                for ($i = 0; $i < count($request['levels']); $i++) {
                    $app = Approverole::where('for', 'simpanan')->where('id_for', $id)->where('id_user', $request['users'][$i])->where('level', $request['levels'][$i])->first();
                    if ($app == null) {
                        $data = [
                            'id_user' => $request['users'][$i],
                            'id_for' => $pengaturan->id,
                            'for' => "simpanan",
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

            if (count($request['aksess2']) > 0) {
                for ($i = 0; $i < count($request['aksess2']); $i++) {
                    $app = Aksestutup::where('tutup', 'simpanan')->where('id_for', $id)->where('id_user', $request['users2'][$i])->where('jenis', $request['aksess2'][$i])->first();
                    if ($app == null) {
                        $data = [
                            'id_user' => $request['users2'][$i],
                            'id_for' => $pengaturan->id,
                            'tutup' => "simpanan",
                            'jenis' => $request['aksess2'][$i]
                        ];
                        if (count($request['aksess2']) > count($request['ida2'])) {
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
            } else if($request->jenis_simpanan == $valatur->jenis_simpanan) {
                $dg = "dengan jenis simpanan : ".$request->jenis_simpanan;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Pengaturan", $options = []);
        }
//        return redirect(url('simpanan/pengaturan'))
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
        $app = Approverole::where('for', 'simpanan')->where('id_for', $id)->get();
        foreach ($app as $get) {
            Approverole::destroy($get->id);
        }
        
        $app2 = Aksestutup::where('tutup', 'simpanan')->where('id_for', $id)->get();
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

        $last_data = Simpanan::where('jenis_simpanan', $id)->orderBy('id', 'DESC')->first();
        $last_digit = 0;
        $last_length = 0;
        $l = 1;

        if(count($last_data) > 0){
            $nomor_simpanan = explode('.', $last_data->nomor_simpanan);
            $last_digit = (int) $nomor_simpanan[1];
            $last_length = strlen($last_digit);
            $l = 0;
        }

        $digit = "";
        for ($i=$l; $i < $gen->jumlah_digit_rekening - $last_length; $i++) {
            $digit .= '0';
        }
        $digit .= intval($last_digit) + 1;
        $nomor = $gen->kode_awal_rekening .'.'. $digit;
        echo '<input name="nomor_simpanan" type="text" class="form-control disabled" placeholder="Nomor Simpanan" readonly value="'.$nomor.'">';
        echo '<span class="input-group-addon"><i class="ti-lock"></i></span>';

    }

    public function sukubunga($id) {
        $sb = Pengaturan::findOrNew($id);
        echo '<input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" value="'.$sb->suku_bunga.'" placeholder="Suku Bunga" readonly>';
        echo '<span class="input-group-addon">% PA</span>';
    }

    public function sistembunga($id) {
        $sb = Pengaturan::findOrNew($id);
        echo '<input name="sistem_bunga" id="sistem_bunga" value="'.$sb->sbunga->sistem.'" type="text" class="form-control disabled" placeholder="Sistem Bunga" readonly>';
    }

}
