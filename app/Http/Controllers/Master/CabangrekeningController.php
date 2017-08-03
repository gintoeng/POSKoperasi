<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Anggota;
use App\Model\Master\Koderecab;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class CabangrekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recab = Koderecab::orderBy('id','asc')->paginate(20);
        $jml = Koderecab::count();
        return view('master.cabangrekening.daftar_recab')->with('recab', $recab)->with('jml', $jml);
    }

    public function search(Request $r)
    {
        $query = $r->input('query');
        $recab = Koderecab::where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Koderecab::where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->count();
        return view('master.cabangrekening.cari_recab')->with('recab', $recab)->with('query', $query)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.cabangrekening.tambah_recab');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valrecab = Koderecab::where('kode', $request->kode)->orWhere('nama', $request->nama)->first();
        if ($valrecab == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Cabang Rekening", $options = []);
            Koderecab::create([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
        } else {
            if ($request->kode == $valrecab->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valrecab->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Cabang Rekening", $options = []);
        }
        return redirect(url('master/cabangrekening'))
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
        $recab = Koderecab::findOrNew($id);
        return view('master.cabangrekening.ubah_recab')->with('recab', $recab);
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
        $valrecab = Koderecab::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama', $request->nama)->where('id', '!=', $id)->first();
        if ($valrecab == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Cabang Rekening", $options = []);
            $recab = Koderecab::findOrNew($id);
            $recab->update([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
        } else {
            if ($request->kode == $valrecab->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valrecab->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Cabang Rekening", $options = []);
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
        $alert = Toastr::success($msg, $title = "Hapus Cabang Rekening", $options = []);
        Anggota::where('kode_rekening', $id)->delete();
        Koderecab::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.cabangrekening.import_recab');
    }

    public function export()
    {
        Excel::create("export_recab", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $recab = Koderecab::all();
                foreach($recab as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_RECAB'));

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
            foreach ($result as $value) {
                if ($value->kode != "") {
                    $z+=1;
//                    $valrecab = Koderecab::where('kode', $value->kode)->orWhere('nama', $value->nama_recab)->first();
                    $valrecab = Koderecab::where('kode', $value->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valrecab != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama_recab);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valrecab == null) {
                            $no++;
                            Koderecab::create([
                                'kode' => $value->kode,
                                'nama' => $value->nama_recab
                            ]);
                        }
                    } else {
                        $no++;
                        $datanya = ['kode' => $value->kode, 'nama' => $value->nama_recab];
                        if ($valrecab == null) {
                            Koderecab::create($datanya);
                        } else {
                            $recab = Koderecab::find($valrecab->id);
                            $recab->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Cabang Rekening", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Cabang Rekening", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/cabangrekening/import'))
            ->with('alert', $alert);

    }

    public function sampleimport()
    {
        Excel::create("import_recab_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('007', 'Bintaro'),
                    array('009', 'Jakarta')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_RECAB'));

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
            return redirect(url('master/cabangrekening/import'));
        })->download('xls');
    }
}
