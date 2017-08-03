<?php

use Illuminate\Database\Seeder;

class Sistembunga extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Sistembunga::create([
            'id' => '1', 'sistem' => 'Saldo Terendah', 'untuk' => 'simpanan'
        ]);

        \App\Model\Sistembunga::create([
            'id' => '2', 'sistem' => 'Saldo Rata-rata', 'untuk' => 'simpanan'
        ]);

        \App\Model\Sistembunga::create([
            'id' => '3', 'sistem' => 'Saldo Harian', 'untuk' => 'simpanan'
        ]);

        \App\Model\Sistembunga::create([
            'id' => '4', 'sistem' => 'Bunga Tetap', 'untuk' => 'pinjaman'
        ]);

        \App\Model\Sistembunga::create([
            'id' => '5', 'sistem' => 'Bunga Efektif / Sliding Data', 'untuk' => 'pinjaman'
        ]);

        \App\Model\Sistembunga::create([
            'id' => '6', 'sistem' => 'Bunga Menurun / Anuitas', 'untuk' => 'pinjaman'
        ]);
    }
}
