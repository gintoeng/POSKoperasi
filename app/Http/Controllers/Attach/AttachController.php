<?php

namespace App\Http\Controllers\Attach;

use App\Attach;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AttachController extends Controller
{
    public function store(Request $request) {
        if ($request->hasFile('filedoc'))
        {
            $file     = $request->filedoc;
            $filename = $file->getClientOriginalName();
            $filemime = $file->getClientMimeType();

            $destinationPath = 'foto/doc/pinjaman/';
            $file->move($destinationPath, $filename);
        }

        $idp = $request->idp;
        Attach::create([
            'id_pengaturan' => $idp,
            'keterangan'    => $request->keterangan,
            'doc'           => $filename,
            'mime'           => $filemime
        ]);

        return redirect(url()->previous());
    }

    public function store2(Request $request) {
        if ($request->hasFile('filedoc'))
        {
            $file     = $request->filedoc;
            $filename = $file->getClientOriginalName();
            $filemime = $file->getClientMimeType();

            $destinationPath = 'foto/doc/anggota/';
            $file->move($destinationPath, $filename);
        }

        $idc = $request->idp;
        Attach::create([
            'id_anggota' => $idc,
            'keterangan'    => $request->keterangan,
            'doc'           => $filename,
            'mime'           => $filemime
        ]);

        return redirect(url()->previous());
    }

    public function destroy($id, $idp) {
        $att = Attach::find($id);
        unlink('foto/doc/pinjaman/'.$att->doc);
        Attach::destroy($id);
        $this->ajaxdoc($idp);
    }

    public function destroy2($id, $idc) {
        $att = Attach::find($id);
        unlink('foto/doc/anggota/'.$att->doc);
        Attach::destroy($id);
        $this->ajaxdoc2($idc);
    }

    public function download($id) {
        $att = Attach::find($id);
        $file = public_path()."/foto/doc/pinjaman/".$att->doc;

        $headers = array(
            'Content-Type: '.$att->mime,
        );
        return response()->download($file, $att->filename, $headers);
    }

    public function download2($id) {
        $att = Attach::find($id);
        $file = public_path()."/foto/doc/anggota/".$att->doc;
        $headers = array(
            'Content-Type: '.$att->mime,
        );
        return response()->download($file, $att->filename, $headers);
    }

    public function show($id) {
        $att = Attach::find($id);
        $file = public_path()."/foto/doc/pinjaman/".$att->doc;
        $headers = array(
            'Content-Type: '.$att->mime,
        );
        return response()->file($file, $headers);
    }

    public function show2($id) {
        $att = Attach::find($id);
        $file = public_path()."/foto/doc/anggota/".$att->doc;
        $headers = array(
            'Content-Type: '.$att->mime,
        );
        return response()->file($file, $headers);
    }

    public function ajaxdoc($idp) {
        $tab = Attach::where('id_pengaturan', $idp)->get();
        $this->_tablenya($tab);
    }

    public function ajaxdoc2($idc) {
        $tab = Attach::where('id_anggota', $idc)->get();
        $this->_tablenya($tab);
    }

    public function _tablenya($tab) {
        echo '<table id="tabdoc" class="table table-bordered table-striped no-m scroll" style="display: -moz-groupbox;">';
        echo '<thead>';
        echo '<tr style="background-color: dodgerblue; color: white; width: 100%;">';
        echo '<th class="text-center" width="50">No.</th>';
        echo '<th class="text-center">Keterangan</th>';
        echo '<th class="text-center">File</th>';
        echo '<th class="text-center">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $i = 1;
        foreach ($tab as $item) {
            $file = explode('.', $item->doc);
            echo '<tr>';
            echo '<td class="text-center">'.$i++.'</td>';
            echo '<td>'.$item->keterangan.'</td>';
            echo '<td>'.$item->doc.'</td>';
            echo '<td align="center" class="fa-hover">';
            echo '<a href="javascript:void(0)" onclick="down('.$item->id.')" data-toggle="tooltip" data-placement="left" title="Download"><i class="ti-download mr5" style="color: dodgerblue; font-size: medium"></i></a>';
            if ($file[1] == "pdf") {
                echo '<a href="javascript:void(0)" onclick="pre('.$item->id.')" data-toggle="tooltip" data-placement="top" title="Preview"><i class="ti-write mr5" style="color: limegreen; font-size: medium"></i></a>';
            }
            echo '<a href="javascript:void(0)" onclick="hapus('.$item->id.')" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}
