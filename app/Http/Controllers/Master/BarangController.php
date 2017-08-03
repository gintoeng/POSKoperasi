<?php

namespace App\Http\Controllers\Master;

use App\Model\Master\Bank;
use App\Model\Master\Barang;
use App\Model\Master\Cabang;
use App\Model\Master\Kategori;
use App\Model\Master\Katshudetail;
use App\Model\Master\Mappingbarang;
use App\Model\Master\Matauang;
use App\Model\Master\Unit;
use App\Model\Master\Vendor;
use Illuminate\Http\Request;

use File;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = DB::table('produk')->orderBy('id','asc')->paginate(20);
        $jml = Barang::count();
        return view('master.barang.daftar_barang')->with('barang', $barang)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $barang = Barang::where('nama','like','%'.$query.'%')->orWhere('classification','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = Barang::where('nama','like','%'.$query.'%')->orWhere('classification','like','%'.$query.'%')->count();
      return view('master.barang.cari_barang')->with('barang', $barang)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matauang = Matauang::all();
        $unit = Unit::all();
        $kategori = Kategori::all();
        $vendor = Vendor::all();
        $cabang = Cabang::all();
        date_default_timezone_set('Asia/Jakarta');
        $datefrom = date('m/01/Y');
        $df = date('Y-m-01');
        $dateto = date('m/t/Y');
        $dt = date('Y-m-t');
        $shu = Katshudetail::all();
        return view('master.barang.tambah_barang')->with('matauang', $matauang)
                                                  ->with('unit', $unit)
                                                  ->with('kategori', $kategori)
                                                    ->with('vendor', $vendor)
            ->with('cabang', $cabang)
            ->with('shu', $shu)
            ->with('datefrom', $datefrom)
            ->with('dateto', $dateto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->datefrom == "") {
            $datefrom = "00/00/0000";
        } else {
            $datefrom = $request->datefrom;
        }

        if ($request->dateto == "") {
            $dateto = "00/00/0000";
        } else {
            $dateto = $request->dateto;
        }

        if ($request->konsinyasi == 1) {
            $auto = $request->konsinyasi;
        } else {
            $auto = 0;
        }

        $datefrom2 = explode('/', $datefrom);
        $dateto2 = explode('/', $dateto);

        $hdiskon = str_replace(",","",$request->diskon_nominal);
        $hd = str_replace(".00","",$hdiskon);

        $hjual = str_replace(",","",$request->harga_jual);
        $hj = str_replace(".00","",$hjual);

        $hbeli = str_replace(",","",$request->harga_beli);
        $hb = str_replace(".00","",$hbeli);

        $huntung = str_replace(",","",$request->untung);
        $hu = str_replace(".00","",$huntung);

        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/barang/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "avatar.jpg";
        }

        $valbarang = Barang::where('nama', $request->nama)->first();
        if ($valbarang == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Barang", $options = []);
            Barang::create([
                'nama' => $request->nama,
                'classification' => $request->classification,
                'unit' => $request->unit,
                'curr' => $request->curr,
                'harga_jual' => $hj,
                'harga_beli' => $hb,
                'disc_tipe'    => $request->diskon_tipe,
                'disc'    => $request->diskon_persen,
                'disc_nominal'    => $hd,
                'tanggal_awal_diskon' => $datefrom2[2].'-'.$datefrom2[0].'-'.$datefrom2[1],
                'tanggal_akhir_diskon' => $dateto2[2].'-'.$dateto2[0].'-'.$dateto2[1],
//                'stok' => $request->stok,
                'stok_minimum' => $request->stokmin,
                'barcode' => $request->barcode,
                'remark' => $request->remark,
                'status' => $request->status,
//                'expired' => $dateex2[2].'-'.$dateex2[0].'-'.$dateex2[1],
//                'print_label' => $request->print_label,
//                'ganti_harga' => $request->ganti_harga,
                'kategori' => $request->kategori,
                'ket' => $request->ket,
                'untung' => $hu,
                'foto' => $filename,
                'konsinyasi' => $auto,
                'id_shu'    => $request->shu
            ]);
            

            
        } else {
            if($request->nama == $valbarang->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
//            $msg = "Data Gagal di Tambahkan.<br> Data Sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Barang", $options = []);
        }

        return redirect(url('master/barang'))
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
        $barang = Barang::findOrNew($id);
        $matauang = Matauang::all();
        $unit = Unit::all();
        $vendor = Vendor::all();
        $kategori = Kategori::all();
        $cabang = Cabang::all();
        foreach($unit as $sel) {
            $barang['selected_no1'] = $barang['unit'] == $sel->id ? 'selected' : '';
        }
        foreach($matauang as $sel2) {
            $barang['selected_no2'] = $barang['curr'] == $sel2->id ? 'selected' : '';
        }
        foreach($kategori as $sel3) {
            $barang['selected_no3'] = $barang['kategori'] == $sel3->id ? 'selected' : '';
        }

        foreach($cabang as $sel4) {
            $barang['selected_no4'] = $barang['id_koperasi'] == $sel4->id ? 'selected' : '';
        }

        if ($barang->tanggal_awal_diskon == "0000-00-00") {
            $datefrom = "";
        } else {
            $datefrom = date("m/d/Y", strtotime($barang->tanggal_awal_diskon));
        }

        if ($barang->tanggal_akhir_diskon == "0000-00-00") {
            $dateto = "";
        } else {
            $dateto = date("m/d/Y", strtotime($barang->tanggal_akhir_diskon));
        }

        if ($barang->expired == "0000-00-00") {
            $dateex = "";
        } else {
            $dateex = date("m/d/Y", strtotime($barang->expired));
        }

        $shu = Katshudetail::all();
        return view('master.barang.ubah_barang')->with('barang', $barang)
                                                  ->with('matauang', $matauang)
                                                  ->with('unit', $unit)
                                                  ->with('kategori', $kategori)
                                                    ->with('vendor', $vendor)
                                                    ->with('cabang', $cabang)
                                                    ->with('shu', $shu)
                                                    ->with('datefrom', $datefrom)
                                                    ->with('dateto', $dateto)
                                                    ->with('dateex', $dateex);
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
        if ($request->datefrom == "") {
            $datefrom = "00/00/0000";
        } else {
            $datefrom = $request->datefrom;
        }

        if ($request->dateto == "") {
            $dateto = "00/00/0000";
        } else {
            $dateto = $request->dateto;
        }

        if ($request->konsinyasi == 1) {
            $auto = $request->konsinyasi;
        } else {
            $auto = 0;
        }

        $datefrom2 = explode('/', $datefrom);
        $dateto2 = explode('/', $dateto);

        $hdiskon = str_replace(",","",$request->diskon_nominal);
        $hd = str_replace(".00","",$hdiskon);

        $hjual = str_replace(",","",$request->harga_jual);
        $hj = str_replace(".00","",$hjual);

        $hbeli = str_replace(",","",$request->harga_beli);
        $hb = str_replace(".00","",$hbeli);

        $huntung = str_replace(",","",$request->untung);
        $hu = str_replace(".00","",$huntung);

        if ($request->hasFile('foto'))
        {
            $brg = Barang::find($id);
            File::delete('foto/barang/'.$brg->foto);
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/barang/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = $request->gambar;
        }

        $valbarang = Barang::where('id', '!=', $id)->where('nama', $request->nama)->first();
        if ($valbarang == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Barang", $options = []);
            $barang = Barang::findOrNew($id);
            $barang->update([
                'nama' => $request->nama,
                'classification' => $request->classification,
                'unit'  => $request->unit,
                'curr'  => $request->curr,
                'harga_jual' => $hj,
                'harga_beli' => $hb,
                'disc_tipe'    => $request->diskon_tipe,
                'disc'    => $request->diskon_persen,
                'disc_nominal'    => $hd,
                'tanggal_awal_diskon' => $datefrom2[2].'-'.$datefrom2[0].'-'.$datefrom2[1],
                'tanggal_akhir_diskon' => $dateto2[2].'-'.$dateto2[0].'-'.$dateto2[1],
//                'stok'    => $request->stok,
                'stok_minimum'    => $request->stokmin,
                'barcode' => $request->barcode,
                'remark'  => $request->remark,
                'status'  => $request->status,
//                'expired'      => $dateex2[2].'-'.$dateex2[0].'-'.$dateex2[1],
//                'print_label'  => $request->print_label,
//                'ganti_harga'  => $request->ganti_harga,
                'kategori'     => $request->kategori,
                'ket'          => $request->ket,
                'untung'       => $hu,
                'foto'         => $filename,
                'konsinyasi'=> $auto,
                'id_shu'    => $request->shu
            ]);
        } else {
            if($request->nama == $valbarang->nama) {
                $dg = "dengan nama : ".$request->nama;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Barang", $options = []);
        }

//        return redirect(url('master/barang'))
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
        $alert = Toastr::success($msg, $title = "Hapus Barang", $options = []);
        Barang::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.barang.import_barang');
    }

    public function export()
    {
        Excel::create("export_barang", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $barang = Barang::all();
                foreach($barang as $item){
                    $stokbarang = Mappingbarang::where('id_produk', $item->id)->sum('stok');
                    $data=[];
                    array_push($data, array(
                        $item->nama,
                        $item->classification,
                        $item->harga_jual,
                        $item->harga_beli,
                        $item->disc,
                        $stokbarang,
//                        $item->expired,
                        $item->unitid->kode,
                        $item->kategoriid->kode,
                        $item->untung,
                        $item->barcode
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('NAMA', 'MERK', 'HARGA_JUAL', 'HARGA_BELI', 'DISC', 'STOK', 'UNIT_KD', 'KAT_KD', 'UNTUNG', 'BARCODE'));

                $sheet->setBorder('A1:J1', 'thin');
                $sheet->cells('A1:J1', function($cells){
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
                $sheet->setWidth('C', '20');
                $sheet->setWidth('D', '10');
                $sheet->setWidth('E', '10');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '10');
                $sheet->setWidth('H', '10');
                $sheet->setWidth('I', '20');
                $sheet->setWidth('J', '20');
//                $sheet->setWidth('K', '20');
            });
            return redirect(url()->previous());
        })->download('xls');
    }

    public function importnya(Request $request)
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

            $result = Excel::load('public/foto/'.$filename)->get();
            foreach ($result as $value) {
                if ($value->nama != "") {
                    $no++;
                    $your_date = date("Y-m-d", strtotime($value->expired));
                    Barang::create([
                        'nama' => $value->nama,
                        'classification' => $value->merk,
                        'harga_jual' => $value->harga_jual,
                        'harga_beli' => $value->harga_beli,
                        'disc' => $value->disc,
//                        'stok' => $value->stok,
                        'barcode' => $value->barcode,
                        'unit' => $value->unit_id,
                        'kategori' => $value->kat_id,
                        'expired' => $your_date,
                        'untung' => $value->untung
                    ]);
                }
            }
            $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : ".$no;
            $alert = Toastr::success($msg, $title = "Import Barang", $options = []);
        } else {
            $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Bank", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('inventory/import/barang'))
            ->with('alert', $alert);
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
                    $valbarang = Barang::where('nama', $value->nama)->first();

                    if ($request->konf == "cekdata") {
                        if ($valbarang != null) {
                            $data[] = array('nm' => $value->nama);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valbarang == null) {
                            $unit = Unit::where('kode', $value->unit_kd)->first();
                            if ($unit != null) {
                                $kategori = Kategori::where('kode', $value->kategori_kd)->first();
                                if ($kategori != null) {
                                    $shu = Katshudetail::orderBy('id', 'asc')->first();
                                    if ($shu == null) {
                                        $shu = Katshudetail::create([
                                            'id_header'  => 3,
                                            'nama'       => "SHU Barang Baru",
                                            'percent'    => 0,
                                            'masuk_shu'   => 1,
                                            'fieldnya'   => "untung"
                                        ]);
                                    }
                                    $uang = Matauang::where('def', 1)->first();
                                    if ($uang == null) {
                                        $uang = Matauang::create(['kode' => 'Rp', 'nama' => 'Rupiah', 'def' => 1]);
                                    }
                                    $no++;
                                    Barang::create([
                                        'nama' => $value->nama,
                                        'classification' => $value->merk,
                                        'harga_jual' => $value->harga_jual,
                                        'harga_beli' => $value->harga_beli,
                                        'disc' => $value->disc,
                                        'curr' => $uang->id,
                                        'barcode' => $value->barcode,
                                        'unit' => $unit->id,
                                        'kategori' => $kategori->id,
                                        'untung' => $value->untung,
                                        'id_shu' =>$shu->id
                                    ]);
                                }
                            }
                        }
                    } else {
                        if ($value->unit_kd != "" && $value->kat_kd != "") {
                            $shu = Katshudetail::orderBy('id', 'asc')->first();
                            if ($shu == null) {
                                $shu = Katshudetail::create([
                                    'id_header'  => 3,
                                    'nama'       => "SHU Barang Baru",
                                    'percent'    => 0,
                                    'masuk_shu'   => 1,
                                    'fieldnya'   => "untung"
                                ]);
                            }
                            $uang = Matauang::where('def', 1)->first();
                            if ($uang == null) {
                                $uang = Matauang::create(['kode' => 'Rp', 'nama' => 'Rupiah', 'def' => 1]);
                            }

                            $unit = Unit::where('kode', $value->unit_kd)->first();
                            if ($unit == null) {
                                $unit = Unit::create(['kode' => $value->unit_kd, 'nama_unit' => $value->unit_kd]);
                            }

                            $kategori = Kategori::where('kode', $value->kategori_kd)->first();
                            if ($kategori == null) {
                                $kategori = Kategori::create(['kode' => $value->kat_kd, 'nama' => $value->kat_kd]);
                            }
                            $no++;
                            $datanya = [
                                'nama' => $value->nama,
                                'classification' => $value->merk,
                                'harga_jual' => $value->harga_jual,
                                'harga_beli' => $value->harga_beli,
                                'disc' => $value->disc,
                                'curr' => $uang->id,
                                'barcode' => $value->barcode,
                                'unit' => $unit->id,
                                'kategori' => $kategori->id,
                                'untung' => $value->untung,
                                'id_shu' => $shu->id
                            ];
                            if ($valbarang == null) {
                                Barang::create($datanya);
                            } else {
                                $barang = Barang::find($valbarang->id);
                                $barang->update($datanya);
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
                $alert = Toastr::success($msg, $title = "Import Barang", $options = []);
            }
        } else {
            $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Barang", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/barang/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_barang_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('Piatos', 'Dua Kelinci', '2000', '1000', '0', 'PCS', 'MR', '1000', '123456789'),
                    array('Kopi', 'Dua Kelinci', '4000', '6000', '0', 'PCS', 'MR', '2000', '987654321')
                ), null, 'A2', false, false);
                $sheet->row(1, array('NAMA', 'MERK', 'HARGA_JUAL', 'HARGA_BELI', 'DISC', 'UNIT_KD', 'KAT_KD', 'UNTUNG', 'BARCODE'));

                $sheet->setBorder('A1:I1', 'thin');
                $sheet->cells('A1:I1', function($cells){
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
                $sheet->setWidth('C', '20');
                $sheet->setWidth('D', '10');
                $sheet->setWidth('E', '10');
                $sheet->setWidth('F', '10');
                $sheet->setWidth('G', '10');
                $sheet->setWidth('H', '10');
                $sheet->setWidth('I', '20');
//                $sheet->setWidth('J', '20');


            });
            return redirect(url('master/barang/import'));
        })->download('xls');
    }

    public function untung($j, $b) {
        $hjual = str_replace(",","",$j);
        $hj = str_replace(".00","",$hjual);

        $hbeli = str_replace(",","",$b);
        $hb = str_replace(".00","",$hbeli);

        $untung = $hj - $hb;
        $data[] = array(
            'untung' => number_format($untung, 2, '.', ',')
        );

        return json_encode($data);
//        echo '<input name="untung" type="text" class="form-control" id="untung" value="'.number_format($untung, 2, '.', ',').'" style="text-align:right" required disabled>';
    }

    public function cekaturanimport() {
//        $nom = Vendor::count();
        $nom2 = Kategori::count();
        $nom3 = Unit::count();
//        $nom4 = Cabang::count();
        if($nom2 < 1){
            $stat = "FAIL";
            $title = "Kategori";
            $psg = "Data Kategori tidak ditemukan";
//        } else if($nom < 1){
//            $stat = "FAIL";
//            $title = "Vendor";
//            $psg = "Data Vendor tidak ditemukan";
        } else if($nom3 < 1){
            $stat = "FAIL";
            $title = "Unit";
            $psg = "Data Unit tidak ditemukan";
//        } else if($nom4 < 1){
//            $stat = "FAIL";
//            $title = "Cabang";
//            $psg = "Data Cabang tidak ditemukan";
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
}
