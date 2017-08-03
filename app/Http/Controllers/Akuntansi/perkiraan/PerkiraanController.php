<?php

namespace App\Http\Controllers\Akuntansi\perkiraan;

use App\Model\Akuntansi\Perkiraan;

use Illuminate\Http\Request;
use File;
use DB;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use narutimateum\Toastr\Facades\Toastr;

class PerkiraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akun_parent = Perkiraan::where('parent', '0')->orderBy('id', 'ASC')->get();

        $akun_parent2 = Perkiraan::where('parent', '0')->orderBy('id', 'ASC')->first();

        $active = $akun_parent2->id;

        return view('Akuntansi.perkiraan.daftar_perkiraan')->with('akun_parent', $akun_parent)
                                                            ->with('active', $active);
    }

    public function create($id)
    {
        $values = Perkiraan::find($id);

        $header = Perkiraan::where('tipe_akun', 'header')->where('kelompok', $values->kelompok)->get();

        $idterpilih = $id;

        $perkiraan = Perkiraan::where('parent', '0')->get();

        return view('Akuntansi.perkiraan.perkiraan_tambah') ->with('perkiraan', $perkiraan)
                                                            ->with('idterpilih', $idterpilih)
                                                            ->with('values', $values)
                                                            ->with('header', $header);
    }

    public function create2()
    {
        $last = Perkiraan::orderBy('id', 'DESC')->first();
        $values = $last->id + 1;

        return view('Akuntansi.perkiraan.perkiraan_tambahheader')->with('values', $values);
    }

    public function headerstore(Request $request)
    {

        if($request->kas==1){
            $kas = "1";
        } else {
            $kas = "0";
        }

        if($request->kode_akun == "" || $request->nama_akun == ""){
            $msg = "Gagal! <br> Anda harus mengisi semua form input yang diminta!";
            $alert = Toastr::error($msg, $title = "Tambah Data Akun Perkiraan", $options = []);
            return redirect(url('akuntansi/perkiraan/create'))->with('alert', $alert);
        }

        $perkiraan = new Perkiraan();
        $perkiraan->tipe_akun = $request->tipe_akun;
        $perkiraan->kelompok = $request->kelompok_akun;
        $perkiraan->parent = '0';
        $perkiraan->kode_akun = $request->kode_akun;
        $perkiraan->nama_akun = $request->nama_akun;
        $perkiraan->kas = $kas;
        $perkiraan->save();

        $active = $perkiraan->id;

        $msg = "Berhasil! <br> Anda berhasil menambahkan data Akun Perkiraan";
        $alert = Toastr::success($msg, $title = "Tambah Data Akun Perkiraan", $options = []);

        return redirect(url('akuntansi/perkiraan'))
            ->with('alert', $alert)
            ->with('actives', $active);
    }

    public function import()
    {
        return view('Akuntansi.perkiraan.perkiraan_import');
    }

    public function importpost(Request $request)
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

        //Perkiraan::where('tipe_akun', '!=', '')->delete();

        if ($xls[1] == "xls" || $xls[1] == "csv") {
            $z = 0;
            $w = 0;
            $result = Excel::load('public/foto/'.$filename)->get();
            foreach ($result as $value) {
                if ($value->tipe_akun != "") {
                    $kas = 0;
                    if($value->kas=="Ya"){
                        $kas = 1;
                    } else {
                        $kas = 0;
                    }

                    $z+=1;
                    $valakun = Perkiraan::where('kode_akun', $value->kode_akun)->first();
                    if ($request->konf == "cekdata") {
                        if ($valakun != null) {
                            $data[] = array('kd' => $value->kode_akun, 'nm' => $value->nama_akun);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valakun == null) {
                            $no++;
                            if($value->tipe_akun=="header" && $value->kelompok=='0' && $value->parent=='0'){
                                $Perkiraan = new Perkiraan;
                                $Perkiraan->tipe_akun = $value->tipe_akun;
                                $Perkiraan->kelompok = $value->kelompok;
                                $Perkiraan->parent = '0';
                                $Perkiraan->kode_akun = $value->kode_akun;
                                $Perkiraan->nama_akun = $value->nama_akun;
                                $Perkiraan->kas = $kas;
                                $Perkiraan->save();

                                $perkiraanedit = Perkiraan::find($Perkiraan->id);
                                $perkiraanedit->kelompok = $Perkiraan->id;
                                $perkiraanedit->save();
                            } else {
                                $parent = Perkiraan::where('kode_akun', $value->parent)->first();
                                $kelompok = Perkiraan::where('kode_akun', $value->kelompok)->first();

                                $Perkiraan = new Perkiraan;
                                $Perkiraan->tipe_akun = $value->tipe_akun;
                                $Perkiraan->kelompok = $kelompok->id;
                                $Perkiraan->parent = $parent->id;
                                $Perkiraan->kode_akun = $value->kode_akun;
                                $Perkiraan->nama_akun = $value->nama_akun;
                                $Perkiraan->kas = $kas;
                                $Perkiraan->save();
                            }
                        }
                    } else {
                        $no++;
                        if($value->tipe_akun=="header" && $value->kelompok=='0' && $value->parent=='0'){
                            if ($valakun == null) {
                                $Perkiraan = new Perkiraan;
                            } else {
                                $Perkiraan = Perkiraan::find($valakun->id);
                            }
                            $Perkiraan->tipe_akun = $value->tipe_akun;
                            $Perkiraan->kelompok = $value->kelompok;
                            $Perkiraan->parent = '0';
                            $Perkiraan->kode_akun = $value->kode_akun;
                            $Perkiraan->nama_akun = $value->nama_akun;
                            $Perkiraan->kas = $kas;
                            $Perkiraan->save();

                            $perkiraanedit = Perkiraan::find($Perkiraan->id);
                            $perkiraanedit->kelompok = $Perkiraan->id;
                            $perkiraanedit->save();
                        } else {
                            $parent = Perkiraan::where('kode_akun', $value->parent)->first();
                            $kelompok = Perkiraan::where('kode_akun', $value->kelompok)->first();

                            if ($valakun == null) {
                                $Perkiraan = new Perkiraan;
                            } else {
                                $Perkiraan = Perkiraan::find($valakun->id);
                            }
                            $Perkiraan->tipe_akun = $value->tipe_akun;
                            $Perkiraan->kelompok = $kelompok->id;
                            $Perkiraan->parent = $parent->id;
                            $Perkiraan->kode_akun = $value->kode_akun;
                            $Perkiraan->nama_akun = $value->nama_akun;
                            $Perkiraan->kas = $kas;
                            $Perkiraan->save();
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
                $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : ".$no;
                $alert = Toastr::success($msg, $title = "Import Data Perkiraan", $options = []);
            }
        } else {
            $msg = "ERROR! <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Perkiraan", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('akuntansi/perkiraan/import'))
            ->with('alert', $alert);

    }

    public function sample()
    {
        Excel::create("import_perkiraan_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('header', '0', '0', '1-000', 'ACTIVA', 'Tidak'),
                    array('header', '1-000', '1-000', '1-100', 'ACTIVA LANCAR', 'Tidak'),
                    array('header', '1-000', '1-100', '1-110', 'KAS', 'Tidak'),
                    array('detail', '1-000', '1-110', '1-111', 'KAS BERJALAN', 'Ya'),
                    array('detail', '1-000', '1-110', '1-112', 'KAS TETAP', 'Ya'),
                ), null, 'A2', false, false);
                $sheet->row(1, array('TIPE_AKUN', 'KELOMPOK', 'PARENT', 'KODE_AKUN', 'NAMA_AKUN', 'KAS'));

                $sheet->setBorder('A1:O1', 'thin');
                $sheet->cells('A1:F1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setValignment('center');
                    $cells->setFontSize('11');
                });
                $sheet->setHeight(array(
                    '1' => '30',
                    '2' => '15',
                    '3' => '15',
                    '4' => '15',
                    '5' => '15',
                    '6' => '15'
                ));
                $sheet->setWidth('A', '30');
                $sheet->setWidth('B', '30');
                $sheet->setWidth('C', '30');
                $sheet->setWidth('D', '30');
                $sheet->setWidth('E', '30');
                $sheet->setWidth('F', '30');
            });
            return redirect(url('akuntansi/perkiraan/import'));
        })->download('xls');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->kode_akun == "" || $request->nama_akun == ""){
            $msg = "Gagal! <br> Anda harus mengisi semua form input yang diminta!";
            $alert = Toastr::error($msg, $title = "Ubah Data Akun Perkiraan", $options = []);
            return redirect(url('akuntansi/perkiraan/create/'.$request->kelompok))->with('alert', $alert);
        }

        $msg = "Berhasil! <br> Anda berhasil menambahkan data Akun Perkiraan";
        $alert = Toastr::success($msg, $title = "Tambah Data Akun Perkiraan", $options = []);

        $iddicari = Perkiraan::find($request->idterpilih);
        if($iddicari->parent == 0){
            $actives = $request->idterpilih;
        } else {
            $actives = $iddicari->kelompok;
        }

        Perkiraan::create([
            'id' => '120',
            'tipe_akun' => $request->tipe_akun,
            'kelompok'  => $request->kelompok,
            'parent' => $request->header,
            'kode_akun'   => $request->kode_akun,
            'nama_akun'     => $request->nama_akun,
            'kas' => '0'
        ]);


        return redirect(url('akuntansi/perkiraan'))
            ->with('alert', $alert)
            ->with('actives', $actives);
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
        $values = Perkiraan::find($id);

        $header = Perkiraan::where('tipe_akun', 'header')->where('kelompok', $values->kelompok)->get();

        $perkiraan = Perkiraan::where('parent', '0')->get();

        return view('Akuntansi.perkiraan.perkiraan_ubah') ->with('perkiraan', $perkiraan)
                                                            ->with('values', $values)
                                                            ->with('header', $header);
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
        if($request->kode_akun == "" || $request->nama_akun == ""){
            $msg = "Gagal! <br> Anda harus mengisi semua form input yang diminta!";
            $alert = Toastr::error($msg, $title = "Ubah Data Akun Perkiraan", $options = []);
            return redirect(url('akuntansi/perkiraan/edit/'.$id))->with('alert', $alert);
        }

        $perkiraan = Perkiraan::findOrNew($id);

        $iddicari = Perkiraan::find($id);
        if($iddicari->parent == 0){
            $actives = $request->id;
            $parent = "0";
        } else {
            $actives = $iddicari->kelompok;
            $parent = $request->header;
        }

        if($request->kas==1){
            $kas = "1";
        } else {
            $kas = "0";
        }

        $perkiraan->update([
            'tipe_akun' => $request->tipe_akun,
            'kelompok'  => $request->kelompok,
            'parent' => $parent,
            'kode_akun'   => $request->kode_akun,
            'nama_akun'     => $request->nama_akun,
            'kas' => $kas
        ]);

        $msg = "Berhasil! <br> Anda berhasil mengubah data Akun Perkiraan";
        $alert = Toastr::success($msg, $title = "Ubah Data Akun Perkiraan", $options = []);
        return redirect(url('akuntansi/perkiraan'))
            ->with('alert', $alert)
            ->with('actives', $actives);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = "Berhasil! <br> Anda berhasil menghapus data Akun Perkiraan";
        $alert = Toastr::success($msg, $title = "Hapus Data Akun Perkiraan", $options = []);

        $perkiraan = Perkiraan::find($id);
        if($perkiraan->parent == 0){
            $actives = '0';
            $perkiraanchild = Perkiraan::where('kelompok', $perkiraan->id)->delete();
        } else {
            $actives = $perkiraan->kelompok;
            $perkiraanchild = Perkiraan::where('parent', $perkiraan->id)->delete();
        }

        Perkiraan::destroy($id);

        return redirect(url('akuntansi/perkiraan'))
                                         ->with('alert', $alert)
                                         ->with('actives', $actives);
    }

    public function kelompokget($id)
    {
        $perkiraan = Perkiraan::find($id);

        $kelompok = $perkiraan->kelompok;

        echo '<input name="kelompok_akun" type="text" class="form-control disabled" placeholder="kelompok_akun" readonly value="'.$kelompok.'">';
    }

    public function headersget($id)
    {
        $perkiraan = Perkiraan::find($id);

        $header = $header = Perkiraan::where('tipe_akun', 'header')->where('kelompok', $perkiraan->kelompok)->get();

        echo '<select name="header" class="form-control" id="header" placeholder="header">';
        foreach ($header as $headers) {

            echo '
                <option value="'.$headers->id.'" {selected}> '.$headers->kode_akun.' - '.$headers->nama_akun.'</option>
            ';
        }

        echo '</select>';
    }
}
