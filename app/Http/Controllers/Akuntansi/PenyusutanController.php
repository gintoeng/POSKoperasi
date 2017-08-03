<?php

namespace App\Http\Controllers\Akuntansi;

use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Penyusutanaset;
use App\Model\Akuntansi\Penyusutandetail;
use App\Model\Akuntansi\Perkiraan;
use App\Model\Pengaturan\Nomor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class PenyusutanController extends Controller
{
    public function index() {
        $aset = Penyusutanaset::paginate(20);
        $jml = Penyusutanaset::count();
        return view('Akuntansi.penyusutan.daftar_aset')->with('aset', $aset)->with('jml', $jml);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $aset = Penyusutanaset::where('kode_aset', 'like', '%'.$query.'$')->orWhere('nama_aset', 'like', '%'.$query.'$')->orWhere('nominal_harga', 'like', '%'.$query.'$')->orWhere('penyusutan', 'like', '%'.$query.'$')->orWhere('bulan', 'like', '%'.$query.'$')->paginate(20);
        $jml = Penyusutanaset::where('kode_aset', 'like', '%'.$query.'$')->orWhere('nama_aset', 'like', '%'.$query.'$')->orWhere('nominal_harga', 'like', '%'.$query.'$')->orWhere('penyusutan', 'like', '%'.$query.'$')->orWhere('bulan', 'like', '%'.$query.'$')->count();
        return view('Akuntansi.penyusutan.cari_aset')->with('aset', $aset)->with('jml', $jml)->with('query', $query);
    }

    public function create() {
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        return view('Akuntansi.penyusutan.tambah_aset')->with('perkiraan', $perkiraan);
    }

    public function store(Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $hnominal = str_replace(",","",$request->harga);
        $hn = str_replace(".00","",$hnominal);

        $hpenyusutan = str_replace(",","",$request->penyusutan);
        $hp = str_replace(".00","",$hpenyusutan);

        $valaset = Penyusutanaset::where('kode_aset', $request->kode)->first();
        if ($valaset == null) {
            $penyusutan = Penyusutanaset::create([
                'kode_aset'     => $request->kode,
                'nama_aset'     => $request->nama,
                'nominal_harga' => $hn,
                'penyusutan'    => $hp,
                'bulan'         => $request->bulan_penyusutan,
                'status'        => 0,
                'akun_kas'      => $request->akun_kas,
                'akun_aset'     => $request->akun_aset,
                'akun_biaya_penyusutan'     => $request->akun_biaya,
                'akun_akumulasi_penyusutan' => $request->akun_akumulasi,
                'akun_keuntungan_aset'      => $request->akun_keuntungan,
                'akun_kerugian_aset'        => $request->akun_kerugian
            ]);

            $sisa = $hn;
            for ($i=1; $i<=$request->bulan_penyusutan; $i++) {
                $tglnya = strtotime('+'.$i.' month', strtotime($today));
                $sisanya = $sisa - $hp;
                Penyusutandetail::create([
                    'id_penyusutan' => $penyusutan->id,
                    'bulan_ke' => $i,
                    'penyusutan' => $hp,
                    'sisa' => $sisanya,
                    'stat' => 0,
                    'tanggal'  => date("Y-m-t",$tglnya)
                ]);
                $sisa = $sisanya;
            }

            date_default_timezone_set('Asia/Jakarta');
            $header = JurnalHeader::create([
                'tipe' => "ASET",
                'kode_jurnal' => "BAST".$this->_generatekodejurnal(),
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => 'Penyusutan Aset'
            ]);

            $detail = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $penyusutan->akun_aset,
                'debet' => $hn,
                'kredit' => "",
                'nominal' => $hn
            ]);

            $detail2 = JurnalDetail::create([
                'id_header' => $header->id,
                'id_akun' => $penyusutan->akun_kas,
                'debet' => "",
                'kredit' => $hn,
                'nominal' => $hn
            ]);

            $nom = Nomor::where('modul', 'Penyusutan Aset')->first();
            $format = Nomor::find($nom->id);
            $format->update(['nomor_now' => $nom->nomor_now + 1]);

            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah Aset", $options = []);
        } else {
            if ($request->kode == $valaset->kode_aset) {
                $dg = "dengan kode : ".$request->kode;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah Aset", $options = []);
        }
        
        return redirect(url('akuntansi/penyusutan'))->with('alert', $alert);
    }

    public function edit($id) {
        $aset = Penyusutanaset::find($id);
        $perkiraan = Perkiraan::where('tipe_akun', 'detail')->orderBy('kode_akun', 'ASC')->get();
        return view('Akuntansi.penyusutan.ubah_aset')->with('perkiraan', $perkiraan)->with('aset', $aset);
    }
    
    public function update(Request $request, $id) {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $hnominal = str_replace(",","",$request->harga);
        $hn = str_replace(".00","",$hnominal);

        $hpenyusutan = str_replace(",","",$request->penyusutan);
        $hp = str_replace(".00","",$hpenyusutan);

        $valaset = Penyusutanaset::where('id', '!=', $id)->where('kode_aset', $request->kode)->first();
        if ($valaset == null) {
            $penyusutan = Penyusutanaset::find($id);
            $penyusutan->update([
                'kode_aset'     => $request->kode,
                'nama_aset'     => $request->nama,
                'nominal_harga' => $hn,
                'penyusutan'    => $hp,
                'bulan'         => $request->bulan_penyusutan,
                'status'        => 0,
                'akun_kas'      => $request->akun_kas,
                'akun_aset'     => $request->akun_aset,
                'akun_biaya_penyusutan'     => $request->akun_biaya,
                'akun_akumulasi_penyusutan' => $request->akun_akumulasi,
                'akun_keuntungan_aset'      => $request->akun_keuntungan,
                'akun_kerugian_aset'        => $request->akun_kerugian
            ]);
            
            $hapusdetail = Penyusutandetail::where('id_penyusutan', $id)->get();
            foreach ($hapusdetail as $get) {
                Penyusutandetail::destroy($get->id);
            }

            $sisa = $hn;
            for ($i=1; $i<=$request->bulan_penyusutan; $i++) {
                $tglnya = strtotime('+'.$i.' month', strtotime($today));
                $sisanya = $sisa - $hp;
                Penyusutandetail::create([
                    'id_penyusutan' => $penyusutan->id,
                    'bulan_ke' => $i,
                    'penyusutan' => $hp,
                    'sisa' => $sisanya,
                    'stat' => 0,
                    'tanggal'  => date("Y-m-t",$tglnya)
                ]);
                $sisa = $sisanya;
            }
            
            $msg = "Data Berhasil di Ubah";
            $alert = Toastr::success($msg, $title = "Ubah Aset", $options = []);
        } else {
            if ($request->kode == $valaset->kode_aset) {
                $dg = "dengan kode : ".$request->kode;
            }
            $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Ubah Aset", $options = []);
        }

        return redirect($request->urlnya)->with('alert', $alert);
    }

    public function destroy($id) {
        Penyusutanaset::destroy($id);

        return redirect(url()->previous());
    }

    public function ajax($bln, $harga) {
        $hnominal = str_replace(",","",$harga);
        $hn = str_replace(".00","",$hnominal);

        $susut = $hn / $bln;

        $data[] = array(
            'susut' => number_format($susut, 2, '.', ',')
        );

        return json_encode($data);
    }

    public function show($id) {
        $penyusutan = Penyusutanaset::find($id);
        $susut = $penyusutan->detailid->where('stat', 1)->sum('penyusutan');
        $data[] = array(
            'stat' => $penyusutan->status,
            'aset' => $penyusutan->nama_aset,
            'nominal' => number_format($penyusutan->nominal_harga, 0, '.', ','),
            'susut' => number_format($susut, 0, '.', ','),
            'sisa' => $penyusutan->nominal_harga - $susut
        );

        return json_encode($data);
    }

    public function showtable($id) {
        $penyusutan = Penyusutanaset::find($id);
        $i = 1;
        echo    '<table id="tabsusut" class="table table-bordered table-striped no-m scroll" >';
        echo    '<thead>';
        echo    '<tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">';
        echo    '<th class="text-center" width="50">No.</th>';
        echo    '<th class="text-center" width="70">Bulan</th>';
        echo    '<th class="text-center">Penyusutan</th>';
        echo    '<th class="text-center">Sisa</th>';
        echo    '</tr>';
        echo    '</thead>';
        echo    '<tbody id="bodysusut" style="overflow-y: scroll;height: 350px;width: auto;position: absolute;">';
        foreach ($penyusutan->detailid->where('stat', 1) as $item) {
            echo '<tr style="width: 100%;display: inline-table;table-layout: fixed;">';
            echo '<td class="text-center" width="50">'.$i++.'</td>';
            echo '<td class="text-center" width="70">'.$item->bulan_ke.'</td>';
            echo '<td class="text-right">'.number_format($item->penyusutan,2,'.',',').'</td>';
            echo '<td class="text-right">'.number_format($item->sisa,2,'.',',').'</td>';
            echo '</tr>';
        }
        echo    '</tbody>';
        echo    '</table>';
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
        $nom = Nomor::where('modul', 'Penyusutan Aset')->first();

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

        $format = Nomor::find($nom->id);
        $format->update(['nomor_now' => $nom->nomor_now + 1]);

        return $kode;
    }

    public function cekjurnal() {
        $nom = Nomor::where('modul', 'Jurnal Otomatis')->first();

        if($nom == null){
            $stat = "FAIL";
            $title = "Format Nomor Jurnal Otomatis";
            $psg = "Format nomor untuk Jurnal Otomatis belum disetting <a href=".url('pengaturan/nomor/create')." class='btn btn-success'>Klik disini untuk Setting</a>";
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

    public function proses($id) {
        $penyusutan = Penyusutanaset::find($id);
        $penyusutan->update(['status' => 1]);

        date_default_timezone_set('Asia/Jakarta');
        $header = JurnalHeader::create([
            'tipe' => "ASET",
            'kode_jurnal' => "KAST".$this->_generatekodejurnal(),
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Penyusutan Aset'
        ]);

        $detail = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $penyusutan->akun_kas,
            'debet' => $penyusutan->penyusutan * $penyusutan->bulan,
            'kredit' => "",
            'nominal' => $penyusutan->penyusutan * $penyusutan->bulan
        ]);

        $detail2 = JurnalDetail::create([
            'id_header' => $header->id,
            'id_akun' => $penyusutan->akun_aset,
            'debet' => "",
            'kredit' => $penyusutan->nominal_harga,
            'nominal' => $penyusutan->nominal_harga
        ]);

        $data[] = array(
            'stat' => "OK"
        );
        return json_encode($data);
    }
}
