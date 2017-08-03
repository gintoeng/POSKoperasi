<?php

namespace App\Http\Controllers\Inventory\supllier;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\pengaturanAkunRelasi;
use App\Model\Master\Mappingbarang;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Pengaturan\Nomor;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Model\Inventory\TambahProduk;
use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Vendor;
use App\Model\Master\Cabang;

class ReturController extends Controller
{
    public function index()
    {
        $header = pembelianSupplierHeader::where('tipe', 'retur')->where('id_cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.supllier.retur.index')->with('header', $header);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $header = pembelianSupplierHeader::where('id_cabang', Auth::user()->cabang)->where('tipe', 'retur')->where('nopembelian', 'like', '%'.$keyword.'%')->orWhere('tanggal', 'like', '%'.$keyword.'%')->orWhere('status', 'like', '%'.$keyword.'%')->orWhereHas('cabang', function($querys) use ($keyword){
            $querys->where('nama', 'like', '%'.$keyword.'%');
        })->paginate(20);
        return view('inventory.supllier.retur.cari')->with('header', $header)->with('keyword', $keyword);
    }

    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Retur Barang Vendor')->first();
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

        if($nom == null){
            $stat = "kosong";
        } else if($nom2 == null){
            $stat = "kosong2";
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
        $cabangs = Cabang::all();

        $kode = $this->_generate();

        $tanggal = date('Y-m-d');

        return view('inventory.supllier.retur.tambah')->with('produk', $produk)
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

        return view('inventory.supllier.retur.detail')->with('header', $header)
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

        return view('inventory.supllier.retur.tableprodukjs')->with('produk', $produk)
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

        return view('inventory.supllier.retur.tableprodukjs2')->with('produk', $produk);
    }

    public function storeheader(Request $request)
    {
        $header = new pembelianSupplierHeader;
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_vendor = $request->vendor;
        $header->jenis_retur = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'retur';
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
                    $detail->keterangan = $request['ket' . $key];
                    $detail->qty = $qtynya;
                    $total = $qtynya * $barang->harga_beli;
                    $detail->sub_total = $total;
                    $detail->save();
                }
            }
        }

        $nom = Nomor::where('modul', 'Retur Barang Vendor')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('inventory/supplier/retur/editheader/'.$header->id));
    }

    public function destroyheader($id)
    {
        pembelianSupplierHeader::destroy($id);
        pembelianSupplierDetail::where('id_header', $id)->delete();


        return redirect(url('inventory/supplier/retur'));
    }

    public function destroydetail($id, $header)
    {
        pembelianSupplierDetail::destroy($id);

        return redirect(url('inventory/supplier/retur/editheader/'.$header));
    }

    public function editheader($id)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $vendors = Vendor::all();
        $cabangs = Cabang::all();

        $header = pembelianSupplierHeader::find($id);

        return view('inventory.supllier.retur.edit')->with('produk', $produk)
                                                            ->with('header', $header)
                                                            ->with('vendors', $vendors)
                                                            ->with('cabangs', $cabangs);
    }

    public function updateheader(Request $request, $id)
    {
        $header = pembelianSupplierHeader::find($id);
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_vendor = $request->vendor;
        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'retur';
        $header->save();

        return redirect(url('inventory/supplier/retur'));
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
                $detail->keterangan = $request['ket' . $key];
                $detail->qty = $qtynya;
                $total = $qtynya * $barang->harga_beli;
                $detail->sub_total = $total;
                $detail->save();
            }
        }

        return redirect(url('inventory/supplier/retur/editheader/'.$header->id));
    }


    public function _generate() {
        $nom = Nomor::where('modul', 'Retur Barang Vendor')->first();

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
        $pdf = PDF::loadView('inventory.supllier.retur.cetak',['header' => $header, 'detail' => $detail]);
        return $pdf->stream('RETUR.pdf');
    }

    public function _generatekodejurnal() {
        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();

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
        $kode = "RTRS".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
    }

    public function prosesretur($idh) {
        $belidetail = pembelianSupplierDetail::where('id_header', $idh)->get();
        $beliheader = pembelianSupplierHeader::find($idh);
        if ($beliheader->jenis_retur == "barang") {
            foreach ($belidetail as $key => $item) {
                $mapro = Mappingbarang::where('id_produk', $item->id_barang)->where('id_cabang', Auth::user()->cabang)->first();
                $mapro2 = Mappingbarang::find($mapro->id);
                $mapro2->update(['stok' => $mapro->stok - $item->qty]);

            }
        }
        $header = pembelianSupplierHeader::find($idh);
        $header->update(['start' => 1]);

        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe' => "WASERDA",
            'kode_jurnal' => $this->_generatekodejurnal(),
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Retur Produk'
        ]);
        $cabang = Cabang::find(Auth::user()->cabang);
        $harga = $beliheader->detail->sum('sub_total');

        $detail = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $cabang->akun_penampungan_retur,
            'debet' => $harga,
            'kredit' => "",
            'nominal' => $harga
        ]);

        $detail2 = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $cabang->akun_persediaan_wsd,
            'debet' => "",
            'kredit' => $harga,
            'nominal' => $harga
        ]);

        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('inventory/supplier/retur/detail/'.$idh));
    }
}
