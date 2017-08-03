<?php

namespace App\Http\Controllers\Akuntansi\pengaturan;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\pengaturanAkuns;
use App\Model\Akuntansi\pengaturanAkunRelasi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;

class PengaturanAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $Perkiraan = Perkiraan::where('tipe_akun', 'detail')->get();

        $Akun = pengaturanAkuns::where('status', 'header')->where('caption', '!=', 'Penjualan')->get();
        $active = '1';

        return view('Akuntansi.pengaturan.pengaturan_akun')->with('Perkiraan', $Perkiraan)
                                                            ->with('Akun', $Akun)
                                                            ->with('active', $active);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $akunheader = pengaturanAkunRelasi::where('id_header', $id)->get();

        foreach ($akunheader as $row) {
            $akundetail = pengaturanAkunRelasi::find($row->id);
            $akundetail->id_akun = $request->input('akun-'.$row->id);
            $akundetail->save();
        }

        $actives = $id;

        $msg = "Data Berhasil di Ubah";
        $alert = Toastr::success($msg, $title = "Ubah Pengaturan Akun", $options = []);
        return redirect(url('akuntansi/pengaturanakun'))
            ->with('actives', $actives)
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

    }

}
