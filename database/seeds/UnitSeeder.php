<?php

use Illuminate\Database\Seeder;

use App\Model\Inventory\Unit as Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::insert( [
            'nama'  => 'Pcs',
            'kode'	=> '1P',
            ]);
    }
}
