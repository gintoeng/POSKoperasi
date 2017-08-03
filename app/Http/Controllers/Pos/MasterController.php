<?php

namespace App\Http\Controllers\Pos;

use App\Model\Pos\Iklan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Pengaturan\Profil;
use App\Model\Pos\Jenis;

class MasterController extends Controller
{
        public function index()
    {
        $profil = Profil::find(1);
        return view('pos.master')->with('profil', $profil);
    }
    public function getpayment($norefnya)
    {
      $cekjenis1 = Jenis::find(1);
//      $cekjenis2 = Jenis::find(2);
      $cekjenis2 = Jenis::find(2);

      $aktif1 = $cekjenis1->aktif;
      $aktif2 = $cekjenis2->aktif;
//      $aktif3 = $cekjenis3->aktif;

    $data[] = array(
      'ck1'       => $aktif1,
      'ck2'       => $aktif2,
      'norefnya'  => $norefnya
    );
    return json_encode($data);

    }
    public function simpan($id1, $id2)
    {
        // $cekjenis = Jenis::find(1);
        // if ($cekjenis==null) 
        // {

        //         $jenis = Jenis::all();
        //         $jenis->create([
        //         'jenis'      => 'cash',
        //         'aktif'      => $id1
        //         ]);

        //         $jenis = Jenis::all();
        //         $jenis->create([
        //         'jenis'      => 'autodebet',
        //         'aktif'      => $id2
        //         ]);

        //         $jenis = Jenis::all();
        //         $jenis->create([
        //         'jenis'      => 'tunda',
        //         'aktif'      => $id3
        //         ]);

            
        // }
        // else
        // {
                $jenis = Jenis::find(1);
                $jenis->update([
                'aktif'      => $id1
                ]);

                 $jenis = Jenis::find(2);
                $jenis->update([
                'aktif'      => $id2
                ]);

//                 $jenis = Jenis::find(3);
//                $jenis->update([
//                'aktif'      => $id3
//                ]);

       // }

        $data[] = array('stat' => "OK");
        return json_encode($data);

    }

    public function jenis()
    {
        
        $jenis = Jenis::find(1);
        $angkanya1 = $jenis->aktif;
//
//        $jeniss = Jenis::find(2);
//        $angkanya2 = $jeniss->aktif;

        $jenisss = Jenis::find(2);
        $angkanya2 = $jenisss->aktif;

        return view('pos.jenis')->with('angkanya1', $angkanya1)->with('angkanya2', $angkanya2);
    }

            public function indexiklan()
    {
        $iklan = Iklan::find(1);
        $status = $iklan->status;
        return view('pos.iklan')->with('iklan', $iklan)->with('status', $status);
    }




     public function create(Master $master)

    {
       return view('pos.master',compact('pos.master'));
    }




        public function store(Request $request)
    {
 		 $master = Profil::find(1);
         $master->update([
        'nama_koperasi'   => $request->Enama_koperasi,
        'alamat_koperasi' => $request->Ealamat,
        'keterangan'      => $request->Eketerangan,
        'telepon'         => $request->Etelepon,
        'kode_pos'        => $request->Ekode,
        'foto'            => $request->Enama_koperasi

            ]);


        return redirect( url('pos/master'));
    }

     public function edit()
    {
        $profil = Profil::find(1);
        return view('pos.master')->with('profil', $profil);
    }

}
