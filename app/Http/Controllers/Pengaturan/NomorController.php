<?php

namespace App\Http\Controllers\Pengaturan;

use App\Model\Pengaturan\Nomor;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class NomorController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomor = DB::table('nomor')->paginate(20);
        $jml = Nomor::count();
        return view('pengaturan.nomor.daftar_nomor')->with('nomor', $nomor)->with('jml', $jml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengaturan.nomor.tambah_nomor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->modul == "customer") {
            $kdawal = "digit";
        } else {
            $kdawal = $request->frmt;
        }
        $valnomor = Nomor::where('modul', $request->modul)->first();
        if ($valnomor == null) {
            Nomor::create([
                'modul' => $request->modul,
                'kode_awal' => $kdawal,
                'kode_awal2' => $request->frmt2,
                'kode_awal3' => $request->frmt3,
                'kode_awal4' => $request->frmt4,
                'pemisah' => $request->spa,
                'pemisah2' => $request->spa2,
                'pemisah3' => $request->spa3,
                'kode' => $request->kode,
                'nomor_now' => $request->nomor_akhir,
                'jumlah_digit' => $request->jumlah_digit,
                'nomor_akhir' => $request->nomor_akhir
            ]);
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Nomor", $options = []);
        } else {
            $msg = "Data Gagal di Tambahkan<br>Data dengan modul :  ".$valnomor->modul." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Nomor", $options = []);
        }
        return redirect('pengaturan/nomor')
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
        $nomor = Nomor::findOrNew($id);
        $nomor['selected_no1'] = $nomor->modul == 'Master Customer' ? 'selected' : '';
        $nomor['selected_no10'] = $nomor->modul == 'Master Vendor' ? 'selected' : '';
        $nomor['selected_no2'] = $nomor->modul == 'Simpanan' ? 'selected' : '';
        $nomor['selected_no3'] = $nomor->modul == 'Pinjaman' ? 'selected' : '';
        $nomor['selected_no4'] = $nomor->modul == 'Kas Masuk' ? 'selected' : '';
        $nomor['selected_no5'] = $nomor->modul == 'Kas Keluar' ? 'selected' : '';
        $nomor['selected_no6'] = $nomor->modul == 'Kas Transfer' ? 'selected' : '';
        $nomor['selected_no7'] = $nomor->modul == 'Jurnal Manual' ? 'selected' : '';
        $nomor['selected_no8'] = $nomor->modul == 'Jurnal Otomatis' ? 'selected' : '';
        $nomor['selected_no9'] = $nomor->modul == 'POS' ? 'selected' : '';
        $nomor['selected_no11'] = $nomor->modul == 'Saldo Awal Akuntansi' ? 'selected' : '';
        $nomor['selected_no12'] = $nomor->modul == 'Pembelian Barang Vendor' ? 'selected' : '';
        $nomor['selected_no13'] = $nomor->modul == 'Penerimaan Barang Vendor' ? 'selected' : '';
        $nomor['selected_no14'] = $nomor->modul == 'Retur Barang Vendor' ? 'selected' : '';
        $nomor['selected_no15'] = $nomor->modul == 'Pengiriman Barang Cabang' ? 'selected' : '';
        $nomor['selected_no16'] = $nomor->modul == 'Penerimaan Barang Cabang' ? 'selected' : '';
        $nomor['selected_no17'] = $nomor->modul == 'Jurnal Transaksi POS' ? 'selected' : '';
        $nomor['selected_no18'] = $nomor->modul == 'Stock Opname' ? 'selected' : '';
        $nomor['selected_no19'] = $nomor->modul == 'Penyusutan Aset' ? 'selected' : '';
        return view('pengaturan.nomor.ubah_nomor')->with('nomor', $nomor);
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
        if ($request->modul == "customer") {
            $kdawal = "digit";
        } else {
            $kdawal = $request->frmt;
        }
        $valnomor = Nomor::where('id', '!=', $id)->where('modul', $request->modul)->first();
        if ($valnomor == null) {
            $nomor = Nomor::findOrNew($id);
            $nomor->update([
                'modul' => $request->modul,
                'kode_awal' => $kdawal,
                'kode_awal2' => $request->frmt2,
                'kode_awal3' => $request->frmt3,
                'kode_awal4' => $request->frmt4,
                'pemisah' => $request->spa,
                'pemisah2' => $request->spa2,
                'pemisah3' => $request->spa3,
                'kode' => $request->kode,
                'nomor_now' => $request->nomor_akhir,
                'jumlah_digit' => $request->jumlah_digit,
                'nomor_akhir' => $request->nomor_akhir
            ]);
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Nomor", $options = []);
        } else {
            $msg = "Data Gagal di Tambahkan<br>Data dengan modul :  ".$valnomor->modul." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Nomor", $options = []);
        }
//        return redirect('pengaturan/nomor')
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
        Nomor::destroy($id);
        $msg = "Data Berhasil di Hapus";
        $alert = Toastr::success($msg, $title = "Hapus Nomor", $options = []);
        return redirect(url()->previous())
            ->with('alert', $alert);
    }

    public function search(Request $r)
    {
      $query = $r->input('query');

        $nomor = DB::table('nomor')->where('kode','like','%'.$query.'%')->orWhere('modul','like','%'.$query.'%')->paginate(10);
        $jml = DB::table('nomor')->where('kode','like','%'.$query.'%')->orWhere('modul','like','%'.$query.'%')->count();
        return view('pengaturan.nomor.cari_nomor')->with('nomor', $nomor)->with('query', $query)->with('jml', $jml);
    }
}
