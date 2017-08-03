<?php

use Illuminate\Database\Seeder;

class Kolektibilitas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Kolektibilitas::truncate();

        \App\Model\Master\Kolektibilitas::create(
            ['id' => '1', 'kode' => 'LANCAR', 'keterangan' => 'Lancar', 'batas_hari' => '0']
        );

        \App\Model\Master\Kolektibilitas::create(
            ['id' => '2', 'kode' => 'DPK', 'keterangan' => 'Dalam Perhatian Khusus', 'batas_hari' => '40']
        );

        \App\Model\Master\Kolektibilitas::create(
            ['id' => '3', 'kode' => 'KL', 'keterangan' => 'Kurang Lancar', 'batas_hari' => '90']
        );

        \App\Model\Master\Kolektibilitas::create(
            ['id' => '4', 'kode' => 'DR', 'keterangan' => 'Diragukan', 'batas_hari' => '120']
        );

        \App\Model\Master\Kolektibilitas::create(
            ['id' => '5', 'kode' => 'MCT', 'keterangan' => 'Macet', 'batas_hari' => '180']
        );
    }
}
