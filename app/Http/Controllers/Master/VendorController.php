<?php

namespace App\Http\Controllers\Master;

use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Bank;
use App\Model\Master\Matauang;
use App\Model\Master\Unit;
use App\Model\Master\Vendor;
use App\Model\Pengaturan\Nomor;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use narutimateum\Toastr\Facades\Toastr;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendor = DB::table('vendor')->orderBy('id','asc')->paginate(20);
        $jml = Vendor::count();
        return view('master.vendor.daftar_vendor')->with('vendor', $vendor)->with('jml', $jml);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');
      $vendor = DB::table('vendor')->where('kode','like','%'.$query.'%')->orWhere('nama_vendor','like','%'.$query.'%')->orWhere('nama_kontak','like','%'.$query.'%')->orderBy('id','asc')->paginate(20);
        $jml = DB::table('vendor')->where('kode','like','%'.$query.'%')->orWhere('nama_vendor','like','%'.$query.'%')->orWhere('nama_kontak','like','%'.$query.'%')->count();
      return view('master.vendor.cari_vendor')->with('vendor', $vendor)->with('query', $query)->with('jml',$jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank = Bank::all();
        $matauang = Matauang::all();
        $kode = $this->_generate();
        return view('master.vendor.tambah_vendor')->with('bank', $bank)
                                                  ->with('matauang', $matauang)
                                                    ->with('kode', $kode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valver = Vendor::where('kode', $request->kode)->orWhere('nama_vendor', $request->nama_vendor)->first();
        if ($valver == null) {
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Vendor", $options = []);
            Vendor::create([
                'kode'        => $request->kode,
                'nama_vendor' => $request->nama_vendor,
                'nama_kontak' => $request->nama_kontak,
                'alamat_1'   => $request->alamat_1,
                'alamat_2'   => $request->alamat_2,
                'phone'      => $request->phone,
                'fax'        => $request->fax,
                'bank'       => $request->bank,
                'nomor_akun' => $request->nomor_akun,
                'nama_akun'  => $request->nama_akun,
                'keterangan' => $request->keterangan
            ]);

            $nom = Nomor::where('modul', 'Master Vendor')->first();
            $format = Nomor::find($nom->id);
            $format->update(['nomor_now' => $nom->nomor_now + 1]);
        } else {
            if ($request->kode == $valver->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_vendor == $valver->nama_vendor) {
                $dg = "dengan nama : ".$request->nama_vendor;
            }
            $msg = "Data Gagal di Tambahkanh. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Vendor", $options = []);
        }

        return redirect(url('master/vendor'))
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
        $vendor = Vendor::findOrNew($id);
        $bank = Bank::all();
        $matauang = Matauang::all();
        return view('master.vendor.ubah_vendor')->with('vendor', $vendor)
                                                  ->with('bank', $bank)
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
        $valver = Vendor::where('id', '!=', $id)->where('kode', $request->kode)->orWhere('nama_vendor', $request->nama_vendor)->where('id', '!=', $id)->first();
        if ($valver == null) {
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Vendor", $options = []);
            $vendor = Vendor::findOrNew($id);
            $vendor->update([
                'kode'        => $request->kode,
                'nama_vendor' => $request->nama_vendor,
                'nama_kontak' => $request->nama_kontak,
                'alamat_1'   => $request->alamat_1,
                'alamat_2'   => $request->alamat_2,
                'phone'      => $request->phone,
                'fax'        => $request->fax,
                'bank'       => $request->bank,
                'nomor_akun' => $request->nomor_akun,
                'nama_akun'  => $request->nama_akun,
                'keterangan' => $request->keterangan
            ]);
        } else {
            if ($request->kode == $valver->kode) {
                $dg = "dengan kode : ".$request->kode;
            } else if($request->nama_vendor == $valver->nama_vendor) {
                $dg = "dengan nama : ".$request->nama_vendor;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Vendor", $options = []);
        }

//        return redirect(url('master/vendor'))
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
        $alert = Toastr::success($msg, $title = "Hapus Vendor", $options = []);
        $beli = pembelianSupplierHeader::where('id_vendor', $id)->get();
        foreach ($beli as $item) {
            $detail = pembelianSupplierDetail::where('id_header', $item->id)->get();
            foreach ($detail as $get) {
                pembelianSupplierDetail::destroy($get->id);
            }
            pembelianSupplierHeader::destroy($item->id);
        }
        Vendor::destroy($id);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }


    public function import()
    {
        return view('master.vendor.import_vendor');
    }

    public function export()
    {
        Excel::create("export_vendor", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $vendor = Vendor::all();
                foreach($vendor as $item){
                    $data=[];
                    array_push($data, array(
                        $item->kode,
                        $item->nama_vendor,
                        $item->nama_kontak,
                        $item->alamat_1,
                        $item->alamat_2,
                        $item->fax,
                        $item->bankid->kode
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('KODE','NAMA_VENDOR', 'NAMA_KONTAK', 'ALAMAT_1', 'ALAMAT_2', 'PHONE', 'FAX', 'BANK_KD'));

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
                $sheet->setWidth('C', '25');
                $sheet->setWidth('D', '25');
                $sheet->setWidth('E', '25');
                $sheet->setWidth('F', '25');
                $sheet->setWidth('G', '25');
                $sheet->setWidth('H', '25');
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
//                    $valver = Vendor::where('kode', $value->kode)->orWhere('nama_vendor', $value->nama_vendor)->first();
                    $valver = Vendor::where('kode', $value->kode)->first();
                    if ($request->konf == "cekdata") {
                        if ($valver != null) {
                            $data[] = array('kd' => $value->kode, 'nm' => $value->nama_vendor);
                        } else {
                            $w+=1;
                        }
                    } else if ($request->konf == "skip") {
                        if ($valver == null) {
                            $bank = Bank::where('kode', $value->bank_kd)->first();
                            if ($bank != null) {
                                $no++;
                                Vendor::create([
                                    'kode' => $value->kode,
                                    'nama_vendor' => $value->nama_vendor,
                                    'nama_kontak' => $value->nama_kontak,
                                    'alamat_1' => $value->alamat_1,
                                    'alamat_2' => $value->alamat_2,
                                    'phone' => $value->phone,
                                    'fax' => $value->fax,
                                    'bank' => $bank->id
                                ]);
                            }
                        }
                    } else {
                        if ($value->bank_kd != "") {
                            $bank = Bank::where('kode', $value->bank_kd)->first();
                            if ($bank == null) {
                                $bank = Bank::create(['kode' => $value->bank_kd, 'nama_bank' => $value->bank_kd]);
                            }
                            $no++;
                            $datanya = [
                                'kode' => $value->kode,
                                'nama_vendor' => $value->nama_vendor,
                                'nama_kontak' => $value->nama_kontak,
                                'alamat_1' => $value->alamat_1,
                                'alamat_2' => $value->alamat_2,
                                'phone' => $value->phone,
                                'fax' => $value->fax,
                                'bank' => $bank->id
                            ];
                            if ($valver == null) {
                                Vendor::create($datanya);
                            } else {
                                $vendor = Vendor::find($valver->id);
                                $vendor->update($datanya);
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
                        $msg = $item["kd"] . " - " . $item["nm"] . "<br>";
                        $alert = Toastr::warning($msg, $title = null, $options = []);
                    }
                }
            } else {
                $msg = "OK! <br> Import Data Berhasil. <br/>Row Inserted : " . $no;
                $alert = Toastr::success($msg, $title = "Import Vendor", $options = []);
            }
        } else {
            $msg = "ERROR <br> Import Data Gagal. Format Data Tidak Cocok";
            $alert = Toastr::error($msg, $title = "Import Vendor", $options = []);
        }
        unlink('foto/'.$filename);
        return redirect(url('master/vendor/import'))
            ->with('alert', $alert);
    }

    public function sampleimport()
    {
        Excel::create("import_vendor_sample", function($result)
        {
            $result->sheet('SheetName', function($sheet)
            {
                $sheet->fromArray(array(
                    array('V00003', 'PT.TEMPO', 'WIDODO', 'Jakarta', 'Jakarta', '081735184927', '647889', 'BCA'),
                    array('V00006', 'Pt.SPASI', 'RINKA', 'Bogor', 'Bekasi', '083746738829', '325673', 'BRI')
                ), null, 'A2', false, false);
                $sheet->row(1, array('KODE','NAMA_VENDOR', 'NAMA_KONTAK', 'ALAMAT_1', 'ALAMAT_2', 'PHONE', 'FAX', 'BANK_KD'));

                $sheet->setBorder('A1:H1', 'thin');
                $sheet->cells('A1:H1', function($cells){
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
                $sheet->setWidth('C', '25');
                $sheet->setWidth('D', '25');
                $sheet->setWidth('E', '25');
                $sheet->setWidth('F', '25');
                $sheet->setWidth('G', '25');
                $sheet->setWidth('H', '25');
            });
            return redirect(url('master/vendor/import'));
        })->download('xls');
    }

    public function _generate() {
        $nom = Nomor::where('modul', 'Master Vendor')->first();

        $last_data = $nom->nomor_now;
        $last_digit = $nom->nomor_akhir;
        $last_length = 0;
        $l = 1;

        if($last_data > 0){
            $last_digit = (int) $last_data;
            $last_length = strlen($last_digit);
            $l = 0;
        }

        if ($last_digit == 9 || $last_digit == 99 || $last_digit == 999 || $last_digit == 9999 || $last_digit == 99999) {
            $jml_digit = $nom->jumlah_digit - 1;
        } else if ($last_digit == 999999 || $last_digit == 9999999 || $last_digit == 99999999 || $last_digit == 999999999) {
            $jml_digit = $nom->jumlah_digit - 1;
        } else {
            $jml_digit = $nom->jumlah_digit;
        }

        $digit = "";
        for ($i=$l; $i < $jml_digit - $last_length; $i++) {
            $digit .= '0';
        }

        $digit .= intval($last_digit) + 1;
        $f = $this->formatnya($nom->kode, $digit, $nom->kode_awal);
        $f2 = $this->formatnya($nom->kode, $digit, $nom->kode_awal2);
        $f3 = $this->formatnya($nom->kode, $digit, $nom->kode_awal3);
        $f4 = $this->formatnya($nom->kode, $digit, $nom->kode_awal4);
        $kode = $f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        return $kode;

    }

    public function formatnya($kode, $digit, $frmt) {
        date_default_timezone_set('Asia/Jakarta');
        if ($frmt == "kode") {
            $format = $kode;
        } else if ($frmt == "digit") {
            $format = $digit;
        } else if ($frmt == "bulan") {
            $format = date('m');
        } else if ($frmt == "tahun") {
            $format = date('Y');
        } else if ($frmt == "bulantahun") {
            $format = date('mY');
        } else if ($frmt == "tahunbulan") {
            $format = date('Ym');
        } else {
            $format = "";
        }

        return $format;
    }

    public function cekaturan() {
        $nom = Nomor::where('modul', 'Master Vendor')->first();

        if($nom == null){
            $stat = "FAIL";
            $title = "Format Nomor Vendor";
            $psg = "Format nomor untuk Vendor belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
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

    public function cekaturanimport() {
        $nom2 = Bank::count();
        if($nom2 < 1){
            $stat = "FAIL";
            $title = "Bank";
            $psg = "Data Bank tidak ditemukan";
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

    public function ajax($id) {
        $bank = Bank::find($id);

        $data[] = array(
            'nama' => $bank->nama_akun,
            'nomor' => $bank->nomor_akun
        );

        return json_encode($data);
    }
}
