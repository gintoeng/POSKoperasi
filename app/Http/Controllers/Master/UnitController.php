<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Unit;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = DB::table('unit')->orderBy('id','asc')->paginate(20);
        $jml = Unit::count();
        return view('master.unit.daftar_unit')->with('unit', $unit)->with('jml', $jml);
    }

    public function search(Request $r)
    {
        $query = $r->input('query');
        $unit = DB::table('unit')->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('unit')->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->count();
        return view('master.unit.cari_unit')->with('unit', $unit)->with('query', $query)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.unit.tambah_unit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valunit = Unit::where('kode', $request->kode)->orWhere('nama', $request->nama)->first();
        if ($valunit == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Unit", $options = []);
            Unit::create([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
        } else {
            if ($request->kode == $valunit->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valunit->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Unit", $options = []);
        }
        return redirect(url('master/unit'))
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
        $unit = Unit::findOrNew($id);
        return view('master.unit.ubah_unit')->with('unit', $unit);
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
        $valunit = Unit::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama', $request->nama)->where('id', '!=', $id)->first();
        if ($valunit == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Unit", $options = []);
            $unit = Unit::findOrNew($id);
            $unit->update([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
        } else {
            if ($request->kode == $valunit->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valunit->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Unit", $options = []);
        }

//        return redirect(url('master/unit'))
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
        $alert = Toastr::success($msg, $title = "Hapus Unit", $options = []);
        Unit::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.unit.import_unit');
    }

    public function export()
    {
        Excel::create("export_unit", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $unit = Unit::all();
                foreach($unit as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_UNIT'));

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
//            return redirect(url()->previous());
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
//                    $valunit = Unit::where('kode', $value->kode)->orWhere('nama', $value->nama_unit)->first();
                    $valunit = Unit::where('kode', $value->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valunit != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama_unit);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valunit == null) {
                            $no++;
                            Unit::create([
                                'kode' => $value->kode,
                                'nama' => $value->nama_unit
                            ]);
                        }
                    } else {
                        $no++;
                        $datanya = ['kode' => $value->kode, 'nama' => $value->nama_unit];
                        if ($valunit == null) {
                            Unit::create($datanya);
                        } else {
                            $unit = Unit::find($valunit->id);
                            $unit->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Unit", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Unit", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/unit/import'))
            ->with('alert', $alert);

    }

    public function sampleimport()
    {
        Excel::create("import_unit_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('PCS', 'Piece'),
                    array('PCK', 'Package')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_UNIT'));

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
                $sheet->setWidth('B', '20');
            });
            return redirect(url('master/unit/import'));
        })->download('xls');
    }
}
