<?php

namespace App\Http\Controllers\Inventory\supllier;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\pengaturanAkunRelasi;
use App\Model\Inventory\LapBarangMasuk;
use App\Model\Master\Mappingbarang;
use App\Model\Pos\Produk;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;

use App\Model\Pengaturan\Nomor;
use App\Model\Pos\Mstok;
use App\Model\Inventory\TambahProduk;
use App\Model\Inventory\pembelianSupplierDetail;
use App\Model\Inventory\pembelianSupplierHeader;
use App\Model\Master\Vendor;
use App\Model\Master\Cabang;
use Illuminate\Support\Facades\Auth;

class PenerimaanController extends Controller
{
    public function index()
    {
        $header = pembelianSupplierHeader::where('tipe', 'penerimaan')->where('id_cabang', Auth::user()->cabang)->paginate(20);
        return view('inventory.supllier.penerimaan.index')->with('header', $header);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $header = pembelianSupplierHeader::where('id_cabang', Auth::user()->cabang)->where('tipe', 'penerimaan')->where('nopembelian', 'like', '%'.$keyword.'%')->orWhere('tanggal', 'like', '%'.$keyword.'%')->orWhere('status', 'like', '%'.$keyword.'%')->orWhereHas('vendor', function($query) use ($keyword){
            $query->where('nama_vendor', 'like', '%'.$keyword.'%');
        })->paginate(20);
        return view('inventory.supllier.penerimaan.cari')->with('header', $header)->with('keyword', $keyword);
    }

    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Penerimaan Barang Vendor')->first();
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
        $produk = TambahProduk::all();
        $vendors = Vendor::all();
        $cabangs = Cabang::all();
        $pembelian = pembelianSupplierHeader::where('tipe', 'pembelian')->where('id_cabang', Auth::user()->cabang)->where('start', 0)->where('approved', 1)->get();

        $kode = $this->_generate();

        $tanggal = date('Y-m-d');

