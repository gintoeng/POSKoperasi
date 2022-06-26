<?php

namespace App\Http\Controllers\Pengaturan;

use App\Model\Pengaturan\Profil;
use Illuminate\Http\Request;

use DB;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use developerpratika\Toastr\Facades\Toastr;

class ProfilController extends Controller
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
        $profil = DB::table('profil')->first();
        return view('pengaturan.profil',['profil'=>$profil]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::table('profil')->insert(['nama_koperasi'=>$nama,'alamat_koperasi'=>$alamat,'keterangan'=>$keterangan])
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $getprofil = DB::table('profil')->where('id', 1)->first();
            File::delete('foto/profil/' . $getprofil->foto);
            $file = $request->foto;
            $filename = str_replace(['/', '.', '$'], ['', '', ''], bcrypt($file->getClientOriginalName())) . '.' . $file->getClientOriginalExtension();

            $destinationPath = 'foto/profil/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = $request->gambar;
        }

        $profil = Profil::findOrNew($request->id);
        $profil->update([
            'nama_koperasi' => $request->nama_koperasi,
            'alamat_koperasi' => $request->alamat_koperasi,
            'keterangan' => $request->keterangan,
            'telepon' => $request->telepon,
            'foto' => $filename,
            'kode_pos' => $request->kode_pos,
            'nomor_rekening' => $request->nomor_rekening,
            'kode' => $request->kode_koperasi
        ]);

        $msg = "Data Berhasil di Ubah";
        $alert = Toastr::success($msg, $title = "Ubah Profil", $options = []);
        $profil = Profil::findOrNew(1);
        return redirect(url('pengaturan/profil'))->with('profil', $profil)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
