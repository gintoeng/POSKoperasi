<?php

namespace App\Http\Controllers\Akuntansi\jurnal;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Pengaturan\Nomor;
use App\Model\Akuntansi\JurnalHeader;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

use App\Model\Pengaturan\Profil;

use PDF;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ceknomor()
    {
        $nom = Nomor::where('modul', 'Jurnal Manual')->first();

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

    public function indexmanual()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = "";
        $kata_kunci = "";
        $posting = '0';
        $status = "index";

        $JurnalHeaderManual = JurnalHeader::where('tipe', 'MANUAL')->orderBy('id', 'DESC')->paginate(10);
        $JurnalHeaderManual2 = JurnalHeader::where('tipe', 'MANUAL')->orderBy('id', 'DESC')->get();
        $JurnalHeaderManualjml = 0;
        foreach ($JurnalHeaderManual2 as $row)
        {
            $Detail = JurnalDetail::where('id_header', $row->id)->get();
            foreach ($Detail as $row)
            {
               $JurnalHeaderManualjml++;
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_manual')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('posting', $posting)
                                                    ->with('status', $status)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderManual', $JurnalHeaderManual)
                                                     ->with('JurnalHeaderManualjml', $JurnalHeaderManualjml);
    }

    public function indexsimpanan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = "";
        $kata_kunci = "";
        $posting = '0';
        $status = "index";

        $JurnalHeaderSimpanan = JurnalHeader::where('tipe', 'TABUNGAN')->orderBy('id', 'DESC')->paginate(10);
        $JurnalHeaderSimpanan2 = JurnalHeader::where('tipe', 'TABUNGAN')->orderBy('id', 'DESC')->get();
        $JurnalHeaderSimpananjml = 0;
        foreach ($JurnalHeaderSimpanan2 as $row)
        {
            $Detail = JurnalDetail::where('id_header', $row->id)->get();
            foreach ($Detail as $row)
            {
               $JurnalHeaderSimpananjml++;
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_simpanan')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('posting', $posting)
                                                    ->with('status', $status)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderSimpanan', $JurnalHeaderSimpanan)
                                                     ->with('JurnalHeaderSimpananjml', $JurnalHeaderSimpananjml);
    }

    public function indexpinjaman()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = "";
        $kata_kunci = "";
        $posting = '0';
        $status = "index";

        $JurnalHeaderPinjaman = JurnalHeader::where('tipe', 'KREDIT')->orderBy('id', 'DESC')->paginate(10);
        $JurnalHeaderPinjaman2 = JurnalHeader::where('tipe', 'KREDIT')->orderBy('id', 'DESC')->get();
        $JurnalHeaderPinjamanjml = 0;
        foreach ($JurnalHeaderPinjaman2 as $row)
        {
            $Detail = JurnalDetail::where('id_header', $row->id)->get();
            foreach ($Detail as $row)
            {
               $JurnalHeaderPinjamanjml++;
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_pinjaman')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('posting', $posting)
                                                    ->with('status', $status)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderPinjaman', $JurnalHeaderPinjaman)
                                                     ->with('JurnalHeaderPinjamanjml', $JurnalHeaderPinjamanjml);
    }

    public function indexkas()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = "";
        $kata_kunci = "";
        $posting = '0';
        $status = "index";

        $JurnalHeaderKAS = JurnalHeader::where('tipe', 'KAS')->orderBy('id', 'DESC')->paginate(10);
        $JurnalHeaderKAS2 = JurnalHeader::where('tipe', 'KAS')->orderBy('id', 'DESC')->get();
        $JurnalHeaderKASjml = 0;
        foreach ($JurnalHeaderKAS2 as $row)
        {
            $Detail = JurnalDetail::where('id_header', $row->id)->get();
            foreach ($Detail as $row)
            {
               $JurnalHeaderKASjml++;
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_kas')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('posting', $posting)
                                                    ->with('status', $status)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderKAS', $JurnalHeaderKAS)
                                                     ->with('JurnalHeaderKASjml', $JurnalHeaderKASjml);
    }

    public function indexwaserda()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = "";
        $kata_kunci = "";
        $posting = '0';
        $status = "index";

        $JurnalHeaderKAS = JurnalHeader::where('tipe', 'WASERDA')->orderBy('id', 'DESC')->paginate(10);
        $JurnalHeaderKAS2 = JurnalHeader::where('tipe', 'WASERDA')->orderBy('id', 'DESC')->get();
        $JurnalHeaderKASjml = 0;
        foreach ($JurnalHeaderKAS2 as $row)
        {
            $Detail = JurnalDetail::where('id_header', $row->id)->get();
            foreach ($Detail as $row)
            {
               $JurnalHeaderKASjml++;
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_waserda')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('posting', $posting)
                                                    ->with('status', $status)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderKAS', $JurnalHeaderKAS)
                                                     ->with('JurnalHeaderKASjml', $JurnalHeaderKASjml);
    }

    public function indexsemua()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = "";
        $kata_kunci = "";
        $posting = '0';
        $status = "index";

        $JurnalHeaderAll = JurnalHeader::orderBy('id', 'DESC')->paginate(10);
        $JurnalHeaderAll2 = JurnalHeader::orderBy('id', 'DESC')->get();
        $JurnalHeaderAlljml = 0;
        foreach ($JurnalHeaderAll2 as $row)
        {
            $Detail = JurnalDetail::where('id_header', $row->id)->get();
            foreach ($Detail as $row)
            {
               $JurnalHeaderAlljml++;
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_semua')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('posting', $posting)
                                                    ->with('status', $status)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderAll', $JurnalHeaderAll)
                                                     ->with('JurnalHeaderAlljml', $JurnalHeaderAlljml);
    }

    public function searchmanual(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = $request->datefrom;
        $date2 = $request->dateto;
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = $request->akun_perkiraan;
        $kata_kunci = $request->kata_kunci;
        $posting = $request->posting;
        $status = "cari";

        $JurnalHeaderManual = JurnalHeader::where('tipe', 'MANUAL')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->paginate(10);

        $JurnalHeaderManual2 = JurnalHeader::where('tipe', 'MANUAL')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
        $JurnalHeaderManualjml = 0;
        foreach ($JurnalHeaderManual2 as $row)
        {
            if($akun_perkiraan=="semua"){
                $Detail = JurnalDetail::where('id_header', $row->id)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderManualjml++;
                }
            } else {
                $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderManualjml++;
                }
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_manual')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('status', $status)
                                                    ->with('posting', $posting)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderManual', $JurnalHeaderManual)
                                                     ->with('JurnalHeaderManualjml', $JurnalHeaderManualjml);
    }

    public function searchsimpanan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = $request->datefrom;
        $date2 = $request->dateto;
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = $request->akun_perkiraan;
        $kata_kunci = $request->kata_kunci;
        $posting = $request->posting;
        $status = "cari";

        $JurnalHeaderSimpanan = JurnalHeader::where('tipe', 'TABUNGAN')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->paginate(10);

        $JurnalHeaderSimpanan2 = JurnalHeader::where('tipe', 'TABUNGAN')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
        $JurnalHeaderSimpananjml = 0;
        foreach ($JurnalHeaderSimpanan2 as $row)
        {
            if($akun_perkiraan=="semua"){
                $Detail = JurnalDetail::where('id_header', $row->id)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderSimpananjml++;
                }
            } else {
                $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderSimpananjml++;
                }
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_simpanan')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('status', $status)
                                                    ->with('posting', $posting)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderSimpanan', $JurnalHeaderSimpanan)
                                                     ->with('JurnalHeaderSimpananjml', $JurnalHeaderSimpananjml);
    }

    public function searchpinjaman(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = $request->datefrom;
        $date2 = $request->dateto;
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = $request->akun_perkiraan;
        $kata_kunci = $request->kata_kunci;
        $posting = $request->posting;
        $status = "cari";

        $JurnalHeaderPinjaman = JurnalHeader::where('tipe', 'KREDIT')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->paginate(10);

        $JurnalHeaderPinjaman2 = JurnalHeader::where('tipe', 'KREDIT')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
        $JurnalHeaderPinjamanjml = 0;
        foreach ($JurnalHeaderPinjaman2 as $row)
        {
            if($akun_perkiraan=="semua"){
                $Detail = JurnalDetail::where('id_header', $row->id)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderPinjamanjml++;
                }
            } else {
                $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderPinjamanjml++;
                }
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_pinjaman')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('status', $status)
                                                    ->with('posting', $posting)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderPinjaman', $JurnalHeaderPinjaman)
                                                     ->with('JurnalHeaderPinjamanjml', $JurnalHeaderPinjamanjml);
    }

    public function searchkas(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = $request->datefrom;
        $date2 = $request->dateto;
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = $request->akun_perkiraan;
        $kata_kunci = $request->kata_kunci;
        $posting = $request->posting;
        $status = "cari";

        $JurnalHeaderKAS = JurnalHeader::where('tipe', 'KAS')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->paginate(10);

        $JurnalHeaderKAS2 = JurnalHeader::where('tipe', 'KAS')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
        $JurnalHeaderKASjml = 0;
        foreach ($JurnalHeaderKAS2 as $row)
        {
            if($akun_perkiraan=="semua"){
                $Detail = JurnalDetail::where('id_header', $row->id)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderKASjml++;
                }
            } else {
                $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderKASjml++;
                }
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_kas')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('status', $status)
                                                    ->with('posting', $posting)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderKAS', $JurnalHeaderKAS)
                                                     ->with('JurnalHeaderKASjml', $JurnalHeaderKASjml);
    }

    public function searchwaserda(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = $request->datefrom;
        $date2 = $request->dateto;
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = $request->akun_perkiraan;
        $kata_kunci = $request->kata_kunci;
        $posting = $request->posting;
        $status = "cari";

        $JurnalHeaderKAS = JurnalHeader::where('tipe', 'WASERDA')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->paginate(10);

        $JurnalHeaderKAS2 = JurnalHeader::where('tipe', 'WASERDA')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
        $JurnalHeaderKASjml = 0;
        foreach ($JurnalHeaderKAS2 as $row)
        {
            if($akun_perkiraan=="semua"){
                $Detail = JurnalDetail::where('id_header', $row->id)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderKASjml++;
                }
            } else {
                $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderKASjml++;
                }
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_waserda')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('status', $status)
                                                    ->with('posting', $posting)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderKAS', $JurnalHeaderKAS)
                                                     ->with('JurnalHeaderKASjml', $JurnalHeaderKASjml);
    }

    public function searchsemua(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = $request->datefrom;
        $date2 = $request->dateto;
        $akun = Perkiraan::where('tipe_akun', 'detail')->get();
        $akun_perkiraan = $request->akun_perkiraan;
        $kata_kunci = $request->kata_kunci;
        $posting = $request->posting;
        $status = "cari";

        $JurnalHeaderAll = JurnalHeader::Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->paginate(10);

        $JurnalHeaderAll2 = JurnalHeader::Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
        $JurnalHeaderAlljml = 0;
        foreach ($JurnalHeaderAll2 as $row)
        {
            if($akun_perkiraan=="semua"){
                $Detail = JurnalDetail::where('id_header', $row->id)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderAlljml++;
                }
            } else {
                $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
                foreach ($Detail as $row)
                {
                   $JurnalHeaderAlljml++;
                }
            }
        }

        return view('Akuntansi.jurnal.jurnal_index_semua')->with('date1', $date1)
                                                    ->with('date2', $date2)
                                                    ->with('akun', $akun)
                                                    ->with('status', $status)
                                                    ->with('posting', $posting)
                                                    ->with('kata_kunci', $kata_kunci)
                                                    ->with('akun_perkiraan', $akun_perkiraan)
                                                     ->with('JurnalHeaderAll', $JurnalHeaderAll)
                                                     ->with('JurnalHeaderAlljml', $JurnalHeaderAlljml);
    }

    // public function index()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $date1 = date('Y-m-d');
    //     $date2 = date('Y-m-d');
    //     $akun = Perkiraan::where('tipe_akun', 'detail')->get();
    //     $akun_perkiraan = "";
    //     $kata_kunci = "";
    //     $posting = '0';
    //
    //     $JurnalHeaderManual = JurnalHeader::where('tipe', 'MANUAL')->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderManualjml = 0;
    //     foreach ($JurnalHeaderManual as $row)
    //     {
    //         $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //         foreach ($Detail as $row)
    //         {
    //            $JurnalHeaderManualjml++;
    //         }
    //     }
    //
    //     $JurnalHeaderTabungan = JurnalHeader::where('tipe', 'TABUNGAN')->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderTabunganjml = 0;
    //     foreach ($JurnalHeaderTabungan as $row)
    //     {
    //         $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //         foreach ($Detail as $row)
    //         {
    //            $JurnalHeaderTabunganjml++;
    //         }
    //     }
    //
    //     $JurnalHeaderKas = JurnalHeader::where('tipe', 'KAS')->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderKasjml = 0;
    //     foreach ($JurnalHeaderKas as $row)
    //     {
    //         $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //         foreach ($Detail as $row)
    //         {
    //            $JurnalHeaderKasjml++;
    //         }
    //     }
    //
    //     $JurnalHeaderDeposito = JurnalHeader::where('tipe', 'DEPOSITO')->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderDepositojml = 0;
    //     foreach ($JurnalHeaderDeposito as $row)
    //     {
    //         $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //         foreach ($Detail as $row)
    //         {
    //            $JurnalHeaderDepositojml++;
    //         }
    //     }
    //
    //     $JurnalHeaderKredit = JurnalHeader::where('tipe', 'KREDIT')->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderKreditjml = 0;
    //     foreach ($JurnalHeaderKredit as $row)
    //     {
    //         $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //         foreach ($Detail as $row)
    //         {
    //            $JurnalHeaderKreditjml++;
    //         }
    //     }
    //
    //     $JurnalHeaderAll = JurnalHeader::orderBy('id', 'DESC')->get();
    //     $JurnalHeaderAlljml = 0;
    //     foreach ($JurnalHeaderAll as $row)
    //     {
    //         $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //         foreach ($Detail as $row)
    //         {
    //            $JurnalHeaderAlljml++;
    //         }
    //     }
    //
    //     return view('Akuntansi.jurnal.jurnal_index')->with('date1', $date1)
    //                                                 ->with('date2', $date2)
    //                                                 ->with('akun', $akun)
    //                                                 ->with('posting', $posting)
    //                                                 ->with('kata_kunci', $kata_kunci)
    //                                                 ->with('akun_perkiraan', $akun_perkiraan)
    //                                                  ->with('JurnalHeaderManual', $JurnalHeaderManual)
    //                                                  ->with('JurnalHeaderManualjml', $JurnalHeaderManualjml)
    //                                                  ->with('JurnalHeaderTabungan', $JurnalHeaderTabungan)
    //                                                  ->with('JurnalHeaderTabunganjml', $JurnalHeaderTabunganjml)
    //                                                  ->with('JurnalHeaderKas', $JurnalHeaderKas)
    //                                                  ->with('JurnalHeaderKasjml', $JurnalHeaderKasjml)
    //                                                  ->with('JurnalHeaderDeposito', $JurnalHeaderDeposito)
    //                                                  ->with('JurnalHeaderDepositojml', $JurnalHeaderDepositojml)
    //                                                  ->with('JurnalHeaderKredit', $JurnalHeaderKredit)
    //                                                  ->with('JurnalHeaderKreditjml', $JurnalHeaderKreditjml)
    //                                                  ->with('JurnalHeaderAll', $JurnalHeaderAll)
    //                                                  ->with('JurnalHeaderAlljml', $JurnalHeaderAlljml);
    // }


    // public function search(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $date1 = $request->datefrom;
    //     $date2 = $request->dateto;
    //     $akun = Perkiraan::where('tipe_akun', 'detail')->get();
    //     $akun_perkiraan = $request->akun_perkiraan;
    //     $kata_kunci = $request->kata_kunci;
    //     $posting = $request->posting;
    //
    //     $JurnalHeaderManual = JurnalHeader::where('tipe', 'MANUAL')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderManualjml = 0;
    //     foreach ($JurnalHeaderManual as $row)
    //     {
    //         if($akun_perkiraan=="semua"){
    //             $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderManualjml++;
    //             }
    //         } else {
    //             $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderManualjml++;
    //             }
    //         }
    //     }
    //
    //     $JurnalHeaderTabungan = JurnalHeader::where('tipe', 'TABUNGAN')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderTabunganjml = 0;
    //     foreach ($JurnalHeaderTabungan as $row)
    //     {
    //         if($akun_perkiraan=="semua"){
    //             $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderTabunganjml++;
    //             }
    //         } else {
    //             $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderTabunganjml++;
    //             }
    //         }
    //     }
    //
    //     $JurnalHeaderKas = JurnalHeader::where('tipe', 'KAS')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderKasjml = 0;
    //     foreach ($JurnalHeaderKas as $row)
    //     {
    //         if($akun_perkiraan=="semua"){
    //             $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderKasjml++;
    //             }
    //         } else {
    //             $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderKasjml++;
    //             }
    //         }
    //     }
    //
    //     $JurnalHeaderDeposito = JurnalHeader::where('tipe', 'DEPOSITO')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderDepositojml = 0;
    //     foreach ($JurnalHeaderDeposito as $row)
    //     {
    //         if($akun_perkiraan=="semua"){
    //             $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderDepositojml++;
    //             }
    //         } else {
    //             $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderDepositojml++;
    //             }
    //         }
    //     }
    //
    //     $JurnalHeaderKredit = JurnalHeader::where('tipe', 'KREDIT')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderKreditjml = 0;
    //     foreach ($JurnalHeaderKredit as $row)
    //     {
    //         if($akun_perkiraan=="semua"){
    //             $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderKreditjml++;
    //             }
    //         } else {
    //             $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderKreditjml++;
    //             }
    //         }
    //     }
    //
    //     $JurnalHeaderAll = JurnalHeader::Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $date1." 00:00:00")->Where('tanggal', '<=', $date2." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
    //     $JurnalHeaderAlljml = 0;
    //     foreach ($JurnalHeaderAll as $row)
    //     {
    //         if($akun_perkiraan=="semua"){
    //             $Detail = JurnalDetail::where('id_header', $row->id)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderAlljml++;
    //             }
    //         } else {
    //             $Detail = JurnalDetail::where('id_header', $row->id)->Where('id_akun', $akun_perkiraan)->get();
    //             foreach ($Detail as $row)
    //             {
    //                $JurnalHeaderAlljml++;
    //             }
    //         }
    //     }
    //
    //     return view('Akuntansi.jurnal.jurnal_index')->with('date1', $date1)
    //                                                 ->with('date2', $date2)
    //                                                 ->with('akun', $akun)
    //                                                 ->with('posting', $posting)
    //                                                 ->with('kata_kunci', $kata_kunci)
    //                                                 ->with('akun_perkiraan', $akun_perkiraan)
    //                                                  ->with('JurnalHeaderManual', $JurnalHeaderManual)
    //                                                  ->with('JurnalHeaderManualjml', $JurnalHeaderManualjml)
    //                                                  ->with('JurnalHeaderTabungan', $JurnalHeaderTabungan)
    //                                                  ->with('JurnalHeaderTabunganjml', $JurnalHeaderTabunganjml)
    //                                                  ->with('JurnalHeaderKas', $JurnalHeaderKas)
    //                                                  ->with('JurnalHeaderKasjml', $JurnalHeaderKasjml)
    //                                                  ->with('JurnalHeaderDeposito', $JurnalHeaderDeposito)
    //                                                  ->with('JurnalHeaderDepositojml', $JurnalHeaderDepositojml)
    //                                                  ->with('JurnalHeaderKredit', $JurnalHeaderKredit)
    //                                                  ->with('JurnalHeaderKreditjml', $JurnalHeaderKreditjml)
    //                                                  ->with('JurnalHeaderAll', $JurnalHeaderAll)
    //                                                  ->with('JurnalHeaderAlljml', $JurnalHeaderAlljml);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function cetak($tipe, $status, Request $request)
    {
        $profil = Profil::findOrNew('1');
        $i = 1;
        $tipejurnal = $tipe;
        $akun_perkiraan = $request->akun_perkiraan;

        $JurnalHeader = "";
        if($tipejurnal=="Manual"){
            if($status =="cari"){
                $JurnalHeader = JurnalHeader::where('tipe', 'MANUAL')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $request->datefrom." 00:00:00")->Where('tanggal', '<=', $request->dateto." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
            } else if($status =="index")
            {
                $JurnalHeader = JurnalHeader::where('tipe', 'MANUAL')->orderBy('id', 'DESC')->get();
                $akun_perkiraan = "semua";
            }
        } else if($tipejurnal=="Simpanan"){
            if($status =="cari"){
                $JurnalHeader = JurnalHeader::where('tipe', 'TABUNGAN')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $request->datefrom." 00:00:00")->Where('tanggal', '<=', $request->dateto." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
            } else if($status =="index")
            {
                $JurnalHeader = JurnalHeader::where('tipe', 'TABUNGAN')->orderBy('id', 'DESC')->get();
                $akun_perkiraan = "semua";
            }
        } else if($tipejurnal=="Pinjaman"){
            if($status =="cari"){
                $JurnalHeader = JurnalHeader::where('tipe', 'KREDIT')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $request->datefrom." 00:00:00")->Where('tanggal', '<=', $request->dateto." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
            } else if($status =="index")
            {
                $JurnalHeader = JurnalHeader::where('tipe', 'KREDIT')->orderBy('id', 'DESC')->get();
                $akun_perkiraan = "semua";
//                dd($JurnalHeader);
            }
        } else if($tipejurnal=="Kas"){
            if($status =="cari"){
                $JurnalHeader = JurnalHeader::where('tipe', 'KAS')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $request->datefrom." 00:00:00")->Where('tanggal', '<=', $request->dateto." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
            } else if($status =="index")
            {
                $JurnalHeader = JurnalHeader::where('tipe', 'KAS')->orderBy('id', 'DESC')->get();
                $akun_perkiraan = "semua";
            }
        }else if($tipejurnal=="Waserda"){
            if($status =="cari"){
                $JurnalHeader = JurnalHeader::where('tipe', 'WASERDA')->Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $request->datefrom." 00:00:00")->Where('tanggal', '<=', $request->dateto." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
            } else if($status =="index")
            {
                $JurnalHeader = JurnalHeader::where('tipe', 'WASERDA')->orderBy('id', 'DESC')->get();
                $akun_perkiraan = "semua";
            }
        } else {
            if($status =="cari"){
                $JurnalHeader = JurnalHeader::Where('kode_jurnal', 'like', '%'.$request->kata_kunci.'%')->Where('tanggal', '>=', $request->datefrom." 00:00:00")->Where('tanggal', '<=', $request->dateto." 23:59:00")->Where('posting', $request->posting)->orderBy('id', 'DESC')->get();
            } else if($status =="index")
            {
                $JurnalHeader = JurnalHeader::orderBy('id', 'DESC')->get();
                $akun_perkiraan = "semua";
            }
        }

        $pdf = PDF::loadView('Akuntansi.jurnal.jurnal_cetak', ['profil' => $profil, 'tipe' => $tipejurnal, 'JurnalHeader' => $JurnalHeader, 'akun_perkiraan' => $akun_perkiraan]);
        $customPaper = array(0,0,950,950);
        return $pdf->setPaper($customPaper, 'landscape')->stream('Cetak-Jurnal.pdf');
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $kode = $this->_generate();

        $Perkiraan = Perkiraan::where('tipe_akun', 'detail')->get();

        return view('Akuntansi.jurnal.tambah_jurnal')->with('date', $date)
                                                     ->with('perkiraan', $Perkiraan)
                                                     ->with('kode', $kode);
    }

    public function store(Request $request)
    {

        $msg = "Berhasil! <br> Anda berhasil menambahkan data Jurnal Manul";
        $alert = Toastr::success($msg, $title = "Tambah Data Jurnal Manual", $options = []);

        $header = new JurnalHeader;

        $header->tipe = 'MANUAL';
        $header->kode_jurnal = $request->kode;
        $header->tanggal = $request->tanggal;
        $header->keterangan = $request->keterangan;
        $header->save();
        $idheader = $header->id;

            for ($i=0; $i < count($request['debet']); $i++) {

                $nominal = '0';
                if(str_replace(',', '', $request['debet'][$i])==0)
                {
                    $nominal = str_replace(',', '', $request['kredit'][$i]);
                } else {
                    $nominal = str_replace(',', '', $request['debet'][$i]);
                }

                $detail = new JurnalDetail;
                $detail->id_header = $idheader;
                $detail->id_akun = $request['akun'][$i];
                $detail->debet = str_replace(',', '', $request['debet'][$i]);
                $detail->kredit = str_replace(',', '', $request['kredit'][$i]);
                $detail->nominal = $nominal;

                $detail->save();
            }

        $nom = Nomor::where('modul', 'Jurnal Manual')->first();
        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return redirect(url('akuntansi/jurnal'))
            ->with('alert', $alert);

    }

    public function posting(Request $request)
    {
        if(count($request->cbpilih)>0){
        foreach ($request->cbpilih as $kodejurnal  => $siswaid) {
                $jurnalheader = JurnalHeader::find($kodejurnal);
                $jurnalheader->posting = '1';
                $jurnalheader->save();

                $jurnaldetail = jurnaldetail::where('id_header', $kodejurnal)->get();
                foreach ($jurnaldetail as $row) {
                    $jdetail = jurnaldetail::find($row->id);
                    $jdetail->posting = '1';
                    $jdetail->save();
                }
			}
            $msg = "Berhasil! <br> Data Jurnal Terpilih telah berhasil diposting ke Buku Besar";
            $alert = Toastr::success($msg, $title = "Posting Data Jurnal", $options = []);

            return redirect(url('akuntansi/jurnal/semua'))
            ->with('alert', $alert);
        } else if(count($request->cbpilih)<=0){
            $msg = "Gagal! <br> Tidak ada data jurnal yang ingin di posting";
            $alert = Toastr::error($msg, $title = "Posting Data Jurnal", $options = []);

            return redirect(url('akuntansi/jurnal/semua'))
            ->with('alert', $alert);
        }


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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function _generate() {
        $nom = Nomor::where('modul', 'Jurnal Manual')->first();

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

}
