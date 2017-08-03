<?php

use Illuminate\Database\Seeder;
use App\Model\Master\Anggota;

class AnggotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Anggota::truncate();
        $anggota = new Anggota;
        $anggota->pin = 123456;
        $anggota->kode = 'anggota1';
        $anggota->nama = 'Revando';
        $anggota->foto = 'avatar.jpg';
        $anggota->save();
    }
}
