<?php

use Illuminate\Database\Seeder;

class ShuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Master\Katshuheader::create(['kode' => 'SM', 'nama' => 'Simpanan']);
        \App\Model\Master\Katshuheader::create(['kode' => 'PJ', 'nama' => 'Pinjaman']);
        \App\Model\Master\Katshuheader::create(['kode' => 'WD', 'nama' => 'Waserda']);
    }
}
