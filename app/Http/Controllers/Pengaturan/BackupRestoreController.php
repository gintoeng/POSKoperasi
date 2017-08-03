<?php

namespace App\Http\Controllers\Pengaturan;

use App\Model\Pengaturan\Profil;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupRestoreController extends Controller
{
    public function index()
    {
        $files = Storage::files('backup');

        return view('pengaturan.backup_restore', ['files' => $files]);
    }

    public function backup()
    {
        $exitCode = Artisan::call('backup:mysql-dump');

        $files = Storage::files('backup');
        return redirect(url('pengaturan/backup-restore'));
    }

    public function backupdown()
    {
        $exitCode = Artisan::call('backup:mysql-dump');

        $files = Storage::files('backup');
        return response()->download(storage_path('app/'.$files[count($files)-1]));
    }

    public function postrestore(Request $request)
    {
        $exitCode = Artisan::call('backup:mysql-restore', [
            'filename' => str_replace('backup/', '',$request->filename)
        ]);

        return redirect(url('pengaturan/backup-restore'));
    }

    public function postrestoreloc(Request $request)
    {
        if ($request->hasFile('foto'))
        {
            $file     = $request->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = storage_path('app/backup/');
            $file->move($destinationPath, $filename);

            $xls = explode(".", $filename);

            if ($xls[1] == "sql") {
                $exitCode = Artisan::call('backup:mysql-restore', [
                    'filename' => str_replace('backup/', '', $filename)
                ]);
            }
        }

        return redirect(url('pengaturan/backup-restore'));
    }
}
