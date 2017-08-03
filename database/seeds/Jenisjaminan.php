<?php

use Illuminate\Database\Seeder;

class Jenisjaminan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Pinjaman\Jenisjaminan::create(
            ['id' => '1', 'jenis' => 'Simpanan', 'tabel' => 'jaminan_simpanan']
        );

        \App\Model\Pinjaman\Jenisjaminan::create(
            ['id' => '2', 'jenis' => 'Emas', 'tabel' => 'jaminan_emas']
        );

        \App\Model\Pinjaman\Jenisjaminan::create(
            ['id' => '3', 'jenis' => 'Kendaraan Bermotor', 'tabel' => 'jaminan_kendaraan']
        );

        \App\Model\Pinjaman\Jenisjaminan::create(
            ['id' => '4', 'jenis' => 'Elektronik', 'tabel' => 'jaminan_elektronik']
        );

        \App\Model\Pinjaman\Jenisjaminan::create(
            ['id' => '5', 'jenis' => 'Tanah dan Bangunan', 'tabel' => 'jaminan_bangunan']
        );

        \App\Model\Pinjaman\Jenisjaminan::create(
            ['id' => '6', 'jenis' => 'Tanpa Agunan', 'tabel' => 'jaminan_tanpa']
        );
    }
}
