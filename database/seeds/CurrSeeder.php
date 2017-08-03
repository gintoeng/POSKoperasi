<?php

use Illuminate\Database\Seeder;

use App\Model\Inventory\Curr as Curr;

class CurrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	Curr::insert( [
            'nama'  => 'RP',
            'kode'	=> '1Rp'
            ]);
    }
}
