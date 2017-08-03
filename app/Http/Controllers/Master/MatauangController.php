<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Matauang;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class MatauangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matauang = DB::table('matauang')->orderBy('id','asc')->paginate(20);
        $jml = Matauang::count();
        return view('master.matauang.daftar_matauang')->with('matauang', $matauang)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $matauang = DB::table('matauang')->where('kode','like','%'.$query.'%')->orWhere('nama','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('matauang')->where('kode','like','%'.$query.'%')->orWhere('nama','like','%'.$query.'%')->count();
      return view('master.matauang.cari_matauang')->with('matauang', $matauang)->with('query', $query)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.matauang.tambah_matauang');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $valmu = Matauang::where('kode', $request->kode)->orWhere('nama', $request->nama)->first();
        if ($valmu == null) {
            if ($request->def == 1) {
                $def = $request->def;
                $valdef = Matauang::where('def', 1)->get();
                foreach ($valdef as $get) {
                    $up = Matauang::find($get->id);
                    $up->update(['def' => 0]);
                }
            } else {
                $def = 0;
            }
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Mata Uang", $options = []);
            Matauang::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'def'  => $def
            ]);   
        } else {
            if ($request->kode == $valmu->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valmu->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Mata Uang", $options = []);
        }
        return redirect(url('master/matauang'))
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
        $matauang = Matauang::findOrNew($id);
        return view('master.matauang.ubah_matauang')->with('matauang', $matauang);
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
        $valmu = Matauang::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama', $request->nama)->where('id', '!=', $id)->first();
        if ($valmu == null) {
            if ($request->def == 1) {
                $def = $request->def;
                $valdef = Matauang::where('def', 1)->get();
                foreach ($valdef as $get) {
                    $up = Matauang::find($get->id);
                    $up->update(['def' => 0]);
                }
            } else {
                $def = 0;
            }
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Mata Uang", $options = []);
            $matauang = Matauang::findOrNew($id);
            $matauang->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'def'  => $def
            ]);
        } else {
            if ($request->kode == $valmu->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valmu->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Mata Uang", $options = []);
        }
//        return redirect(url('master/matauang'))
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
        $alert = Toastr::success($msg, $title = "Hapus Mata Uang", $options = []);
        Matauang::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.matauang.import_matauang');
    }

    public function export()
    {
        Excel::create("export_matauang", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $matauang = Matauang::all();
                foreach($matauang as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_MATA_UANG'));

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
                $sheet->setWidth('B', '25');
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
            foreach ($result as $key => $value) {
                if ($value->kode != "") {
                    $z+=1;
//                    $valmu = Matauang::where('kode', $value->kode)->orWhere('nama', $value->nama_mata_uang)->first();
                    $valmu = Matauang::where('kode', $value->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valmu != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama_mata_uang);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valmu == null) {
                            $no++;
                            Matauang::create([
                                'kode' => $value->kode,
                                'nama' => $value->nama_mata_uang
                            ]);
                        }
                    } else {
                        $no++;
                        $datanya = ['kode' => $value->kode, 'nama' => $value->nama_mata_uang];
                        if ($valmu == null) {
                            Matauang::create($datanya);
                        } else {
                            $matauang = Matauang::find($valmu->id);
                            $matauang->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Mata Uang", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Mata Uang", $options = []);
        }
        unlink('foto/'.$filename);

        return redirect(url('master/matauang/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_matauang_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('USD', 'Dollar'),
                    array('IDR', 'Rupiah')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_MATA_UANG'));

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
                $sheet->setWidth('B', '25');
            });
            return redirect(url('master/matauang/import'));
        })->download('xls');
    }
}
