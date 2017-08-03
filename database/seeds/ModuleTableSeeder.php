<?php
/**
 * Created by PhpStorm.
 * User: ichsan
 * Date: 12/01/16
 * Time: 10:09
 */

use Illuminate\Database\Seeder;
use App\Module as Module;

class ModuleTableSeeder extends Seeder {
    public function run()
    {
       // Module::truncate();

        // MASTER
        Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Master',
            'menu_mask' =>  'Master',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-harddrives',
            'menu_order'  =>  '1',
            'divider' =>  0,
        ]);

        // SIMPANAN
        Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Simpanan',
            'menu_mask' =>  'Simpanan',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        // PINJAMAN
        Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Pinjaman',
            'menu_mask' =>  'Pinjaman',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-hand-drag',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        // AKUNTANSI
        Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Akuntansi',
            'menu_mask' =>  'Akuntansi',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-briefcase',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        //LAPORAN
        Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Laporan',
            'menu_mask' =>  'Laporan',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-receipt',
            'menu_order'  =>  '5',
            'divider' =>  0,
        ]);

        // PENGATURAN
        Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Pengaturan',
            'menu_mask' =>  'Pengaturan',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-settings',
            'menu_order'  =>  '6',
            'divider' =>  0,
        ]);
        
        // APPROVE
        \App\Module::create([
            'menu_parent' =>  '0',
            'module_name' =>  'Approve',
            'menu_mask' =>  'Approve',
            'menu_path' =>  '',
            'menu_icon' =>  'ti-comments-smiley',
            'menu_order'  =>  '7',
            'divider' =>  0,
        ]);




        // MASTER CHILD
        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Customer',
            'menu_mask' =>  'Daftar Customer',
            'menu_path' =>  'master/customer',
            'menu_icon' =>  'ti-user',
            'menu_order'  =>  '1',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Unit',
            'menu_mask' =>  'Daftar Unit',
            'menu_path' =>  'master/unit',
            'menu_icon' =>  'ti-filter',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Kolektibilitas',
            'menu_mask' =>  'Daftar Kolektibilitas',
            'menu_path' =>  'master/kolektibilitas',
            'menu_icon' =>  'ti-notepad',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Mata Uang',
            'menu_mask' =>  'Daftar Mata Uang',
            'menu_path' =>  'master/matauang',
            'menu_icon' =>  'ti-money',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Bank',
            'menu_mask' =>  'Daftar Bank',
            'menu_path' =>  'master/bank',
            'menu_icon' =>  'ti-stamp',
            'menu_order'  =>  '5',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Barang',
            'menu_mask' =>  'Daftar Barang',
            'menu_path' =>  'master/barang',
            'menu_icon' =>  'ti-package',
            'menu_order'  =>  '6',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Vendor',
            'menu_mask' =>  'Daftar Vendor',
            'menu_path' =>  'master/vendor',
            'menu_icon' =>  'ti-truck',
            'menu_order'  =>  '7',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Kategori',
            'menu_mask' =>  'Daftar Kategori',
            'menu_path' =>  'master/kategori',
            'menu_icon' =>  'ti-layers',
            'menu_order'  =>  '8',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '1',
            'module_name' =>  'Daftar Cabang',
            'menu_mask' =>  'Daftar Cabang',
            'menu_path' =>  'master/cabang',
            'menu_icon' =>  'ti-map-alt',
            'menu_order'  =>  '9',
            'divider' =>  1,
        ]);




        // SIMPANAN CHILD
        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Pengaturan Simpanan',
            'menu_mask' =>  'Pengaturan Simpanan',
            'menu_path' =>  'simpanan/pengaturan',
            'menu_icon' =>  'ti-panel',
            'menu_order'  =>  '1',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Daftar Simpanan',
            'menu_mask' =>  'Daftar Simpanan',
            'menu_path' =>  'simpanan',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Daftar Transaksi',
            'menu_mask' =>  'Daftar Transaksi',
            'menu_path' =>  'simpanan/transaksi',
            'menu_icon' =>  'ti-exchange-vertical',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Setor / Tarik',
            'menu_mask' =>  'Setor / Tarik',
            'menu_path' =>  'simpanan/transaksi/create',
            'menu_icon' =>  'ti-write',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Setoran Kolektif',
            'menu_mask' =>  'Setoran Kolektif',
            'menu_path' =>  'simpanan/kolektif',
            'menu_icon' =>  'ti-hand-drag',
            'menu_order'  =>  '5',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Mutasi Simpanan',
            'menu_mask' =>  'Mutasi Simpanan',
            'menu_path' =>  'simpanan/mutasi',
            'menu_icon' =>  'ti-menu-alt',
            'menu_order'  =>  '6',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '2',
            'module_name' =>  'Proses Simpanan',
            'menu_mask' =>  'Proses Simpanan',
            'menu_path' =>  'simpanan/proses',
            'menu_icon' =>  'ti-envelope',
            'menu_order'  =>  '7',
            'divider' =>  0,
        ]);





        // PINJAMAN CHILD
        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Pengaturan Pinjaman',
            'menu_mask' =>  'Pengaturan Pinjaman',
            'menu_path' =>  'pinjaman/pengaturan',
            'menu_icon' =>  'ti-panel',
            'menu_order'  =>  '1',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Daftar Pinjaman',
            'menu_mask' =>  'Daftar Pinjaman',
            'menu_path' =>  'pinjaman',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Realisasi Pinjaman',
            'menu_mask' =>  'Realisasi Pinjaman',
            'menu_path' =>  'pinjaman/realisasi',
            'menu_icon' =>  'ti-import',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Daftar Pembayaran',
            'menu_mask' =>  'Daftar Pembayaran',
            'menu_path' =>  'pinjaman/pembayaran',
            'menu_icon' =>  'ti-agenda',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Bayar Pinjaman',
            'menu_mask' =>  'Bayar Pinjaman',
            'menu_path' =>  'pinjaman/pembayaran/create',
            'menu_icon' =>  'ti-export',
            'menu_order'  =>  '5',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Mutasi Pinjaman',
            'menu_mask' =>  'Mutasi Pinjaman',
            'menu_path' =>  'pinjaman/mutasi',
            'menu_icon' =>  'ti-menu-alt',
            'menu_order'  =>  '6',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '3',
            'module_name' =>  'Reschedule Pinjaman',
            'menu_mask' =>  'Reschedule Pinjaman',
            'menu_path' =>  'pinjaman/reschedule',
            'menu_icon' =>  'ti-spray',
            'menu_order'  =>  '7',
            'divider' =>  0,
        ]);




        // AKUNTANSI CHILD
        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Akun Perkiraan',
            'menu_mask' =>  'Akun Perkiraan',
            'menu_path' =>  'akuntansi/perkiraan',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '1',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Daftar Jurnal',
            'menu_mask' =>  'Daftar Jurnal',
            'menu_path' =>  'akuntansi/jurnal/semua',
            'menu_icon' =>  'ti-agenda',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Buku Besar',
            'menu_mask' =>  'Buku Besar',
            'menu_path' =>  'akuntansi/bukubesar',
            'menu_icon' =>  'ti-package',
            'menu_order'  =>  '3',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Daftar Kas',
            'menu_mask' =>  'Daftar Kas',
            'menu_path' =>  'akuntansi/daftarkas',
            'menu_icon' =>  'ti-wallet',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Kas Masuk',
            'menu_mask' =>  'Kas Masuk',
            'menu_path' =>  'akuntansi/kasmasuk',
            'menu_icon' =>  'ti-import',
            'menu_order'  =>  '5',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Kas Keluar',
            'menu_mask' =>  'Kas Keluar',
            'menu_path' =>  'akuntansi/kaskeluar',
            'menu_icon' =>  'ti-export',
            'menu_order'  =>  '6',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Kas Transfer',
            'menu_mask' =>  'Kas Transfer',
            'menu_path' =>  'akuntansi/kastransfer',
            'menu_icon' =>  'ti-exchange-vertical',
            'menu_order'  =>  '7',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Saldo Awal Akuntansi',
            'menu_mask' =>  'Saldo Awal Akuntansi',
            'menu_path' =>  'akuntansi/saldoawal',
            'menu_icon' =>  'ti-server',
            'menu_order'  =>  '8',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Pengaturan Akun',
            'menu_mask' =>  'Pengaturan Akun',
            'menu_path' =>  'akuntansi/pengaturanakun',
            'menu_icon' =>  'ti-settings',
            'menu_order'  =>  '9',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Hitung SHU',
            'menu_mask' =>  'Hitung SHU',
            'menu_path' =>  'akuntansi/hitungshu',
            'menu_icon' =>  'ti-gift',
            'menu_order'  =>  '10',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Penyusutan Aset',
            'menu_mask' =>  'Penyusutan Aset',
            'menu_path' =>  'akuntansi/penyusutan',
            'menu_icon' =>  'ti-receipt',
            'menu_order'  =>  '11',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Proyeksi Simpanan',
            'menu_mask' =>  'Proyeksi Simpanan',
            'menu_path' =>  'akuntansi/proyeksi/simpanan',
            'menu_icon' =>  'ti-layout-media-overlay',
            'menu_order'  =>  '12',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Proyeksi Bunga Simpanan',
            'menu_mask' =>  'Proyeksi Bunga Simpanan',
            'menu_path' =>  'akuntansi/proyeksi/simpanan/bunga',
            'menu_icon' =>  'ti-layout-media-overlay-alt',
            'menu_order'  =>  '13',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '4',
            'module_name' =>  'Proyeksi Pendapatan Pinjaman',
            'menu_mask' =>  'Proyeksi Pendapatan Pinjaman',
            'menu_path' =>  'akuntansi/proyeksi/pinjaman',
            'menu_icon' =>  'ti-layout-media-overlay-alt-2',
            'menu_order'  =>  '14',
            'divider' => 1,
        ]);


        // Module::create([
        //     'menu_parent' =>  '4',
        //     'module_name' =>  'Proses Tutup Tahun',
        //     'menu_mask' =>  'Proses Tutup Tahun',
        //     'menu_path' =>  'akuntansi/prosestutuptahun',
        //     'menu_icon' =>  'ti-calendar',
        //     'menu_order'  =>  '11',
        //     'divider' =>  0,
        // ]);




        // LAPORAN CHILD
        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Data Customer',
            'menu_mask' =>  'Data Customer',
            'menu_path' =>  'laporan/customer/data',
            'menu_icon' =>  'ti-user',
            'menu_order'  =>  '1',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Daftar Simpanan',
            'menu_mask' =>  'Daftar Simpanan',
            'menu_path' =>  'laporan/simpanan/data',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Transaksi Simpanan',
            'menu_mask' =>  'Transaksi Simpanan',
            'menu_path' =>  'laporan/simpanan/transaksi',
            'menu_icon' =>  'ti-exchange-vertical',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Saldo Simpanan',
            'menu_mask' =>  'Saldo Simpanan',
            'menu_path' =>  'laporan/simpanan/saldo',
            'menu_icon' =>  'ti-money',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Saldo Simpanan Kolom Jenis',
            'menu_mask' =>  'Saldo Simpanan Kolom Jenis',
            'menu_path' =>  'laporan/simpanan/saldo/jenis',
            'menu_icon' =>  'ti-receipt',
            'menu_order'  =>  '5',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Daftar Pinjaman',
            'menu_mask' =>  'Daftar Pinjaman',
            'menu_path' =>  'laporan/pinjaman/data',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '6',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Realisasi Pinjaman',
            'menu_mask' =>  'Realisasi Pinjaman',
            'menu_path' =>  'laporan/pinjaman/realisasi',
            'menu_icon' =>  'ti-import',
            'menu_order'  =>  '7',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Saldo Pinjaman',
            'menu_mask' =>  'Saldo Pinjaman',
            'menu_path' =>  'laporan/pinjaman/saldo',
            'menu_icon' =>  'ti-money',
            'menu_order'  =>  '8',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Transaksi Pinjaman',
            'menu_mask' =>  'Trasaksi Pinjaman',
            'menu_path' =>  'laporan/pinjaman/transaksi',
            'menu_icon' =>  'ti-agenda',
            'menu_order'  =>  '9',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Kolektibilitas Pinjaman',
            'menu_mask' =>  'Kolektibilitas Pinjaman',
            'menu_path' =>  'laporan/pinjaman/kolektibilitas',
            'menu_icon' =>  'ti-map',
            'menu_order'  =>  '10',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Daftar Akun Perkiraan',
            'menu_mask' =>  'Daftar Akun Perkiraan',
            'menu_path' =>  'laporan/perkiraan',
            'menu_icon' =>  'ti-book',
            'menu_order'  =>  '11',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Transaksi Kas',
            'menu_mask' =>  'Transaksi Kas',
            'menu_path' =>  'laporan/kas',
            'menu_icon' =>  'ti-arrow-left',
            'menu_order'  =>  '12',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Daftar Jurnal',
            'menu_mask' =>  'Daftar Jurnal',
            'menu_path' =>  'laporan/jurnal',
            'menu_icon' =>  'ti-agenda',
            'menu_order'  =>  '13',
            'divider' =>  1,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Neraca Saldo',
            'menu_mask' =>  'Neraca Saldo',
            'menu_path' =>  'laporan/neracasaldo',
            'menu_icon' =>  'ti-lock',
            'menu_order'  =>  '14',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Neraca Lajur',
            'menu_mask' =>  'Neraca Lajur',
            'menu_path' =>  'laporan/neracalajur',
            'menu_icon' =>  'ti-bar-chart-alt',
            'menu_order'  =>  '15',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Neraca',
            'menu_mask' =>  'Neraca',
            'menu_path' =>  'laporan/neraca',
            'menu_icon' =>  'ti-pulse',
            'menu_order'  =>  '16',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '5',
            'module_name' =>  'Laba Rugi',
            'menu_mask' =>  'Laba Rugi',
            'menu_path' =>  'laporan/labarugi',
            'menu_icon' =>  'ti-stats-up',
            'menu_order'  =>  '17',
            'divider' =>  1,
        ]);




        // PENGATURAN CHILD
        Module::create([
            'menu_parent' =>  '6',
            'module_name' =>  'Daftar User',
            'menu_mask' =>  'Daftar User',
            'menu_path' =>  'pengaturan/user',
            'menu_icon' =>  'ti-user',
            'menu_order'  =>  '1',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '6',
            'module_name' =>  'Hak Akses',
            'menu_mask' =>  'Hak Akses',
            'menu_path' =>  'pengaturan/role',
            'menu_icon' =>  'ti-lock',
            'menu_order'  =>  '2',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '6',
            'module_name' =>  'Module',
            'menu_mask' =>  'Module',
            'menu_path' =>  'pengaturan/module',
            'menu_icon' =>  'ti-menu',
            'menu_order'  =>  '3',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '6',
            'module_name' =>  'Profil Koperasi',
            'menu_mask' =>  'Profil Koperasi',
            'menu_path' =>  'pengaturan/profil',
            'menu_icon' =>  'ti-user',
            'menu_order'  =>  '4',
            'divider' =>  0,
        ]);

        Module::create([
            'menu_parent' =>  '6',
            'module_name' =>  'Format Nomor',
            'menu_mask' =>  'Format Nomor',
            'menu_path' =>  'pengaturan/nomor',
            'menu_icon' =>  'ti-key',
            'menu_order'  =>  '5',
            'divider' =>  1,
        ]);


    }
}
