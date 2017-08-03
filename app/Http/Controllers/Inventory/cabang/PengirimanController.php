<?php

namespace App\Http\Controllers\Inventory\cabang;

use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Inventory\TambahProduk;
use App\Model\Master\Cabang;
use App\Model\Master\Vendor;
use App\Model\Pengaturan\Nomor;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    public function index()
    {
        $header = pembelianSupplierHeader::where('tipe', 'cbkirim')->where('id_cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.cabang.pengiriman.index')->with('header', $header);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $header = pembelianSupplierHeader::where('id_cabang', Auth::user()->cabang)->where('tipe', 'cbkirim')->where('nopembelian', 'like', '%'.$keyword.'%')->orWhere('tanggal', 'like', '%'.$keyword.'%')->orWhere('status', 'like', '%'.$keyword.'%')->orWhereHas('cabang', function($querys) use ($keyword){
            $querys->where('nama', 'like', '%'.$keyword.'%');
        })->paginate(20);
        return view('inventory.cabang.pengiriman.cari')->with('header', $header)->with('keyword', $keyword);
    }

    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Pengiriman Barang Cabang')->first();

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
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $vendors = Vendor::all();
        $cabangs = Cabang::where('id', '!=', Auth::user()->cabang)->get();

        $kode = $this->_generate();

        $tanggal = date('Y-m-d');
        return view('inventory.cabang.pengiriman.tambah')->with('produk', $produk)
            ->with('kode', $kode)
            ->with('tanggal', $tanggal)
            ->with('vendors', $vendors)
            ->with('cabangs', $cabangs);
    }

    public function detail($id)
    {
        $header = pembelianSupplierHeader::find($id);

        $detail = pembelianSupplierDetail::where('id_header', $id)->get();

        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;

        return view('inventory.cabang.pengiriman.detail')->with('header', $header)
            ->with('detail', $detail)
            ->with('produk', $produk);
    }

    public function get($search, $pilihan, $header)
    {
        $header2 = $header;
        $maping = Cabang::find(Auth::user()->cabang);
        if($pilihan=="1"){
            $produk = $maping->mappingproduk->where('barcode', $search);
        } else if($pilihan=="2"){
            $produk = $maping->mappingproduk->where('nama', 'like', '%'.$search.'%');
        } else if($pilihan=="3"){
            $produk = $maping->mappingproduk;
        }

        return view('inventory.cabang.pengiriman.tableprodukjs')->with('produk', $produk)
            ->with('header2', $header);
    }

    public function get2($search, $pilihan)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        if($pilihan=="1"){
            $produk = $maping->mappingproduk->where('barcode', $search);
        } else if($pilihan=="2"){
            $produk = $maping->mappingproduk->where('nama', 'like', '%'.$search.'%');
        } else if($pilihan=="3"){
            $produk = $maping->mappingproduk;
        }

        return view('inventory.cabang.pengiriman.tableprodukjs2')->with('produk', $produk);
    }

    public function storeheader(Request $request)
    {
        $header = new pembelianSupplierHeader;
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_terima = $request->cabang;
        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'cbkirim';
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
                    $total = $qtynya * $barang->harga_beli;
                    $detail->sub_total = $total;
                    $detail->save();
                }
            }
        }

        $nom = Nomor::where('modul', 'Pengiriman Barang Cabang')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('inventory/cabang/pengiriman/detail/'.$header->id));
    }

    public function destroyheader($id)
    {
        pembelianSupplierHeader::destroy($id);
        pembelianSupplierDetail::where('id_header', $id)->delete();


        return redirect(url('inventory/cabang/pengiriman'));
    }

    public function destroydetail($id, $header)
    {
        $beli = pembelianSupplierDetail::find($id);

        pembelianSupplierDetail::destroy($id);

        return redirect(url('inventory/cabang/pengiriman/editheader/'.$header));
    }

    public function editheader($id)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $vendors = Vendor::all();
        $cabangs = Cabang::all();

        $header = pembelianSupplierHeader::find($id);

        return view('inventory.cabang.pengiriman.edit')->with('produk', $produk)
            ->with('header', $header)
            ->with('vendors', $vendors)
            ->with('cabangs', $cabangs);
    }

    public function updateheader(Request $request, $id)
    {
        $header = pembelianSupplierHeader::find($id);
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_terima = $request->cabang;
        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'cbkirim';
        $header->save();

        return redirect(url('inventory/cabang/pengiriman'));
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
                $total = $qtynya * $barang->harga_beli;
                $detail->sub_total = $total;
                $detail->save();
            }
        }

        return redirect(url('inventory/cabang/pengiriman/editheader/'.$header->id));
    }


    public function _generate() {
        $nom = Nomor::where('modul', 'Pengiriman Barang cabang')->first();

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

    public function cetak($id) {
        $header = pembelianSupplierHeader::find($id);
        $detail = pembelianSupplierDetail::where('id_header', $id)->get();

        $cbtujuan = Cabang::find($header->id_terima);

        $pdf = PDF::loadView('inventory.cabang.pengiriman.cetak',['header' => $header, 'detail' => $detail, 'cbtujuan' => $cbtujuan]);
        return $pdf->stream('Pengiriman-Cabang.pdf');
    }
}
