<?php

use Illuminate\Database\Seeder;

use App\Model\Inventory\MasterStok as MasterStok;

class StokMinimumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
 			MasterStok::insert( [
            'stok'  => '1',
            ]);
    }
}
