<?php

use Illuminate\Database\Seeder;

class ModSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Autodebet Simpanan',
            'menu_mask' =>  'Autodebet Simpanan',
            'menu_path' =>  'akuntansi/autodebet/simpanan',
            'menu_icon' =>  'ti-envelope',
            'menu_order'  =>  '15',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Autodebet Pinjaman',
            'menu_mask' =>  'Autodebet Pinjaman',
            'menu_path' =>  'akuntansi/autodebet/pinjaman',
            'menu_icon' =>  'ti-envelope',
            'menu_order'  =>  '16',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Autodebet Waserda',
            'menu_mask' =>  'Autodebet Waserda',
            'menu_path' =>  'akuntansi/autodebet/waserda',
            'menu_icon' =>  'ti-envelope',
            'menu_order'  =>  '17',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '7',
            'module_name' =>  'Approve List Simpanan',
            'menu_mask' =>  'Approve List Simpanan',
            'menu_path' =>  'pengaturan/approve/simpanan',
            'menu_icon' =>  'ti-comments-smiley',
            'menu_order'  =>  '1',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '7',
            'module_name' =>  'Approve List Pinjaman',
            'menu_mask' =>  'Approve List Pinjaman',
            'menu_path' =>  'pengaturan/approve/pinjaman',
            'menu_icon' =>  'ti-comments-smiley',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '7',
            'module_name' =>  'Approve List Waserda',
            'menu_mask' =>  'Approve List Waserda',
            'menu_path' =>  'pengaturan/approve/waserda',
            'menu_icon' =>  'ti-comments-smiley',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Stok Barang',
            'menu_mask' =>  'Stok Barang',
            'menu_path' =>  'laporan/waserda/stok',
            'menu_icon' =>  'ti-pin2',
            'menu_order'  =>  '18',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Penjualan',
            'menu_mask' =>  'Penjualan',
            'menu_path' =>  'laporan/waserda/penjualan',
            'menu_icon' =>  'ti-stats-up',
            'menu_order'  =>  '19',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Penjualan Anggota',
            'menu_mask' =>  'Penjualan Anggota',
            'menu_path' =>  'laporan/waserda/penjualan/anggota',
            'menu_icon' =>  'ti-stats-up',
            'menu_order'  =>  '20',
            'divider' =>  0,
        ]);

        \App\Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Penjualan Hpp',
            'menu_mask' =>  'Penjualan Hpp',
            'menu_path' =>  'laporan/waserda/penjualan/hpp',
            'menu_icon' =>  'ti-stats-down',
            'menu_order'  =>  '21',
            'divider' =>  0,
        ]);
    }
}
