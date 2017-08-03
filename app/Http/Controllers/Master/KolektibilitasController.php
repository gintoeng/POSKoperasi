<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Kolektibilitas;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class KolektibilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kolektibilitas = DB::table('kolektibilitas')->orderBy('id','asc')->paginate(20);
        $jml = Kolektibilitas::count();
        return view('master.kolektibilitas.daftar_kolektibilitas')->with('kolektibilitas', $kolektibilitas)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $kolektibilitas = DB::table('kolektibilitas')->where('kode','like','%'.$query.'%')->orWhere('keterangan','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('kolektibilitas')->where('kode','like','%'.$query.'%')->count();
      return view('master.kolektibilitas.cari_kolektibilitas')->with('kolektibilitas', $kolektibilitas)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $kolektibilitas = Kolektibilitas::findOrNew($id);
        return view('master.kolektibilitas.ubah_kolektibilitas')->with('kolektibilitas', $kolektibilitas);
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
        $valkol = Kolektibilitas::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('keterangan', $request->keterangan)->where('id', '!=', $id)->first();
        if ($valkol == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Kolektibilitas", $options = []);
            $kolektibilitas = Kolektibilitas::findOrNew($id);
            $kolektibilitas->update([
                'kode' => $request->kode,
                'keterangan' => $request->keterangan,
                'batas_hari' => $request->batas_hari
            ]);
        } else {
            if ($request->kode == $valkol->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->keterangan == $valkol->keterangan) {
                $dg = "dengan keterangan : ".$request->keterangan;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Kolektibilitas", $options = []);
        }

//        return redirect(url('master/kolektibilitas'))
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
        //
    }

    public function export()
    {
        Excel::create("export_kolektibilitas", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $kolek = Kolektibilitas::all();
                foreach($kolek as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->keterangan,
                        $item->batas_hari
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','KETERANGAN','BATAS_HARI'));

                $sheet->setBorder('A1:C1', 'thin');
                $sheet->cells('A1:C1', function($cells){
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
            });
            return redirect(url()->previous());
        })->download('xls');
    }
}
