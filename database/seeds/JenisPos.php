<?php

use Illuminate\Database\Seeder;

class JenisPos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j1 = \App\Model\Pos\Jenis::find(1);
        $j1->update(['aktif', 1]);

        $j2 = \App\Model\Pos\Jenis::find(2);
        $j2->update(['aktif', 1]);
    }
}
