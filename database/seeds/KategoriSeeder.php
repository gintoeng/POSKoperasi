<?php

use Illuminate\Database\Seeder;

use App\Model\Inventory\Kategori as Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::insert( [
     	'nama' => 'Makanan',
    	'kode' => '1M',
            ]);
    }
}
