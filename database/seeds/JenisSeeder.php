<?php

use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        \App\Model\Pos\Jenis::create([
            'jenis'  =>  'cash',
            'aktif'  =>  '1',
        ]);

//        \App\Model\Pos\Jenis::create([
//            'jenis'  =>  'autodebet',
//            'aktif'  =>  '0',
//        ]);

        \App\Model\Pos\Jenis::create([
            'jenis'  =>  'tunda',
            'aktif'  =>  '1',
        ]);
    }
}
