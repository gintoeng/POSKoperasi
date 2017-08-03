<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Katshuheader;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class KatshuheaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shuheader = Katshuheader::orderBy('id','asc')->paginate(20);
        $jml = Katshuheader::count();
        return view('master.shu.header.daftar_shuheader')->with('shuheader', $shuheader)->with('jml', $jml);
    }

    public function search(Request $r)
    {
        $query = $r->input('query');
        $shuheader = Katshuheader::where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Katshuheader::where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->count();
        return view('master.shu.header.cari_shuheader')->with('shuheader', $shuheader)->with('query', $query)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.shu.header.tambah_shuheader');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valshuheader = Katshuheader::where('kode', $request->kode)->orWhere('nama', $request->nama)->first();
        if ($valshuheader == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Kelompok SHU", $options = []);
            Katshuheader::create([
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
            $alert = Toastr::error($msg, $title = "Tambah Kelompok SHU", $options = []);
        }
        return redirect(url('master/katshuheader'))
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
        $shuheader = Katshuheader::findOrNew($id);
        return view('master.shu.header.ubah_shuheader')->with('shuheader', $shuheader);
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
        $valshuheader = Katshuheader::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama', $request->nama)->where('id', '!=', $id)->first();
        if ($valshuheader == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Kelompok SHU", $options = []);
            $shuheader = Katshuheader::findOrNew($id);
            $shuheader->update([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
        } else {
            if ($request->kode == $valshuheader->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valshuheader->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Kelompok SHU", $options = []);
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
        $alert = Toastr::success($msg, $title = "Hapus Kelompok SHU", $options = []);
        Katshuheader::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.shu.header.import_shuheader');
    }

    public function export()
    {
        Excel::create("export_kelompok_shu", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $shuheader = Katshuheader::all();
                foreach($shuheader as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA'));

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
//                    $valshuheader = Katshuheader::where('kode', $value->kode)->orWhere('nama', $value->nama)->first();
                    $valshuheader = Katshuheader::where('kode', $value->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valshuheader != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valshuheader == null) {
                            $no++;
                            Katshuheader::create([
                                'kode' => $value->kode,
                                'nama' => $value->nama
                            ]);
                        }
                    } else {
                        $no++;
                        $datanya = ['kode' => $value->nama, 'nama' => $value->nama];
                        if ($valshuheader == null) {
                            Katshuheader::create($datanya);
                        } else {
                            $shuheader = Katshuheader::find($valshuheader->id);
                            $shuheader->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Kelompok SHU", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Kelompok SHU", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/katshuheader/import'))
            ->with('alert', $alert);

    }

    public function sampleimport()
    {
        Excel::create("import_kelompok_shu_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('SM', 'Simpanan'),
                    array('PJ', 'Pinjaman'),
                    array('WD', 'Waserda')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA'));

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
            return redirect(url('master/katshuheader/import'));
        })->download('xls');
    }
}
