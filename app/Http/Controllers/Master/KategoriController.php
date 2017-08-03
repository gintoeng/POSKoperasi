<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Kategori;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = DB::table('kategori')->orderBy('id','asc')->paginate(20);
        $jml = Kategori::count();
        return view('master.kategori.daftar_kategori')->with('kategori', $kategori)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $kategori = DB::table('kategori')->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('kategori')->where('nama','like','%'.$query.'%')->orWhere('kode','like','%'.$query.'%')->count();
      return view('master.kategori.cari_kategori')->with('kategori', $kategori)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.kategori.tambah_kategori');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valkat = Kategori::where('kode', $request->kode)->orWhere('nama', $request->nama)->first();
        if ($valkat == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Kategori", $options = []);
            Kategori::create([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);   
        } else {
            if ($request->kode == $valkat->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valkat->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Kategori", $options = []);
        }
        return redirect(url('master/kategori'))
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
        $kategori = Kategori::findOrNew($id);
        return view('master.kategori.ubah_kategori')->with('kategori', $kategori);
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
        $valkat = Kategori::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama', $request->nama)->where('id', '!=', $id)->first();
        if ($valkat == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Kategori", $options = []);
            $kategori = Kategori::findOrNew($id);
            $kategori->update([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
        } else {
            if ($request->kode == $valkat->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama == $valkat->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Kategori", $options = []);
        }
//        return redirect(url('master/kategori'))
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
        $alert = Toastr::success($msg, $title = "Hapus Kategori", $options = []);
        Kategori::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.kategori.import_kategori');
    }

    public function export()
    {
        Excel::create("export_kategori", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $kategori = Kategori::all();
                foreach($kategori as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_KATEGORI'));

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
//                    $valkat = Kategori::where('kode', $value->kode)->orWhere('nama', $value->nama_kategori)->first();
                    $valkat = Kategori::where('kode', $value->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valkat != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama_kategori);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valkat == null) {
                            $no++;
                            Kategori::create([
                                'kode' => $value->kode,
                                'nama' => $value->nama_kategori
                            ]);
                        }
                    } else {
                        $no++;
                        $datanya = ['kode' => $value->nama, 'nama' => $value->nama_kategori];
                        if ($valkat == null) {
                            Kategori::create($datanya);
                        } else {
                            $kategori = Kategori::find($valkat->id);
                            $kategori->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Kategori", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Kategori", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/kategori/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_kategori_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('PM', 'Peralatan Mandi'),
                    array('MR', 'Makanan Ringan')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_KATEGORI'));

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
            return redirect(url('master/kategori/import'));
        })->download('xls');
    }
}
