<?php

namespace App\Http\Controllers\Master;

use App\Aksestutup;
use App\Attach;
use App\Model\Master\Anggota;
use App\Model\Master\Bank; 
use App\Model\Master\Cabang;
use App\Model\Master\Koderecab;
use App\Model\Pengaturan\Nomor;
use App\Model\Pinjaman\Pembayaran;
use App\Model\Pos\Transaksiheader;
use App\Model\Simpanan\Akumulasi;
use App\Model\Simpanan\Pengaturan;
use App\Model\Simpanan\Simpanan;
use App\Model\Simpanan\Transaksi;
use App\User;
use Illuminate\Http\Request;

use File;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggota = DB::table('anggota')->orderBy('id','asc')->paginate(20);
        $jml = Anggota::count();
        return view('master.customer.daftar_anggota')->with('anggota', $anggota)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $anggota = DB::table('anggota')->where('kode','like','%'.$query.'%')->orWhere('nama','like','%'.$query.'%')->orWhere('jenis_nasabah','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('anggota')->where('kode','like','%'.$query.'%')->orWhere('nama','like','%'.$query.'%')->orWhere('jenis_nasabah','like','%'.$query.'%')->orWhere('npk','like','%'.$query.'%')->count();
      return view('master.customer.cari_anggota')->with('anggota', $anggota)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            date_default_timezone_set('Asia/Jakarta');
            $today = date('m/d/Y');
            $kode = $this->_generate();
            $bank = Bank::all();
            $recab = Koderecab::all();
            return view('master.customer.tambah_anggota')->with('today', $today)
                ->with('kode', $kode)
                ->with('bank', $bank)
                ->with('recab', $recab);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hlimit = str_replace(",","",$request->limit_transaksi);
        $hl = str_replace(".00","",$hlimit);

        if ($request->tanggal_lahir == "") {
            $lahir = "00/00/0000";
        } else {
            $lahir = $request->tanggal_lahir;
        }

        if ($request->tanggal_registrasi == "") {
            $registrasi = "00/00/0000";
        } else {
            $registrasi = $request->tanggal_registrasi;
        }
        $tanggal_lahir = explode('/', $lahir);
        $tanggal_registrasi = explode('/', $registrasi);

        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/anggota/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "";
        }

        if ($request->jenis_customer != "UMUM") {
            $bid = null;
            $valcs = Anggota::where('kode', $request->kode)->orWhere('npk', $request->npk)->orWhere('nomor_rekening', $request->nomor_rekening)->first();
        } else {
            $bid = $request->bank;
            $valcs = Anggota::where('kode', $request->kode)->orWhere('nomor_rekening', $request->nomor_rekening)->first();
        }

        if ($valcs == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Customer", $options = []);
            $customer = Anggota::create([
                'id_bank' => $bid,
                'nama_akun' => $request->nama_akun,
                'nomor_akun' => $request->nomor_akun,
                'cabang' => $request->cabang,
                'kode' => $request->kode,
                'jenis_nasabah' => $request->jenis_customer,
                'nomor_rekening' => $request->nomor_rekening,
                'kode_rekening' => $request->kode_rekening,
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'nomor_ktp' => $request->nomor_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir[2] . '-' . $tanggal_lahir[0] . '-' . $tanggal_lahir[1],
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_registrasi' => $tanggal_registrasi[2] . '-' . $tanggal_registrasi[0] . '-' . $tanggal_registrasi[1],
                'npk' => $request->npk,
                'departemen' => $request->departemen,
                'jabatan' => $request->jabatan,
                'nama_saudara' => $request->nama_saudara,
                'alamat_saudara' => $request->alamat_saudara,
                'telepon_saudara' => $request->telepon_saudara,
                'hubungan' => $request->hubungan,
                'foto' => $filename,
                'pin' => $request->pin,
                'limit_transaksi' => $hl,
                'status' => $request->status,
                'account_card' => $request->nomor_kartu,
                'keterangan' => $request->keterangan
            ]);
            $atur = Pengaturan::where('autocreate', 1)->get();
            foreach($atur as $key => $item) {
                $no = $key + 1;
                $ket = "Simpanan Awal ".$no;
                $pengaturan = Pengaturan::find($item->id);
                $simp = Simpanan::create([
                    'jenis_simpanan' => $item->id,
                    'nomor_simpanan' => $this->_generatesimp($item->id),
                    'anggota' => $customer->id,
                    'suku_bunga' => $pengaturan->suku_bunga,
                    'setoran_bulanan' => $pengaturan->setoran_minimum,
                    'status' => 0,
                    'tanggal_pembuatan' => $tanggal_registrasi[2] . '-' . $tanggal_registrasi[0] . '-' . $tanggal_registrasi[1],
                    'keterangan'    => $ket

                ]);
                $akumulasi1 = Akumulasi::create([
                    'id_simpanan' => $simp->id,
                    'saldo' => '0'
                ]);
            }

            $nom = Nomor::where('modul', 'Master Customer')->first();
            $format = Nomor::find($nom->id);
            $format->update(['nomor_now' => $nom->nomor_now + 1]);
        } else {
            if ($request->jenis_customer != "UMUM") {
                if ($request->kode == $valcs->kode) {
                    $dg = "dengan kode : ".$request->kode;
                } else if($request->npk == $valcs->npk) {
                    $dg = "dengan npk : ".$request->npk;
                } else if($request->nomor_rekening == $valcs->nomor_rekening) {
                    $dg = "dengan nomor rekening : ".$request->nomor_rekening;
                }
            } else {
                if ($request->kode == $valcs->kode) {
                    $dg = "dengan kode : ".$request->kode;
                } else if($request->nomor_rekening == $valcs->nomor_rekening) {
                    $dg = "dengan nomor rekening : ".$request->nomor_rekening;
                }
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Customer", $options = []);
        }
        return redirect(url('master/customer'))
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
        $anggota = Anggota::find($id);

        $simpanan = Simpanan::where('anggota', $id)->get();
        $pinjaman = Pembayaran::where('start', '0')->whereHas('pinjamanid', function($query) use($id) {
            $query->where('anggota', $id)->where('status_realisasi', 'Y')->where('status_lunas', 'N');
        })->get();

        $waserda = Transaksiheader::where('no_kartu', $anggota->npk)->where('type_pembayaran', 'tunda')->get();

        if ($anggota->jenis_nasabah == "UMUM") {
            $js = "umum";
        } else if ($anggota->jenis_nasabah == "BIASA") {
            $js = "biasa";
        } else {
            $js = "luar biasa";
        }

        return view('master.customer.outstanding')->with('anggota', $anggota)->with('simpanan', $simpanan)->with('pinjaman', $pinjaman)->with('waserda', $waserda)->with('js', $js);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        return back();
//        dd(url()->previous());
        $anggota = Anggota::findOrNew($id);
        $bank = Bank::all();
        $recab = Koderecab::all();
//        $tg = explode('-', $anggota->tanggal_lahir);
//        $tgl = $tg[2]."/".$tg[1]."/".$tg[0];
        if ($anggota->tanggal_lahir == "0000-00-00") {
            $tgl = "";
        } else {
            $tgl = date("m/d/Y", strtotime($anggota->tanggal_lahir));
        }

//        $tg2 = explode('-', $anggota->tanggal_registrasi);
//        $tgl2 = $tg2[2]."/".$tg2[1]."/".$tg2[0];
        if ($anggota->tanggal_registrasi == "0000-00-00") {
            $tgl2 = "";
        } else {
            $tgl2 = date("m/d/Y", strtotime($anggota->tanggal_registrasi));
        }
        return view('master.customer.ubah_anggota')->with('anggota', $anggota)->with('bank', $bank)->with('tgl', $tgl)->with('tgl2', $tgl2)->with('recab', $recab);;
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
        $hlimit = str_replace(",","",$request->limit_transaksi);
        $hl = str_replace(".00","",$hlimit);

        if ($request->tanggal_lahir == "") {
            $lahir = "00/00/0000";
        } else {
            $lahir = $request->tanggal_lahir;
        }

        if ($request->tanggal_registrasi == "") {
            $registrasi = "00/00/0000";
        } else {
            $registrasi = $request->tanggal_registrasi;
        }
        $tanggal_lahir = explode('/', $lahir);
        $tanggal_registrasi = explode('/', $registrasi);

        if ($request->hasFile('foto'))
        {
            $anggota = DB::table('anggota')->where('id',$id)->first();
            File::delete('foto/anggota/'.$anggota->foto);
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/anggota/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = $request->gambar;
        }

        if ($request->jenis_customer != "UMUM") {
            $bid = null;
            $valcs = Anggota::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('npk', $request->npk)->where('id', '!=', $id)->orWhere('nomor_rekening', $request->nomor_rekening)->where('id', '!=', $id)->first();
        } else {
            $bid = $request->bank;
            $valcs = Anggota::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nomor_rekening', $request->nomor_rekening)->where('id', '!=', $id)->first();
        }

        if ($valcs == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Customer", $options = []);
            $anggota = Anggota::findOrNew($id);
            $anggota->update([
                'id_bank' => $bid,
                'nama_akun' => $request->nama_akun,
                'nomor_akun' => $request->nomor_akun,
                'cabang' => $request->cabang,
                'kode' => $request->kode,
                'jenis_nasabah' => $request->jenis_customer,
                'nomor_rekening' => $request->nomor_rekening,
                'kode_rekening' => $request->kode_rekening,
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'nomor_ktp' => $request->nomor_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $tanggal_lahir[2] . '-' . $tanggal_lahir[0] . '-' . $tanggal_lahir[1],
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_registrasi' => $tanggal_registrasi[2] . '-' . $tanggal_registrasi[0] . '-' . $tanggal_registrasi[1],
                'npk' => $request->npk,
                'departemen' => $request->departemen,
                'jabatan' => $request->jabatan,
                'nama_saudara' => $request->nama_saudara,
                'alamat_saudara' => $request->alamat_saudara,
                'telepon_saudara' => $request->telepon_saudara,
                'hubungan' => $request->hubungan,
                'foto' => $filename,
                'pin' => $request->pin,
                'limit_transaksi' => $hl,
                'status' => $request->status,
                'account_card' => $request->nomor_kartu,
                'keterangan' => $request->keterangan
            ]);
        } else {
            if ($request->jenis_customer != "UMUM") {
                if ($request->kode == $valcs->kode) {
                    $dg = "dengan kode : ".$request->kode;
                } else if($request->npk == $valcs->npk) {
                    $dg = "dengan npk : ".$request->npk;
                } else if($request->nomor_rekening == $valcs->nomor_rekening) {
                    $dg = "dengan nomor rekening : ".$request->nomor_rekening;
                }
            } else {
                if ($request->kode == $valcs->kode) {
                    $dg = "dengan kode : ".$request->kode;
                } else if($request->nomor_rekening == $valcs->nomor_rekening) {
                    $dg = "dengan nomor rekening : ".$request->nomor_rekening;
                }
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Customer", $options = []);
        }
//        return redirect(url('master/customer'))
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
        $anggota = DB::table('anggota')->where('id',$id)->first();
        if ($anggota->foto != "avatar.jpg" || $anggota->foto != "ava" || $anggota->foto != "") {
            File::delete('foto/anggota/'.$anggota->foto);
        }
        $att = Attach::where('id_anggota', $id)->get();
        foreach ($att as $get) {
            Attach::destroy($get->id);
        }
        $msg = "Data Berhasil di Hapus";
        $alert = Toastr::success($msg, $title = "Hapus Customer", $options = []);
        Anggota::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.customer.import_anggota');
    }

    public function export()
    {
        Excel::create("export_anggota", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $anggota = Anggota::all();
                foreach($anggota as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nomor_ktp,
                        $item->nama,
                        $item->tanggal_lahir,
                        $item->jenis_nasabah,
                        $item->alamat,
                        $item->kota,
                        $item->provinsi,
                        $item->telepon,
                        $item->jenis_kelamin,
                        $item->tanggal_registrasi,
                        $item->recabid->kode,
                        $item->npk,
                        $item->departemen
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE', 'NO_KTP', 'NAMA', 'TGL_LAHIR', 'JENIS_CUSTOMER', 'AlAMAT', 'KOTA', 'PROVINSI', 'TELEPON', 'JENIS_KELAMIN', 'TANGGAL_REGISTRASI', 'KD_CABANG_REK', 'NPK', 'DEPT'));

                $sheet->setBorder('A1:N1', 'thin');
                $sheet->cells('A1:N1', function($cells){
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
                $sheet->setWidth('D', '10');
                $sheet->setWidth('E', '10');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '10');
                $sheet->setWidth('H', '10');
                $sheet->setWidth('I', '20');
                $sheet->setWidth('J', '20');
                $sheet->setWidth('K', '20');
                $sheet->setWidth('L', '20');
                $sheet->setWidth('M', '20');
                $sheet->setWidth('N', '20');
            });
            return redirect(url()->previous());
        })->download('xls');
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
                if ($value->kode != "") {
                    $z+=1;
                    $valcs = Anggota::where('kode', $request->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valcs != null) {
                            $data[] = array('kd' => $value->kode);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valcs == null) {
                            $recab = Koderecab::where('kode', $value->kd_cabang_rek)->first();
                            if ($recab != null) {
                                $no++;
                                $your_date = date("Y-m-d", strtotime($value->tanggal_registrasi));
                                $customer = Anggota::create([
                                    //'kode' => $this->_generate(),
                                    'kode' => $value->kode,
                                    'jenis_nasabah' => $value->jenis_customer,
                                    'npk' => $value->npk,
                                    'nomor_ktp' => $value->no_ktp,
                                    'nama' => $value->nama,
                                    'alamat' => $value->alamat,
                                    'kota' => $value->kota,
                                    'provinsi' => $value->provinsi,
                                    'telepon' => $value->telepon,
                                    'jenis_kelamin' => $value->jenis_kelamin,
                                    'tanggal_registrasi' => $your_date,
                                    'kode_rekening' => $recab->id
                                ]);

                                $atur = Pengaturan::where('autocreate', 1)->get();
                                foreach($atur as $key => $item) {
                                    $no = $key + 1;
                                    $ket = "Simpanan Awal ".$no;
                                    $pengaturan = Pengaturan::find($item->id);
                                    $simp = Simpanan::create([
                                        'jenis_simpanan' => $item->id,
                                        'nomor_simpanan' => $this->_generatesimp($item->id),
                                        'anggota' => $customer->id,
                                        'suku_bunga' => $pengaturan->suku_bunga,
                                        'setoran_bulanan' => $pengaturan->setoran_minimum,
                                        'status' => 0,
                                        'tanggal_pembuatan' => $your_date,
                                        'keterangan'    => $ket

                                    ]);
                                    $akumulasi1 = Akumulasi::create([
                                        'id_simpanan' => $simp->id,
                                        'saldo' => '0'
                                    ]);
                                }
                            }
                        }
                    } else {
                        if ($value->kd_cabang_rek != "") {
                            $recab = Koderecab::where('kode', $value->kd_cabang_rek)->first();
                            if ($recab == null) {
                                $recab = Koderecab::create(['kode' => $value->kd_cabang_rek, 'nama' => $value->kd_cabang_rek]);
                            }
                            $your_date = date("Y-m-d", strtotime($value->tanggal_registrasi));
                            $no++;
                            $datanya = [
                                'kode' => $value->kode,
                                'jenis_nasabah' => $value->jenis_customer,
                                'npk' => $value->npk,
                                'nomor_ktp' => $value->no_ktp,
                                'nama' => $value->nama,
                                'alamat' => $value->alamat,
                                'kota' => $value->kota,
                                'provinsi' => $value->provinsi,
                                'telepon' => $value->telepon,
                                'jenis_kelamin' => $value->jenis_kelamin,
                                'tanggal_registrasi' => $your_date,
                                'kode_rekening' => $recab->id
                            ];
                            if ($valcs == null) {
                                $customer = Anggota::create($datanya);

                                $atur = Pengaturan::where('autocreate', 1)->get();
                                foreach ($atur as $key => $item) {
                                    $no = $key + 1;
                                    $ket = "Simpanan Awal " . $no;
                                    $pengaturan = Pengaturan::find($item->id);
                                    $simp = Simpanan::create([
                                        'jenis_simpanan' => 1,
                                        'nomor_simpanan' => $this->_generatesimp($item->id),
                                        'anggota' => $customer->id,
                                        'suku_bunga' => $pengaturan->suku_bunga,
                                        'setoran_bulanan' => $pengaturan->setoran_minimum,
                                        'status' => 0,
                                        'tanggal_pembuatan' => $your_date,
                                        'keterangan' => $ket

                                    ]);
                                    $akumulasi1 = Akumulasi::create([
                                        'id_simpanan' => $simp->id,
                                        'saldo' => '0'
                                    ]);
                                }
                            } else {
                                $anggota = Anggota::find($valcs->id);
                                $anggota->update($datanya);
                            }
                        }
                    }
                }
            }