        return view('inventory.supllier.penerimaan.tambah')->with('produk', $produk)
                                                            ->with('kode', $kode)
                                                            ->with('tanggal', $tanggal)
                                                            ->with('vendors', $vendors)
                                                            ->with('pembelian', $pembelian)
                                                            ->with('cabangs', $cabangs);
    }

    public function detail($id)
    {
        $header = pembelianSupplierHeader::find($id);
        $sub_total = pembelianSupplierDetail::where('id_header', $header->id_terima)->sum('sub_total');
        $detail = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();

        $produk = TambahProduk::all();

        return view('inventory.supllier.penerimaan.detail')->with('header', $header)
                                                            ->with('detail', $detail)
                                                            ->with('produk', $produk)
                                                            ->with('sub_total', $sub_total);
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

        return view('inventory.supllier.penerimaan.tableprodukjs')->with('produk', $produk)
                                                                    ->with('header2', $header);
    }

    public function storeheader(Request $request)
    {
        $today = date('Y-m-d');
      
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
        $header->tipe = 'penerimaan';
        $header->invoice = $filename;
        $header->save();

        $detailbeli = pembelianSupplierDetail::where('id_header', $pembelian->id)->get();
        foreach ($detailbeli as $item) {
            $prod = TambahProduk::find($item->id_barang);
            $mstok = Mstok::where('id_produk', $item->id_barang)->where('harga_beli', $item->sub_total / $item->qty)->first();



                $mapro = Mappingbarang::where('id_produk', $item->id_barang)->where('id_cabang', Auth::user()->cabang)->first();
                if ($mapro == null) {

                    Mappingbarang::create([
                        'id_produk'     => $item->id_barang,
                        'id_cabang'     => $pembelian->id_cabang,
                        'stok'          => $item->qty
                    ]);
//
//                    Mstok::create([
//                        'id_produk'        => $item->id_barang,
//                        'stok_awal'        => $item->qty,
//                        'tanggal_expired'  => $prod->expired,
//                        'cabang'           => Auth::user()->cabang,
//                        'produk'           => $prod->nama,
//                        'harga_beli'       => $item->sub_total / $item->qty,
//                    ]);

                    $prod->update(['harga_beli' => $item->sub_total / $item->qty]);
                } else {
                    $sub = $prod->harga_beli * $mapro->stok;
                    $total_stok = $mapro->stok + $item->qty;
                    $totalnya = ($sub + $item->sub_total) / $total_stok;
                    $barangmap = Mappingbarang::find($mapro->id);
                    $barangmap->update(['stok' => $total_stok]);
                    $prod->update(['harga_beli' => $totalnya]);

//                    if($mstok==null)
//                    {
//                        Mstok::create([
//                        'id_produk'        => $item->id_barang,
//                        'stok_awal'        => $item->qty,
//                        'tanggal_expired'  => $prod->expired,
//                        'produk'           => $prod->nama,
//                        'cabang'           => Auth::user()->cabang,
//                        'harga_beli'       => $item->sub_total / $item->qty
//                        ]);
//
//                    }
//
//                    else
//                    {
//                        $mstok->update([
//                            'stok_awal' => $mstok->stok_awal + $item->qty,
//                        ]);
//
//                    }
                }

            date_default_timezone_set('Asia/Jakarta');
            $header2 = JurnalHeader::create([
                'tipe' => "WASERDA",
                'kode_jurnal' => $this->_generatekodejurnal(),
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => 'Pembelian Produk'
            ]);
            $cabang = Cabang::find(Auth::user()->cabang);
            $harga = $pembelian->detail->sum('sub_total');

            $detail = JurnalDetail::create([
                'id_header' => $header2->id,
                'id_akun' => $cabang->akun_persediaan_wsd,
                'debet' => $harga,
                'kredit' => "",
                'nominal' => $harga
            ]);

            $detail2 = JurnalDetail::create([
                'id_header' => $header2->id,
                'id_akun' => $cabang->akun_kas,
                'debet' => "",
                'kredit' => $harga,
                'nominal' => $harga
            ]);


//            pembelianSupplierDetail::create([
//
//                'id_header' => $header->id,
//                'id_barang' => $item->id_barang,
//                'qty' => $item->qty,
//                'tanggal' => $today,
//                'sub_total' => $item->sub_total
//
//            ]);


        }

        $nom = Nomor::where('modul', 'Penerimaan Barang Vendor')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format2 = Nomor::find($nom2->id);
        $format2->update(['nomor_now' => $nom2->nomor_now + 1]);

        return redirect(url('inventory/supplier/penerimaan/detail/'.$header->id));
    }

    public function destroyheader($id)
    {
        pembelianSupplierHeader::destroy($id);
        pembelianSupplierDetail::where('id_header', $id)->delete();

        return redirect(url('inventory/supplier/penerimaan'));
    }

    public function destroydetail($id, $header)
    {
        pembelianSupplierDetail::destroy($id);

        return redirect(url('inventory/supplier/penerimaan/editheader/'.$header));
    }

    public function editheader($id)
    {
        $produk = TambahProduk::all();
        $vendors = Vendor::all();
        $cabangs = Cabang::all();
        $pembelian = pembelianSupplierHeader::where('tipe', 'pembelian')->where('id_cabang', Auth::user()->cabang)->where('start', 0)->where('approved', 1)->get();

        $header = pembelianSupplierHeader::find($id);
        $detail = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();

        return view('inventory.supllier.penerimaan.edit')->with('produk', $produk)
                                                            ->with('header', $header)
                                                            ->with('detail', $detail)
                                                            ->with('vendors', $vendors)
                                                            ->with('pembelian', $pembelian)
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
        $header->tipe = 'penerimaan';
        $header->invoice = $filename;
        $header->save();

        return redirect(url('inventory/supplier/penerimaan'));
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
                $detail->tanggal = date('Y-m-d');
                $detail->qty = $request['qty' . $key];
                $total = $request['qty' . $key] * $barang->harga_beli;
                $detail->sub_total = $total;
                $detail->save();
            }
        }

        return redirect(url('inventory/supplier/penerimaan/editheader/'.$header->id));
    }


    public function _generate() {
        $nom = Nomor::where('modul', 'Penerimaan Barang Vendor')->first();

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
        $detail = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();
        $pdf = PDF::loadView('inventory.supllier.penerimaan.cetak',['header' => $header, 'detail' => $detail]);
        return $pdf->stream('Penerimaan-Supplier.pdf');
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
        $kode = "PMBS".$f."".$nom->pemisah."".$f2."".$nom->pemisah2."".$f3."".$nom->pemisah3."".$f4;

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
    }

    public function receive($id) {
        $header = pembelianSupplierHeader::find($id);
        $header->update(['receive' => 1]);
        $detailbeli = pembelianSupplierDetail::where('id_header', $header->id_terima)->get();
        $pembelian = pembelianSupplierHeader::find($header->id_terima);
        foreach ($detailbeli as $item) {
            $prod = TambahProduk::find($item->id_barang);
            $mstok = Mstok::where('id_produk', $item->id_barang)->where('harga_beli', $item->sub_total / $item->qty)->first();

            $mapro = Mappingbarang::where('id_produk', $item->id_barang)->where('id_cabang', Auth::user()->cabang)->first();
            if ($mapro == null) {

                Mappingbarang::create([
                    'id_produk'     => $item->id_barang,
                    'id_cabang'     => $pembelian->id_cabang,
                    'stok'          => $item->qty
                ]);
//
//                Mstok::create([
//                    'id_produk'     => $item->id_barang,
//                    'stok_awal'     => $item->qty,
//                    'harga_beli'    => $item->sub_total / $item->qty,
//                    'tanggal_expired' => $item->tanggal_expired
//                ]);
                $prod->update(['harga_beli' => $item->sub_total / $item->qty]);
            } else {
                $sub = $prod->harga_beli * $mapro->stok;
                $total_stok = $mapro->stok + $item->qty;
                $totalnya = ($sub + $item->sub_total) / $total_stok;
                $barangmap = Mappingbarang::find($mapro->id);
                $barangmap->update(['stok' => $total_stok]);
                $prod->update(['harga_beli' => $totalnya]);

//                if($mstok==null)
//                {
//                    Mstok::create([
//                        'id_produk'     => $item->id_barang,
//                        'stok_awal'     => $item->qty,
//                        'harga_beli'    => $item->sub_total / $item->qty,
//                        'tanggal_expired' => $item->tanggal_expired
//                    ]);
//                }
//                else
//                {
//                    $mstok->update([
//                        'stok_awal' => $mstok->stok_awal + $item->qty,
//                    ]);
//
//                }

            }

            date_default_timezone_set('Asia/Jakarta');
            $header2 = JurnalHeader::create([
                'tipe' => "WASERDA",
                'kode_jurnal' => $this->_generatekodejurnal(),
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => 'Pembelian Produk'
            ]);
            $cabang = Cabang::find(Auth::user()->cabang);
            $harga = $pembelian->detail->sum('sub_total');

            $detail = JurnalDetail::create([
                'id_header' => $header2->id,
                'id_akun' => $cabang->akun_persediaan_wsd,
                'debet' => $harga,
                'kredit' => "",
                'nominal' => $harga
            ]);

            $detail2 = JurnalDetail::create([
                'id_header' => $header2->id,
                'id_akun' => $cabang->akun_kas,
                'debet' => "",
                'kredit' => $harga,
                'nominal' => $harga
            ]);


//            pembelianSupplierDetail::create([
//
//                'id_header' => $header->id,
//                'id_barang' => $item->id_barang,
//                'qty' => $item->qty,
//                'tanggal' => $today,
//                'sub_total' => $item->sub_total
//
//            ]);


        }

        $nom2 = Nomor::where('modul', 'Jurnal Otomatis')->first();
        $format2 = Nomor::find($nom2->id);
        $format2->update(['nomor_now' => $nom2->nomor_now + 1]);

        return redirect(url()->previous());
    }
    
    public function updatedetail(Request $request, $id) {
        $header = pembelianSupplierHeader::find($id);

        $pembelian = pembelianSupplierHeader::find($header->id_terima);
        $belidetail = pembelianSupplierDetail::where('id_header', $pembelian->id)->get();

        foreach ($belidetail as $key => $item) {

            $beli = pembelianSupplierDetail::find($item->id);
            $beli->update(['tanggal_expired' => $request['tanggal' . $item->id]]);

            $expired = Mstok::where('id_produk', $item->id_barang)->where('tanggal_expired', $request['tanggal' . $item->id])->where('cabang', Auth::user()->cabang)->first();
            $maping = Cabang::find(Auth::user()->cabang);
            $produk = $maping->mappingproduk->find($item->id_barang);
//            dd($expired);

            if($expired==null)
            {
                Mstok::create([
                    'id_produk'        => $item->id_barang,
                    'stok_awal'        => $item->qty,
                    'tanggal_expired'  => $request['tanggal' . $item->id],
                    'cabang'           => Auth::user()->cabang,
                    'produk'           => $produk->nama,
                    'harga_beli'       => $item->sub_total / $item->qty,
                ]);

                LapBarangMasuk::create([
                    'barcode'        => $produk->barcode,
                    'merk'           => $produk->classification,
                    'nama'           => $produk->nama,
                    'qty'            => $item->qty,
                    'harga'          => $item->sub_total / $item->qty,
                    'expired'        => $request['tanggal' . $item->id],
                    'sub_harga'      => $item->sub_total,
                    'tanggal'        => date('Y-m-d'),
                    'cabang'         => Auth::user()->cabang,
                ]);

            }
            else
            {
                $expired->update([
                    'tanggal_expired' => $request['tanggal' . $item->id],
                    'stok_awal'        => $expired->stok_awal + $item->qty
                ]);

                LapBarangMasuk::create([
                    'barcode'        => $produk->barcode,
                    'merk'           => $produk->classification,
                    'nama'           => $produk->nama,
                    'qty'            => $item->qty,
                    'harga'          => $item->sub_total / $item->qty,
                    'expired'        => $request['tanggal' . $item->id],
                    'sub_harga'      => $item->sub_total,
                    'tanggal'        => date('Y-m-d'),
                    'cabang'         => Auth::user()->cabang,
                ]);
            }

        }

        return redirect(url('inventory/supplier/penerimaan/detail/'.$header->id));
    }
}
