<?php

namespace App\Http\Controllers\Inventory\supllier;

use App\Approve;
use App\Approverole;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Http\Controllers\Controller;
use App\Model\Pengaturan\Nomor;
use App\Model\Inventory\TambahProduk;
use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Vendor;
use App\Model\Master\Cabang;
use Maatwebsite\Excel\Facades\Excel;


class PembelianController extends Controller
{
    public function index()
    {
        $header = pembelianSupplierHeader::where('tipe', 'pembelian')->where('id_cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.supllier.pembelian.index')->with('header', $header);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $header = pembelianSupplierHeader::where('id_cabang', Auth::user()->cabang)->where('tipe', 'pembelian')->where('nopembelian', 'like', '%'.$keyword.'%')->orWhere('tanggal', 'like', '%'.$keyword.'%')->orWhere('status', 'like', '%'.$keyword.'%')->orWhereHas('vendor', function($query) use ($keyword){
            $query->where('nama_vendor', 'like', '%'.$keyword.'%');
        })->orWhereHas('cabang', function($querys) use ($keyword){
            $querys->where('nama', 'like', '%'.$keyword.'%');
        })->paginate(20);
        return view('inventory.supllier.pembelian.cari')->with('header', $header)->with('keyword', $keyword);
    }

    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Pembelian Barang Vendor')->first();

        if($nom == null){
            $stat = "kosong";
        } else {
            $stat = "ada";
        }

        $data[] = array(
            'stat' => $stat
        );

