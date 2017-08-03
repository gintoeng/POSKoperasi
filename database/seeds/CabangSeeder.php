<?php

use Illuminate\Database\Seeder;

use App\Model\Master\Cabang as Cabang;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cabang::insert( [
        'kode' 		=> '1T',
        'nama' 		=> 'Test',
        'alamat' 	=> 'JL.Test',
        'kota'		=> 'Jakarta Timur',
        'provinsi'	=> 'DKI Jakarta',
        'kode_pos' 	=> '13520',
        'telepon'	=> '087884938814',
        'pesawat'	=> 'Test',
        'fax'		=> '021120021'
            ]);
    }
}
