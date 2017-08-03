<?php

use Illuminate\Database\Seeder;
use App\Model\Pengaturan\Profil as Profil;

class ProfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Profil::truncate();

        Profil::create([
            'nama_koperasi'  =>  'KKBP',
            'alamat_koperasi'  =>  'Jl. Betok Raya',
            'keterangan'  =>  'Ini keterangan',
            'telepon' =>  '087882323023',
            'foto'  =>  'logo-cabangrekening.png',
            'kode_pos'  =>  '13340',
        ]);
    }
}