//            $result = Excel::filter('chunk')->load('public/foto/'.$filename)->chunk('200', function($results){
//                foreach ($results as $value) {
//                    if ($value->kode != "") {
//                    Anggota::create([
//                        //'kode' => $this->_generate(),
//                        'kode' => $value->kode,
//                        'jenis_nasabah' => $value->jenis_customer,
//                        'nik' => $value->nik,
//                        'nama' => $value->nama,
//                        'alamat' => $value->alamat,
//                        'kota' => $value->kota,
//                        'provinsi' => $value->provinsi,
//                        'telepon' => $value->telepon,
//                        'jenis_kelamin' => $value->jenis_kelamin,
//                        'tanggal_registrasi' => $value->tanggal_registrasi,
//                        'id_cabang' => $value->id_cabang
//                    ]);
//                    }
//                }
//            });
            if ($request->konf == "cekdata") {
                if ($w == $z) {
                    $msg = "Tidak ada data yang sama.";
                    $alert = Toastr::success($msg, $title = null, $options = []);
                } else {
                    foreach ($data as $item) {
                        $msg = $item["kd"] . "<br>";
                        $alert = Toastr::warning($msg, $title = null, $options = []);
                    }
                }
            } else {
                $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : " . $no;
                $alert = Toastr::success($msg, $title = "Import Customer", $options = []);
            }
        } else {
            $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Customer", $options = []);
        }
        unlink('foto/'.$filename);
        $this->__endloading();
        return redirect(url('master/customer/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_anggota_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('00011/KKBP', '128474443', 'Codi', '1997-04-23', 'BIASA', 'Depok', 'Depok', 'DKI Jakarta', '12870', '0884476333', 'L', '2014-12-03', '007', '1234567', 'CIA'),
                    array('00022/KKBP', '112738744', 'Doni', '1997-08-10','BIASA', 'Bogor', 'Bogor', 'DKI Jakarta', '16505','0826376344', 'L', '2013-07-17', '007', '1234567', 'IT')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE', 'NO_KTP', 'NAMA', 'TGL_LAHIR', 'JENIS_CUSTOMER', 'AlAMAT', 'KOTA', 'PROVINSI', 'KODE_POS', 'TELEPON', 'JENIS_KELAMIN', 'TANGGAL_REGISTRASI', 'KD_CABANG_REK', 'NPK', 'DEPT'));

                $sheet->setBorder('A1:O1', 'thin');
                $sheet->cells('A1:O1', function($cells){
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
                $sheet->setWidth('D', '10');
                $sheet->setWidth('E', '10');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '10');
                $sheet->setWidth('H', '10');
                $sheet->setWidth('I', '20');
                $sheet->setWidth('J', '20');
                $sheet->setWidth('K', '20');
                $sheet->setWidth('L', '20');
                $sheet->setWidth('M', '20');
                $sheet->setWidth('N', '20');
                $sheet->setWidth('O', '20');
            });
            return redirect(url('master/customer/import'));
        })->download('xls');
    }

    public function _generate() {
        $nom = Nomor::where('modul', 'Master Customer')->first();

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

    public function cekaturan() {
        $nom = Nomor::where('modul', 'Master Customer')->first();

        if($nom == null){
            $stat = "FAIL";
            $title = "Format Nomor Customer";
            $psg = "Format nomor untuk Customer belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
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

    public function cekaturanimport() {
        $nom = Cabang::count();

        if($nom < 1){
            $stat = "FAIL";
            $title = "Cabang";
            $psg = "Data Cabang tidak ditemukan";
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

    public function _generatesimp($id)
    {
        $gen = Pengaturan::findOrNew($id);

        $last_data = Simpanan::where('jenis_simpanan', $id)->orderBy('id', 'DESC')->first();
        $last_digit = 0;
        $last_length = 0;
        $l = 1;

        if (count($last_data) > 0) {
            $nomor_simpanan = explode('.', $last_data->nomor_simpanan);
            $last_digit = (int)$nomor_simpanan[1];
            $last_length = strlen($last_digit);
            $l = 0;
        }

        $digit = "";
        for ($i = $l; $i < $gen->jumlah_digit_rekening - $last_length; $i++) {
            $digit .= '0';
        }
        $digit .= intval($last_digit) + 1;
        $nomor = $gen->kode_awal_rekening . '.' . $digit;

        return $nomor;
    }

    public function recab($id) {
        $recab = Koderecab::find($id);

        $data[] = array(
            'nama' => $recab->nama
        );

        return json_encode($data);
    }

    public function __endloading() {
        echo '<script>EndLoading();</script>';
    }

    public function editstatus($id, $status) {
        $anggota = Anggota::find($id);
        if ($status == "BLOCK" || $status == "NONAKTIF") {
            $pinjaman = Pembayaran::where('start', '0')->whereHas('pinjamanid', function($query) use($id) {
                $query->where('anggota', $id)->where('status_realisasi', 'Y')->where('status_lunas', 'N');
            })->first();

            $waserda = Transaksiheader::where('no_kartu', $anggota->npk)->where('kategori', 'belum dibayar')->first();

            if ($pinjaman == null && $waserda == null) {
                $anggota = Anggota::find($id);
                $anggota->update(['status' => $status]);

                $msg = "Customer berhasil Di".$status."kan";
                $alert = Toastr::success($msg, $title = "Status Customer", $options = []);

                $simpanan = Simpanan::where('anggota', $id)->get();
                foreach ($simpanan as $item) {
                    $simp = Simpanan::find($item->id);
                    $simp->update(['status', 2]);
                }

            } else {
                $msg = "Customer Gagal Di " . $status . "kan.";
                $alert = Toastr::error($msg, $title = "Status Customer", $options = []);
            }
        } else {
            $anggota = Anggota::find($id);
            $anggota->update(['status' => $status]);

            $msg = "Customer berhasil Di AKTIFkan";
            $alert = Toastr::success($msg, $title = "Status Customer", $options = []);

            $simpanan = Simpanan::where('anggota', $id)->get();
            foreach ($simpanan as $item) {
                $simp = Simpanan::find($item->id);
                $simp->update(['status', 0]);
            }
        }

        return redirect(url()->previous())->with('alert', $alert);
    }

    public function aksesttp() {
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        $akses = Aksestutup::where('tutup', 'anggota')->where('tipecs', 'umum')->get();
        $akses2 = Aksestutup::where('tutup', 'anggota')->where('tipecs', 'biasa')->get();
        $akses3 = Aksestutup::where('tutup', 'anggota')->where('tipecs', 'luar biasa')->get();
        return view('pengaturan.customer.aksesttp')->with('user', $user)->with('akses', $akses)->with('akses2', $akses2)->with('akses3', $akses3);
    }

    public function postaksesttp(Request $request) {

        if (count($request['aksess']) > 0) {
            for ($i = 0; $i < count($request['aksess']); $i++) {
                $app = Aksestutup::where('tutup', 'anggota')->where('tipecs', 'umum')->where('id_user', $request['users'][$i])->where('jenis', $request['aksess'][$i])->first();
                if ($app == null) {
                    $data = [
                        'id_user' => $request['users'][$i],
                        'id_for' => 1,
                        'tutup' => "anggota",
                        'jenis' => $request['aksess'][$i],
                        'tipecs' => "umum"
                    ];
                    if (count($request['aksess']) > count($request['ida'])) {
                        $akses = Aksestutup::create($data);
                    } else {
                        $app2 = Aksestutup::find($request['ida'][$i]);
                        $app2->update($data);
                    }

                }
            }
        }

        if (count($request['aksess2']) > 0) {
            for ($i = 0; $i < count($request['aksess2']); $i++) {
                $app = Aksestutup::where('tutup', 'anggota')->where('tipecs', 'biasa')->where('id_user', $request['users2'][$i])->where('jenis', $request['aksess2'][$i])->first();
                if ($app == null) {
                    $data = [
                        'id_user' => $request['users2'][$i],
                        'id_for' => 2,
                        'tutup' => "anggota",
                        'jenis' => $request['aksess2'][$i],
                        'tipecs' => "biasa"
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

        if (count($request['aksess3']) > 0) {
            for ($i = 0; $i < count($request['aksess3']); $i++) {
                $app = Aksestutup::where('tutup', 'anggota')->where('tipecs', 'luar biasa')->where('id_user', $request['users3'][$i])->where('jenis', $request['aksess3'][$i])->first();
                if ($app == null) {
                    $data = [
                        'id_user' => $request['users3'][$i],
                        'id_for' => 2,
                        'tutup' => "anggota",
                        'jenis' => $request['aksess3'][$i],
                        'tipecs' => "luar biasa"
                    ];
                    if (count($request['aksess3']) > count($request['ida3'])) {
                        $akses = Aksestutup::create($data);
                    } else {
                        $app2 = Aksestutup::find($request['ida3'][$i]);
                        $app2->update($data);
                    }

                }
            }
        }
        $msg = "Data Berhasil di Ubah";
        $alert = Toastr::success($msg, $title = "Akses Status Customer", $options = []);
        return redirect(url('pengaturan/customer/aksesttp'))->with('alert', $alert);
    }

    public function destroyakses($id)
    {
        Aksestutup::destroy($id);
        $data[] = array('stat' => "OK");
        return json_encode($data);
    }

    public function tutupanggota($id, $status) {
        $anggota = Anggota::find($id);

        $msg = "Customer Berhasil Di Tutup";
        $alert = Toastr::success($msg, $title = "Tutup Customer", $options = []);

        return redirect(url()->previous())->with('alert', $alert);
    }
}
