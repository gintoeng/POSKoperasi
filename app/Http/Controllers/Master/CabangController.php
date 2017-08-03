<?php

namespace App\Http\Controllers\Master;

use App\Approverole;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Cabang;
use App\Model\Master\Katshudetail;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = DB::table('cabang')->orderBy('id','asc')->paginate(20);
        $jml = Cabang::count();
        return view('master.cabang.daftar_cabang')->with('cabang', $cabang)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $cabang = DB::table('cabang')->where('kode','like','%'.$query.'%')->orWhere('nama','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('cabang')->where('kode','like','%'.$query.'%')->orWhere('nama','like','%'.$query.'%')->count();
      return view('master.cabang.cari_cabang')->with('cabang', $cabang)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shu = Katshudetail::where('id_header', 3)->get();
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        return view('master.cabang.tambah_cabang')->with('perkiraan', $perkiraan)->with('user', $user)->with('shu', $shu);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valcab = Cabang::where('kode', $request->kode)->orWhere('nama', $request->nama)->orWhere('nomor_rekening', $request->nomor_rekening)->first();
        if ($valcab == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Cabang", $options = []);
            $cabang = Cabang::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'pesawat' => $request->pesawat,
                'fax' => $request->fax,
//                'id_shu' => $request->shu,
                'nomor_rekening' => $request->nomor_rekening,
                'akun_kas' => $request->akun_kas,
                'akun_cabang' => $request->akun_cabang,
                'akun_persediaan_wsd'   => $request->akun_persediaan,
                'akun_piutang_wsd'      => $request->akun_piutang,
                'akun_penjualan_wsd'    => $request->akun_penjualan,
                'akun_pendapatan_wsd'   => $request->akun_pendapatan,
                'akun_penampungan_retur'=> $request->akun_penampungan,
                'akun_biaya_selisih_opname' => $request->akun_biaya_opname
            ]);

            if (count($request['levels']) > 0) {
                for ($i = 0; $i < count($request['levels']); $i++) {
                    $approve = Approverole::create([
                        'id_user' => $request['users'][$i],
                        'id_for' => $cabang->id,
                        'for' => "waserda",
                        'level' => $request['levels'][$i]
                    ]);
                }
            }
        } else {
            if ($request->kode == $valcab->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valcab->nama) {
                $dg = "dengan nama : ".$request->nama;
            } else if($request->nomor_rekening == $valcab->nomor_rekening) {
                $dg = "dengan nomor rekening : ".$request->nomor_rekening;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Cabang", $options = []);
        }
        return redirect(url('master/cabang'))
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
        $shu = Katshudetail::all();
//        $shu = Katshudetail::where('id_header', 3)->get();
        $cabang = Cabang::findOrNew($id);
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        $user = User::whereHas('roleid',function($query) {
            $query->where('akses', 'koperasi');
        })->get();
        $approve = Approverole::where('id_for', $id)->get();
        return view('master.cabang.ubah_cabang')->with('cabang', $cabang)->with('perkiraan', $perkiraan)->with('user', $user)->with('approve', $approve)->with('shu', $shu);
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
        $valcab = Cabang::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama', $request->nama)->where('id', '!=', $id)->orWhere('nomor_rekening', $request->nomor_rekening)->where('id', '!=', $id)->first();
        if ($valcab == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Cabang", $options = []);
            $cabang = Cabang::findOrNew($id);
            $cabang->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'telepon' => $request->telepon,
                'pesawat' => $request->pesawat,
                'fax' => $request->fax,
//                'id_shu' => $request->shu,
                'nomor_rekening' => $request->nomor_rekening,
                'akun_kas' => $request->akun_kas,
                'akun_cabang' => $request->akun_cabang,
                'akun_persediaan_wsd'   => $request->akun_persediaan,
                'akun_piutang_wsd'      => $request->akun_piutang,
                'akun_penjualan_wsd'    => $request->akun_penjualan,
                'akun_pendapatan_wsd'   => $request->akun_pendapatan,
                'akun_penampungan_retur'=> $request->akun_penampungan,
                'akun_biaya_selisih_opname' => $request->akun_biaya_opname
            ]);

            if (count($request['levels']) > 0) {
                for ($i = 0; $i < count($request['levels']); $i++) {
                    $app = Approverole::where('for', 'waserda')->where('id_for', $cabang->id)->where('id_user', $request['users'][$i])->where('level', $request['levels'][$i])->first();
                    if ($app == null) {
                        $data = [
                            'id_user' => $request['users'][$i],
                            'id_for' => $cabang->id,
                            'for' => "waserda",
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

        } else {
            if ($request->kode == $valcab->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valcab->nama) {
                $dg = "dengan nama : ".$request->nama;
            } else if($request->nomor_rekening == $valcab->nomor_rekening) {
                $dg = "dengan nomor_rekening : ".$request->nomor_rekening;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Cabang", $options = []);
        }
//        return redirect(url('master/cabang'))
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
        $alert = Toastr::success($msg, $title = "Hapus Cabang", $options = []);
        $beli = pembelianSupplierHeader::where('id_cabang', $id)->get();
        foreach ($beli as $item) {
            $detail = pembelianSupplierDetail::where('id_header', $item->id)->get();
            foreach ($detail as $get) {
                pembelianSupplierDetail::destroy($get->id);
            }
            pembelianSupplierHeader::destroy($item->id);
        }
        Cabang::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.cabang.import_cabang');
    }

    public function export()
    {
        Excel::create("export_cabang", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $cabang = Cabang::all();
                foreach($cabang as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama,
                        $item->alamat,
                        $item->kota,
                        $item->provinsi,
                        $item->kode_pos,
                        $item->telepon,
                        $item->fax
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_CABANG', 'ALAMAT', 'KOTA', 'PROVINSI', 'KODE_POS', 'TELP', 'FAX'));

                $sheet->setBorder('A1:B1', 'thin');
                $sheet->cells('A1:B1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setWidth('A', '10');
                $sheet->setWidth('B', '40');
                $sheet->setWidth('C', '50');
                $sheet->setWidth('D', '20');
                $sheet->setWidth('B', '15');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '15');
                $sheet->setWidth('H', '15');
            });
            return redirect(url()->previous());
        })->download('xls');
    }

    public function postimport(Request $request)
    {
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->first();
        if ($perkiraan == null) {
            $msg = "ERROR! <br> Import Data Gagal. Akun Perkiraan Kosong";
            $alert = Toastr::error($msg, $title = "Import Cabang", $options = []);
        } else {
            $shu = Katshudetail::where('id_header', 3)->first();
            $no = 0;
            if ($request->hasFile('import')) {
                $file = $request->import;
                $filename = $file->getClientOriginalName();

                $destinationPath = 'foto/';
                $file->move($destinationPath, $filename);

            }

            $xls = explode(".", $filename);

            if ($xls[1] == "xls" || $xls[1] == "csv") {
                $z = 0;
                $w = 0;
                $result = Excel::load('public/foto/' . $filename)->get();
                foreach ($result as $value) {
                    if ($value->kode != "") {
                        $z += 1;
//                    $valcab = Cabang::where('kode', $request->kode)->orWhere('nama', $request->nama)->first();
                        $valcab = Cabang::where('kode', $request->kode)->first();
                        if ($request->konf == "cekdata") {
                            if ($valcab != null) {
                                $data[] = array('kd' => $value->kode, 'nm' => $value->nama);
                            } else {
                                $w += 1;
                            }
                        } else if ($request->konf == "skip") {
                            if ($valcab == null) {
                                $no++;
                                Cabang::create([
                                    'kode' => $value->kode,
                                    'nama' => $value->nama_cabang,
                                    'alamat' => $value->alamat,
                                    'kota' => $value->kota,
                                    'provinsi' => $value->provinsi,
                                    'kode_pos' => $value->kode_pos,
                                    'telepon' => $value->telp,
                                    'fax' => $value->fax,
                                    'id_shu' => $shu->id,
                                    'akun_kas' => $perkiraan->id,
                                    'akun_cabang' => $perkiraan->id,
                                    'akun_persediaan_wsd' => $perkiraan->id,
                                    'akun_piutang_wsd' => $perkiraan->id,
                                    'akun_penjualan_wsd' => $perkiraan->id,
                                    'akun_pendapatan_wsd' => $perkiraan->id,
                                    'akun_penampungan_retur' => $perkiraan->id,
                                    'akun_biaya_selisih_opname' => $perkiraan->id
                                ]);
                            }
                        } else {
                            $no++;
                            $datanya = [
                                'kode' => $value->kode,
                                'nama' => $value->nama_cabang,
                                'alamat' => $value->alamat,
                                'kota' => $value->kota,
                                'provinsi' => $value->provinsi,
                                'kode_pos' => $value->kode_pos,
                                'telepon' => $value->telp,
                                'fax' => $value->fax,
                                'id_shu' => $shu->id,
                                'akun_kas' => $perkiraan->id,
                                'akun_cabang' => $perkiraan->id,
                                'akun_persediaan_wsd' => $perkiraan->id,
                                'akun_piutang_wsd' => $perkiraan->id,
                                'akun_penjualan_wsd' => $perkiraan->id,
                                'akun_pendapatan_wsd' => $perkiraan->id,
                                'akun_penampungan_retur' => $perkiraan->id,
                                'akun_biaya_selisih_opname' => $perkiraan->id
                            ];
                            if ($valcab == null) {
                                Cabang::create($datanya);
                            } else {
                                $cabang = Cabang::find($valcab->id);
                                $cabang->update($datanya);
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
                            $msg = $item["kd"] . " - " . $item["nm"] . "<br>";
                            $alert = Toastr::warning($msg, $title = null, $options = []);
                        }
                    }
                } else {
                    $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : " . $no;
                    $alert = Toastr::success($msg, $title = "Import Cabang", $options = []);
                }
            } else {
                $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
                $alert = Toastr::error($msg, $title = "Import Cabang", $options = []);
            }
            unlink('foto/' . $filename);
        }
        return redirect(url('master/cabang/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_cabang_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('JKT', 'Permata Jakarta', 'Jl.Permata 5', 'Jakarta Timur', 'Jakarta', '12803', '0213837837', '0213747'),
                    array('BDG', 'Permata Bandung', 'Jl.Mulia', 'Banjar', 'Jawa Barat', '11730', '0217773833', '02176367464')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_CABANG', 'ALAMAT', 'KOTA', 'PROVINSI', 'KODE_POS', 'TELP', 'FAX'));

                $sheet->setBorder('A1:H1', 'thin');
                $sheet->cells('A1:H1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setWidth('A', '10');
                $sheet->setWidth('B', '40');
                $sheet->setWidth('C', '50');
                $sheet->setWidth('D', '20');
                $sheet->setWidth('B', '15');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '15');
                $sheet->setWidth('H', '15');
            });
            return redirect(url('master/cabang/import'));
        })->download('xls');
    }
}
