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

class PenerimaanController extends Controller
{
    public function index()
    {
        $header = pembelianSupplierHeader::where('tipe', 'cbterima')->where('id_cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.cabang.penerimaan.index')->with('header', $header);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $header = pembelianSupplierHeader::where('id_cabang', Auth::user()->cabang)->where('tipe', 'cbterima')->where('nopembelian', 'like', '%'.$keyword.'%')->orWhere('tanggal', 'like', '%'.$keyword.'%')->orWhere('status', 'like', '%'.$keyword.'%')->paginate(20);
        return view('inventory.cabang.penerimaan.cari')->with('header', $header)->with('keyword', $keyword);
    }

    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Penerimaan Barang Cabang')->first();
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
        $pembelian = pembelianSupplierHeader::where('tipe', 'cbkirim')->where('id_terima', Auth::user()->cabang)->where('start', 0)->get();

        $kode = $this->_generate();

        $tanggal = date('Y-m-d');

        return view('inventory.cabang.penerimaan.tambah')->with('produk', $produk)
            ->with('kode', $kode)
            ->with('tanggal', $tanggal)
            ->with('vendors', $vendors)
            ->with('pembelian', $pembelian)
            ->with('cabangs', $cabangs);
    }

    public function detail($id)
    {
        $header = pembelianSupplierHeader::find($id);

        $detail = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();

        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;

        return view('inventory.cabang.penerimaan.detail')->with('header', $header)
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

        return view('inventory.cabang.penerimaan.tableprodukjs')->with('produk', $produk)
            ->with('header2', $header);
    }

    public function storeheader(Request $request)
    {
        $pembelian = pembelianSupplierHeader::find($request->pembelian);
        $pembelian->update([
            'start' => 1
        ]);

        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/invoice/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = null;
        }

        $header = new pembelianSupplierHeader;
        $header->nopembelian = $request->kode;
        $header->id_cabang = Auth::user()->cabang;
        $header->id_vendor = $pembelian->id_vendor;
        $header->status = $request->status;
        $header->id_terima = $request->pembelian;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'cbterima';
        $header->invoice = $filename;
        $header->save();

        $detailbeli = pembelianSupplierDetail::where('id_header', $pembelian->id)->get();
        foreach ($detailbeli as $item) {
            $prod = TambahProduk::find($item->id_barang);

            $mapro2 = Mappingbarang::where('id_produk', $item->id_barang)->where('id_cabang', $pembelian->id_cabang)->first();
            $stoknya = $mapro2->stok - $item->qty;
            $barangmap2 = Mappingbarang::find($mapro2->id);
            $barangmap2->update(['stok' => $stoknya]);


            $mapro = Mappingbarang::where('id_produk', $item->id_barang)->where('id_cabang', Auth::user()->cabang)->first();
            if ($mapro == null) {
                Mappingbarang::create([
                    'id_produk'     => $item->id_barang,
                    'id_cabang'     => $pembelian->id_cabang,
                    'stok'     => $item->qty,
                ]);
            } else {
                $total_stok = $mapro->stok + $item->qty;

                $barangmap = Mappingbarang::find($mapro->id);
                $barangmap->update(['stok' => $total_stok]);
            }

//            pembelianSupplierDetail::create([
//                'id_header' => $header->id,
//                'id_barang' => $item->id_barang,
//                'qty' => $item->qty,
//                'sub_total' => $item->sub_total
//            ]);
        }


        $nom = Nomor::where('modul', 'Penerimaan Barang Cabang')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('inventory/cabang/penerimaan/detail/'.$header->id));
    }

    public function destroyheader($id)
    {
        pembelianSupplierHeader::destroy($id);
        pembelianSupplierDetail::where('id_header', $id)->delete();

        return redirect(url('inventory/cabang/penerimaan'));
    }

    public function destroydetail($id, $header)
    {
        pembelianSupplierDetail::destroy($id);

        return redirect(url('inventory/cabang/penerimaan/editheader/'.$header));
    }

    public function editheader($id)
    {
        $maping = Cabang::find(Auth::user()->cabang);
        $produk = $maping->mappingproduk;
        $vendors = Vendor::all();
        $cabangs = Cabang::all();
        $pembelian = pembelianSupplierHeader::where('tipe', 'cbterima')->get();

        $header = pembelianSupplierHeader::find($id);
        $detailnya = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();

        return view('inventory.cabang.penerimaan.edit')->with('produk', $produk)
            ->with('header', $header)
            ->with('vendors', $vendors)
            ->with('pembelian', $pembelian)
            ->with('detailnya', $detailnya)
            ->with('cabangs', $cabangs);
    }

    public function updateheader(Request $request, $id)
    {
//        dd($request->foto);
        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/invoice/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = $request->inv;
        }
        $header = pembelianSupplierHeader::find($id);
        $header->nopembelian = $request->kode;
        $header->status = $request->status;
        $header->id_cabang = Auth::user()->cabang;
        $header->tanggal = $request->tanggal;
        $header->tipe = 'cbterima';
        $header->invoice = $filename;
        $header->save();

        return redirect(url('inventory/cabang/penerimaan'));
    }

    public function storebarang(Request $request)
    {
        $kode = $request->kode2;
        $header = pembelianSupplierHeader::find($kode);
        if ($request->cbpilih != null) {
            foreach ($request->cbpilih as $key => $barangid) {
                $barang = TambahProduk::find($key);

                $detail = new pembelianSupplierDetail;
                $detail->id_header = $header->id;
                $detail->id_barang = $key;
                $detail->qty = $request['qty' . $key];
                $total = $request['qty' . $key] * $barang->harga_beli;
                $detail->sub_total = $total;
                $detail->save();
            }
        }

        return redirect(url('inventory/cabang/penerimaan/detail/'.$header->id));
    }


    public function _generate() {
        $nom = Nomor::where('modul', 'Penerimaan Barang Cabang')->first();

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
        $kode = "PNGC".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
    }

    public function cetak($id) {
        $header = pembelianSupplierHeader::find($id);
        $detail = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();

        $headerawal = pembelianSupplierHeader::find($header->id_terima);
        $cbtujuan = Cabang::find($headerawal->id_cabang);

        $pdf = PDF::loadView('inventory.cabang.penerimaan.cetak',['header' => $header, 'detail' => $detail, 'cbtujuan' => $cbtujuan]);
        return $pdf->stream('Penerimaan-Cabang.pdf');
    }

    public function receive($id) {
        $penerimaan = pembelianSupplierHeader::find($id);

        $pengiriman = pembelianSupplierHeader::find($penerimaan->id_terima);
        $pengiriman->update(['receive' => 1]);

        date_default_timezone_set('Asia/Jakarta');
        $headerjurnal = JurnalHeader::create([
            'tipe' => "WASERDA",
            'kode_jurnal' => $this->_generatekodejurnal(),
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Pengiriman Produk'
        ]);
        $cabang = Cabang::find(Auth::user()->cabang);
        $harga = $pengiriman->detail->sum('sub_total');

        $detail = JurnalDetail::create([
            'id_header' => $headerjurnal->id,
            'id_akun' => $cabang->akun_persediaan_wsd,
            'debet' => $harga,
            'kredit' => "",
            'nominal' => $harga
        ]);

        $detail2 = JurnalDetail::create([
            'id_header' => $headerjurnal->id,
            'id_akun' => $cabang->akun_cabang,
            'debet' => "",
            'kredit' => $harga,
            'nominal' => $harga
        ]);

        $cabang2 = Cabang::find($pengiriman->id_cabang);
        $detail3 = JurnalDetail::create([
            'id_header' => $headerjurnal->id,
            'id_akun' => $cabang2->akun_cabang,
            'debet' => $harga,
            'kredit' => "",
            'nominal' => $harga
        ]);

        $detail4 = JurnalDetail::create([
            'id_header' => $headerjurnal->id,
            'id_akun' => $cabang2->akun_persediaan_wsd,
            'debet' => "",
            'kredit' => $harga,
            'nominal' => $harga
        ]);
        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format2 = Nomor::find($nom2->id);
        $format2->update(['nomor_now' => $nom2->nomor_now + 1]);

        return redirect(url('inventory/cabang/penerimaan'));
    }
}
