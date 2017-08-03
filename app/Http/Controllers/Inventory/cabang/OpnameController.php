<?php

namespace App\Http\Controllers\Inventory\cabang;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Inventory\TambahProduk;
use App\Model\Master\Cabang;
use App\Model\Master\Mappingbarang;
use App\Model\Master\Vendor;
use App\Model\Pengaturan\Nomor;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OpnameController extends Controller
{
    public function index()
    {
        $header = pembelianSupplierHeader::where('tipe', 'opname')->where('id_cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.cabang.opname.index')->with('header', $header);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $header = pembelianSupplierHeader::where('id_cabang', Auth::user()->cabang)->where('tipe', 'opname')->where('nopembelian', 'like', '%'.$keyword.'%')->orWhere('tanggal', 'like', '%'.$keyword.'%')->orWhere('status', 'like', '%'.$keyword.'%')->orWhereHas('cabang', function($querys) use ($keyword){
            $querys->where('nama', 'like', '%'.$keyword.'%');
        })->paginate(20);
        return view('inventory.cabang.opname.cari')->with('header', $header)->with('keyword', $keyword);
    }

    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Stock Opname')->first();
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();

        if($nom == null){
            $stat = "kosong";
        } else if($nom2 == null){
            $stat = "kosong2";
        }else {
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
        return view('inventory.cabang.opname.tambah')->with('produk', $produk)
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

        return view('inventory.cabang.opname.detail')->with('header', $header)
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

        return view('inventory.cabang.opname.tableprodukjs')->with('produk', $produk)
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

        return view('inventory.cabang.opname.tableprodukjs2')->with('produk', $produk);
    }

    public function storeheader(Request $request)
    {
        $header = new pembelianSupplierHeader;
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
//        $header->id_vendor = $request->vendor;
//        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'opname';
        $header->save();

        if ($request->cbpilih != null) {
            foreach ($request->cbpilih as $key => $barangid) {
                $mapro = Mappingbarang::where('id_produk', $key)->where('id_cabang', Auth::user()->cabang)->first();
                $barang = TambahProduk::find($key);

                $detail = new pembelianSupplierDetail;
                $detail->id_header = $header->id;
                $detail->id_barang = $key;
                $detail->stok_sistem = $mapro->stok;
                $detail->qty = $mapro->stok;
                $total = $mapro->stok * $barang->harga_beli;
                $detail->sub_total = $total;
                $detail->save();

            }
        }

        $nom = Nomor::where('modul', 'Stock Opname')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('inventory/cabang/opname/editheader/'.$header->id));
    }

    public function destroyheader($id)
    {
        pembelianSupplierHeader::destroy($id);
        pembelianSupplierDetail::where('id_header', $id)->delete();


        return redirect(url('inventory/cabang/opname'));
    }

    public function destroydetail($id, $header)
    {
        pembelianSupplierDetail::destroy($id);

        return redirect(url('inventory/cabang/opname/editheader/'.$header));
    }

    public function editheader($id)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $vendors = Vendor::all();
        $cabangs = Cabang::all();

        $header = pembelianSupplierHeader::find($id);

        return view('inventory.cabang.opname.edit')->with('produk', $produk)
            ->with('header', $header)
            ->with('vendors', $vendors)
            ->with('cabangs', $cabangs);
    }

    public function opname($id)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $vendors = Vendor::all();
        $cabangs = Cabang::all();

        $header = pembelianSupplierHeader::find($id);

        return view('inventory.cabang.opname.opname')->with('produk', $produk)
            ->with('header', $header)
            ->with('vendors', $vendors)
            ->with('cabangs', $cabangs);
    }

    public function opnamehistory($id) {
        $detail = pembelianSupplierDetail::where('id_barang', $id)->whereHas('headerid', function($query) {
            $query->where('tipe', 'opname')->where('id_cabang', Auth::user()->cabang)->where('start', 1);
        })->get();

        return view('inventory.cabang.opname.historyjs')->with('detail', $detail);
    }

    public function updateheader(Request $request, $id)
    {
        $header = pembelianSupplierHeader::find($id);
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
//        $header->id_vendor = $request->vendor;
//        $header->status = $request->status;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'opname';
        $header->save();

        return redirect(url('inventory/cabang/opname'));
    }

    public function storebarang(Request $request)
    {
        $kode = $request->kode2;
        $header = pembelianSupplierHeader::find($kode);
        if ($request->cbpilih != null) {
            foreach ($request->cbpilih as $key => $barangid) {
                $mapro = Mappingbarang::where('id_produk', $key)->where('id_cabang', Auth::user()->cabang)->first();
                $barang = TambahProduk::find($key);

                $detail = new pembelianSupplierDetail;
                $detail->id_header = $header->id;
                $detail->id_barang = $key;
                $detail->stok_sistem = $mapro->stok;
                $detail->qty = $mapro->stok;
                $total = $mapro->stok * $barang->harga_beli;
                $detail->sub_total = $total;
                $detail->save();

            }
        }

        return redirect(url('inventory/cabang/opname/editheader/'.$header->id));
    }


    public function _generate() {
        $nom = Nomor::where('modul', 'Stock Opname')->first();

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
        $pdf = PDF::loadView('inventory.cabang.opname.cetak',['header' => $header, 'detail' => $detail]);
        return $pdf->stream('Stock-Opname.pdf');
    }

    public function cekbarcode($idh, $barcode) {
        $belidetail = pembelianSupplierDetail::where('id_header', $idh)->whereHas('barang', function($query) use ($barcode) {
            $query->where('barcode', $barcode);
        })->first();

        if ($belidetail == null) {
            $iddet = "NOL";
        } else {
            $iddet = $belidetail->id;
        }

        $data[] = array(
            'detid' => $iddet
        );

        return json_encode($data);
    }
    
    public function adjustment(Request $request) {
        $belidetail = pembelianSupplierDetail::where('id_header', $request->idh)->get();
        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe' => "WASERDA",
            'kode_jurnal' => $this->_generatekodejurnal(),
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Pengiriman Produk'
        ]);
        $cabang = Cabang::find(Auth::user()->cabang);
        $harga = $belidetail->sum('sub_total');

        foreach ($belidetail as $key => $item) {
            $beli = pembelianSupplierDetail::find($item->id);
            $beli->update(['stok_fisik' => $request['stoknya'.$item->id]]);

            $mapro = Mappingbarang::where('id_produk', $item->id_barang)->where('id_cabang', Auth::user()->cabang)->first();
            $mapro2 = Mappingbarang::find($mapro->id);
            if ($request['stoknya'.$item->id] < $item->stok_sistem) {
                $mapro2->update(['stok' => $request['stoknya'.$item->id]]);
                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $cabang->akun_biaya_selisih_opname,
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
            } else if ($request['stoknya'.$item->id] > $item->stok_sistem) {
                $mapro2->update(['stok' => $request['stoknya'.$item->id]]);
                $detail = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $cabang->akun_persediaan_wsd,
                    'debet' => $harga,
                    'kredit' => "",
                    'nominal' => $harga
                ]);

                $detail2 = JurnalDetail::create([
                    'id_header' => $header->id,
                    'id_akun' => $cabang->akun_pendapatan_wsd,
                    'debet' => "",
                    'kredit' => $harga,
                    'nominal' => $harga
                ]);
            } else {

            }

        }
        $header = pembelianSupplierHeader::find($request->idh);
        $header->update(['start' => 1]);

        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format2 = Nomor::find($nom2->id);
        $format2->update(['nomor_now' => $nom2->nomor_now + 1]);

        return redirect(url('inventory/cabang/opname/detail/'.$request->idh));
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
        $kode = "OPN".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
    }
}
