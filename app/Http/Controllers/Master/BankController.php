<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Bank;
use App\Model\Master\Matauang;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank = DB::table('bank')->orderBy('id','asc')->paginate(20);
        $jml = Bank::count();
        return view('master.bank.daftar_bank')->with('bank', $bank)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $bank = Bank::where('kode','like','%'.$query.'%')->orWhere('nama_bank','like','%'.$query.'%')->orWhere('mata_uang','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Bank::where('kode','like','%'.$query.'%')->orWhere('nama_bank','like','%'.$query.'%')->orWhere('mata_uang','like','%'.$query.'%')->count();
      return view('master.bank.cari_bank')->with('bank', $bank)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matauang = Matauang::all();
        return view('master.bank.tambah_bank')->with('matauang', $matauang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valbank = Bank::where('kode', $request->kode)->orWhere('nama_bank', $request->nama_bank)->first();
        if ($valbank == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Bank", $options = []);
            Bank::create([
                'kode' => $request->kode,
                'nama_bank' => $request->nama_bank,
                'mata_uang' => $request->mata_uang,
                'keterangan' => $request->keterangan
            ]);
        } else {
            if ($request->kode == $valbank->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_bank == $valbank->nama_bank) {
                $dg = "dengan nama : ".$request->nama_bank;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Bank", $options = []);
        }
        return redirect(url('master/bank'))
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
        $bank = Bank::findOrNew($id);
        $matauang = Matauang::all();
        return view('master.bank.ubah_bank')->with('bank', $bank)
                                            ->with('matauang', $matauang);
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
        $valbank = Bank::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama_bank', $request->nama_bank)->where('id', '!=', $id)->first();
        if ($valbank == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Bank", $options = []);
            $bank = Bank::findOrNew($id);
            $bank->update([
                'kode' => $request->kode,
                'nama_bank' => $request->nama_bank,
                'mata_uang' => $request->mata_uang,
                'keterangan' => $request->keterangan
            ]);
        } else {
            if ($request->kode == $valbank->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_bank == $valbank->nama_bank) {
                $dg = "dengan nama : ".$request->nama_bank;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Bank", $options = []);
        }

//        return redirect(url('master/bank'))
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
        $alert = Toastr::success($msg, $title = "Hapus Bank", $options = []);
        Bank::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.bank.import_bank');
    }

    public function export()
    {
        Excel::create("export_bank", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $bank = Bank::all();
                foreach($bank as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama_bank
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_BANK'));

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
//                    $valbank = Bank::where('kode', $request->kode)->orWhere('nama_bank', $request->nama_bank)->first();
                    $valbank = Bank::where('kode', $request->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valbank != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama_bank);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valbank == null) {
                            $no++;
                            Bank::create([
                                'kode' => $value->kode,
                                'nama_bank' => $value->nama_bank
                            ]);
                        }
                    } else {
                        $no++;
                        $datanya = ['kode' => $value->kode, 'nama_bank' => $value->nama_bank];
                        if ($valbank == null) {
                            Bank::create($datanya);
                        } else {
                            $bank = Bank::find($valbank->id);
                            $bank->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Bank", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Bank", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/bank/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_bank_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('DNM', 'Danamon'),
                    array('BCA', 'Bank CA')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_BANK'));

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
            return redirect(url('master/bank/import'));
        })->download('xls');
    }
}
