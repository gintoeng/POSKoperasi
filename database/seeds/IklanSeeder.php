<?php

use Illuminate\Database\Seeder;

class IklanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           \App\Model\Pos\Iklan::create([
            'title'  =>  'testbanner.png',
            'status'  =>  '1',
        ]);
    }
}
