<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Katshudetail;
use App\Model\Master\Katshuheader;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class KatshudetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shudetail = Katshudetail::orderBy('id','asc')->paginate(20);
        $jml = Katshudetail::count();
        return view('master.shu.detail.daftar_shudetail')->with('shudetail', $shudetail)->with('jml', $jml);
    }

    public function search(Request $r)
    {
        $query = $r->input('query');
        $shudetail = Katshudetail::where('nama','like','%'.$query.'%')->orWhere('percent','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Katshudetail::where('nama','like','%'.$query.'%')->orWhere('percent','like','%'.$query.'%')->count();
        return view('master.shu.detail.cari_shudetail')->with('shudetail', $shudetail)->with('query', $query)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $header = Katshuheader::all();
        return view('master.shu.detail.tambah_shudetail')->with('header', $header);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->menerima_shu == 1) {
            $shu = $request->menerima_shu;
        } else {
            $shu = 0;
        }
        $valshudetail = Katshudetail::where('nama', $request->nama)->first();
        if ($valshudetail == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah SHU", $options = []);
            Katshudetail::create([
                'id_header'  => $request->id_header,
                'nama'       => $request->nama,
                'percent'    => $request->percent,
                'masuk_shu'    => $shu,
                'fieldnya'   => $request->field
            ]);
        } else {
            if($request->nama == $valshudetail->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah SHU", $options = []);
        }
        return redirect(url('master/katshudetail'))
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
        $shudetail = Katshudetail::findOrNew($id);
        $header = Katshuheader::all();
        return view('master.shu.detail.ubah_shudetail')->with('shudetail', $shudetail)->with('header', $header);
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
        if ($request->menerima_shu == 1) {
            $shu = $request->menerima_shu;
        } else {
            $shu = 0;
        }
        $valshudetail = Katshudetail::where('id', '!=', $id)->where('nama', $request->nama)->first();
        if ($valshudetail == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah SHU", $options = []);
            $shudetail = Katshudetail::findOrNew($id);
            $shudetail->update([
                'id_header'  => $request->id_header,
                'nama'       => $request->nama,
                'percent'    => $request->percent,
                'masuk_shu'    => $shu,
                'fieldnya'   => $request->field
            ]);
        } else {
            if($request->nama == $valshudetail->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah SHU", $options = []);
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
        $alert = Toastr::success($msg, $title = "Hapus SHU", $options = []);
        Katshudetail::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.shu.detail.import_shudetail');
    }

    public function export()
    {
        Excel::create("export_shu", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $shudetail = Katshudetail::all();
                foreach($shudetail as $item){
                    $data=[];
                    array_push($data, array(
                        $item->headershu->kode,
                        $item->nama,
                        $item->percent,
                        $item->field
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KD_HEADER','NAMA','PERCENT','FIELD'));

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
                $sheet->setWidth('C', '10');
                $sheet->setWidth('D', '20');
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
                if ($value->nama != "") {
                    $z+=1;
                    $valshudetail = Katshudetail::where('nama', $value->nama)->first();

                    if ($request->konf == "cekdata") {
                        if ($valshudetail != null) {
                            $data[] = array('nm' => $value->nama);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valshudetail == null) {
                            $header = Katshuheader::where('kode', $value->kd_header)->first();
                            if ($header != null) {
                                $no++;
                                Katshudetail::create([
                                    'id_header' => $header->id,
                                    'nama' => $value->nama,
                                    'persen' => $value->persen,
                                    'fieldnya' => $value->field,
                                    'masuk_shu' => '1'
                                ]);
                            }
                        }
                    } else {
                        $header = Katshuheader::where('kode', $value->kd_header)->first();
                        if ($header != null) {
                            $no++;
                            $datanya = [
                                'id_header' => $header->id,
                                'nama' => $value->nama,
                                'persen' => $value->persen,
                                'fieldnya' => $value->field,
                                'masuk_shu' => '1'
                            ];
                            if ($valshudetail == null) {
                                Katshudetail::create($datanya);
                            } else {
                                $shudetail = Katshudetail::find($valshudetail->id);
                                $shudetail->update($datanya);
                            }
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
                        $msg = $item["nm"] . "<br>";
                        $alert = Toastr::warning($msg, $title = null, $options = []);
                    }
                }
            } else {
                $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : " . $no;
                $alert = Toastr::success($msg, $title = "Import SHU", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import SHU", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/katshudetail/import'))
            ->with('alert', $alert);

    }

    public function sampleimport()
    {
        Excel::create("import_shu_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('SP', 'Simpanan Pokok', '70', 'bunga'),
                    array('PJ', 'Pinjaman Uang', '30', 'bunga')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KD_HEADER','NAMA','PERSEN','FIELD'));

                $sheet->setBorder('A1:D1', 'thin');
                $sheet->cells('A1:D1', function($cells){
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
                $sheet->setWidth('C', '10');
                $sheet->setWidth('D', '20');
            });
            return redirect(url('master/katshudetail/import'));
        })->download('xls');
    }
}
