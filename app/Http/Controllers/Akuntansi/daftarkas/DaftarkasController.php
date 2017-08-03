<?php

namespace App\Http\Controllers\Akuntansi\daftarkas;

use App\Model\Akuntansi\Perkiraan;
use App\Model\Akuntansi\JurnalDetail;
use App\Model\Akuntansi\JurnalHeader;
use App\Model\Akuntansi\Kas;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DaftarkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');

        $kas = Kas::orderBy('id', 'DESC')->paginate(20);
        $kascount = Kas::count();

        $tipe = "";

        $statuscari= "index";

        return view('Akuntansi.daftarkas.daftarkas')->with('date1', $date1)
                                                          ->with('date2', $date2)
                                                          ->with('kas', $kas)
                                                          ->with('kascount', $kascount)
                                                          ->with('statuscari', $statuscari)
                                                          ->with('tipe', $tipe);
    }

    public function search(Request $request)
    {
        $date1 = $request->datefrom;
        $date2 = $request->dateto;

        $tipe = $request->tipe;

        $statuscari= "cari";

        if($tipe=="Semua"){
            $kas = Kas::where('tanggal', '>=', $request->datefrom." 00:00:00")->where('tanggal', '<=', $request->dateto." 23:59:00")->orderBy('id', 'DESC')->paginate(20);
            $kascount = Kas::where('tanggal', '>=', $request->datefrom." 00:00:00")->where('tanggal', '<=', $request->dateto." 23:59:00")->orderBy('id', 'DESC')->count();
        }
        else {
            $kas = Kas::where('tipe', $tipe)->where('tanggal', '>=', $request->datefrom." 00:00:00")->where('tanggal', '<=', $request->dateto." 23:59:00")->orderBy('id', 'DESC')->paginate(20);
            $kascount = Kas::where('tipe', $tipe)->where('tanggal', '>=', $request->datefrom." 00:00:00")->where('tanggal', '<=', $request->dateto." 23:59:00")->orderBy('id', 'DESC')->count();
        }



        return view('Akuntansi.daftarkas.daftarkas')->with('tipe', $tipe)
                                                          ->with('date1', $date1)
                                                          ->with('date2', $date2)
                                                          ->with('kascount', $kascount)
                                                          ->with('statuscari', $statuscari)
                                                          ->with('kas', $kas);
    }

    public function cetak()
    {

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
