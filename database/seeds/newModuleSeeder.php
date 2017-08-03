<?php

use Illuminate\Database\Seeder;

class newModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Cabang Rekening',
            'menu_mask' =>  'Daftar Cabang Rekening',
            'menu_path' =>  'master/cabangrekening',
            'menu_icon' =>  'ti-shield',
            'menu_order'  =>  '10',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Kelompok SHU',
            'menu_mask' =>  'Daftar Kelompok SHU',
            'menu_path' =>  'master/katshuheader',
            'menu_icon' =>  'ti-direction',
            'menu_order'  =>  '11',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar SHU',
            'menu_mask' =>  'Daftar SHU',
            'menu_path' =>  'master/katshudetail',
            'menu_icon' =>  'ti-direction-alt',
            'menu_order'  =>  '12',
            'divider' =>  0,
        ]);
        
    }
}