        return json_encode($data);
    }

    public function create()
    {
        $produk = TambahProduk::all();
        $vendors = Vendor::all();
        $cabangs = Cabang::all();

        $kode = $this->_generate();

        $tanggal = date('Y-m-d');

        return view('inventory.supllier.pembelian.tambah')->with('produk', $produk)
                                                            ->with('kode', $kode)
                                                            ->with('tanggal', $tanggal)
                                                            ->with('vendors', $vendors)
                                                            ->with('cabangs', $cabangs);
    }

    public function detail($id)
    {
        $header = pembelianSupplierHeader::find($id);

        $detail = pembelianSupplierDetail::where('id_header', $id)->get();

        $produk = TambahProduk::all();

        return view('inventory.supllier.pembelian.detail')->with('header', $header)
                                                            ->with('detail', $detail)
                                                            ->with('produk', $produk);
    }

    public function get($search, $pilihan, $header)
    {
        $header2 = $header;

        if($pilihan=="1"){
            $produk = TambahProduk::where('barcode', $search)->get();
        } else if($pilihan=="2"){
            $produk = TambahProduk::where('nama', 'like', '%'.$search.'%')->get();
        } else if($pilihan=="3"){
            $produk = TambahProduk::all();
        }

        return view('inventory.supllier.pembelian.tableprodukjs')->with('produk', $produk)
                                                                ->with('header2', $header);
    }

    public function get2($search, $pilihan)
    {

        if($pilihan=="1"){
            $produk = TambahProduk::where('barcode', $search)->get();
        } else if($pilihan=="2"){
            $produk = TambahProduk::where('nama', 'like', '%'.$search.'%')->get();
        } else if($pilihan=="3"){
            $produk = TambahProduk::all();
        }

        return view('inventory.supllier.pembelian.tableprodukjs2')->with('produk', $produk);
    }

    public function storeheader(Request $request)
    {
        $header = new pembelianSupplierHeader;
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_vendor = $request->vendor;
//        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tanggal_kirim = $request->tanggal_kirim;
        $header->tipe = 'pembelian';
        $header->save();

        if ($request->cbpilih != null) {
            foreach ($request->cbpilih as $key => $barangid) {
                if ($request['qty' . $key] != "") {
                    $barang = TambahProduk::find($key);

                    $beli = pembelianSupplierDetail::where('id_header', $header->id)->where('id_barang', $key)->first();
                    if ($beli == null) {
                        $detail = new pembelianSupplierDetail;
                        $qtynya = $request['qty' . $key];
                    } else {
                        $detail = pembelianSupplierDetail::find($beli->id);
                        $qtynya = $request['qty' . $key] + $beli->qty;
                    }
                    $detail->id_header = $header->id;
                    $detail->id_barang = $key;
                    $detail->qty = $qtynya;
                    $detail->tanggal = date('Y-m-d');
//                    $total = $qtynya * $barang->harga_beli;
                    $total = $qtynya * $request['harga' . $key];
                    $detail->sub_total = $total;
                    $detail->save();
                }
            }
//        $header->update(['total_sub' => $header->detail->SUM('sub_total')]);
        }

        $cabid = Auth::user()->cabang;
        $cekrole = Approverole::where('for', 'waserda')->where('id_for', $cabid)->first();
        if ($cekrole != null) {

            $levv1 = \App\Approverole::where('for', 'waserda')->where('id_for', $cabid)->where('level', '1')->first();
            if ($levv1 == null) {
                $lev1 = 2;
            } else {
                $lev1 = 0;
            }

            $levv2 = \App\Approverole::where('for', 'waserda')->where('id_for', $cabid)->where('level', '2')->first();
            if ($levv2 == null) {
                $lev2 = 2;
            } else {
                $lev2 = 0;
            }

            $levv3 = \App\Approverole::where('for', 'waserda')->where('id_for', $cabid)->where('level', '3')->first();
            if ($levv3 == null) {
                $lev3 = 2;
            } else {
                $lev3 = 0;
            }

            $rell = \App\Approverole::where('for', 'waserda')->where('id_for', $cabid)->where('level', '4')->first();
            if ($rell == null) {
                $rel = 2;
            } else {
                $rel = 0;
            }

            $approve = Approve::create([
                'id_for' => $header->id,
                'for' => "waserda",
                'lev1' => $lev1,
                'lev2' => $lev2,
                'lev3' => $lev3,
                'release' => $rel
            ]);
        } else {
            $head = pembelianSupplierHeader::find($header->id);
            $head->update(['approved' => 1]);
        }

        $nom = Nomor::where('modul', 'Pembelian Barang Vendor')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('inventory/supplier/pembelian/detail/'.$header->id));
    }

    public function destroyheader($id)
    {
        pembelianSupplierHeader::destroy($id);
        pembelianSupplierDetail::where('id_header', $id)->delete();
        $approve = Approve::where('id_for', $id)->first();
        if ($approve != null) {
            Approve::destroy($approve->id);
        }

        return redirect(url('inventory/supplier/pembelian'));
    }

    public function destroydetail($id, $header)
    {
        pembelianSupplierDetail::destroy($id);

        return redirect(url('inventory/supplier/pembelian/editheader/'.$header));
    }

    public function editheader($id)
    {
        $header = pembelianSupplierHeader::find($id);

        $detail = pembelianSupplierDetail::where('id_header', $id)->get();

        $produk = TambahProduk::all();

        return view('inventory.supllier.pembelian.edit')->with('header', $header)
            ->with('detail', $detail)
            ->with('produk', $produk);
    }

    public function updateheader(Request $request, $id)
    {
        $header = pembelianSupplierHeader::find($id);
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_vendor = $request->vendor;
//        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tanggal_kirim = $request->tanggal_kirim;
        $header->tipe = 'pembelian';
        $header->save();

        return redirect(url('inventory/supplier/pembelian'));
    }

    public function storebarang(Request $request)
    {
        $kode = $request->kode2;
        $header = pembelianSupplierHeader::find($kode);
        if ($request->cbpilih != null) {
            foreach ($request->cbpilih as $key => $barangid) {
                $barang = TambahProduk::find($key);

                $beli = pembelianSupplierDetail::where('id_header', $header->id)->where('id_barang', $key)->first();
                if ($beli == null) {
                    $detail = new pembelianSupplierDetail;
                    $qtynya = $request['qty' . $key];
                } else {
                    $detail = pembelianSupplierDetail::find($beli->id);
                    $qtynya = $request['qty' . $key] + $beli->qty;
                }
                $detail->id_header = $header->id;
                $detail->id_barang = $key;
                $detail->qty = $qtynya;
                $detail->tanggal = date('Y-m-d');
                $total = $qtynya * $barang->harga_beli;
//                $total = $qtynya * $request['harga' . $key];
                $detail->sub_total = $total;
                $detail->save();
            }
//        $header->update(['total_sub' => $header->detail->SUM('sub_total')]);
        }

        return redirect(url('inventory/supplier/pembelian/editheader/'.$header->id));
    }


    public function _generate() {
        $nom = Nomor::where('modul', 'Pembelian Barang Vendor')->first();

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

    public function excelbeli($idheader) {
        date_default_timezone_set('Asia/Jakarta');
        $id= $idheader;
        Excel::create("PEMBELIAN", function($result) use ($id) {
            $result->sheet('SheetName', function($sheet) use ($id) {

                $detail = pembelianSupplierDetail::where('id_header',$id)->get();

                foreach($detail as $details){
                    $data=[];
                    array_push($data, array(
                        $details->barang->barcode,
                        $details->barang->nama,
                        $details->barang->harga_beli,
                        $details->qty,
                        $details->sub_total
                    ));
                    $sheet->fromArray($data, null, 'A2', false, false);
                }
                $sheet->row(1, array('BARCODE', 'NAMA', 'HARGA BELI', 'QUANTITY', 'SUB TOTAL', 'VERIFIKASI'));

                $sheet->setOrientation('portrait');
                $sheet->setAutoSize(true);
                $sheet->setBorder('A1:F1', 'thin');
                $sheet->cells('A1:F1', function($cells){
                    $cells->setBackground('#0070c0');
                    $cells->setFontColor('#ffffff');
                    $cells->setValignment('center');
                    $cells->setFontSize('13');
                });
                $sheet->setHeight(array(
                    '1' => '20'
                ));
                $sheet->setWidth('A', '30');
                $sheet->setWidth('B', '30');
                $sheet->setWidth('C', '20');
                $sheet->setWidth('D', '10');
                $sheet->setWidth('E', '20');
            });
            return redirect(url('inventory/supplier/pembelian'));
            })->export('xls');

    }
    
    public function porder($id) {

        $header = pembelianSupplierHeader::find($id);
        $detail = pembelianSupplierDetail::where('id_header', $id)->get();
        $pdf = PDF::loadView('inventory.supllier.pembelian.order',['header' => $header, 'detail' => $detail]);
        return $pdf->stream('PO-Pembelian.pdf');
    }
}
