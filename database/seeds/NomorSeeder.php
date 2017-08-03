<?php

use Illuminate\Database\Seeder;
use App\Model\Akuntansi\JurnalHeader;

class NomorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Master Customer',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'CSC',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Master Vendor',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'VND',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Simpanan',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'TRSIMP',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Pinjaman',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'TRPINJ',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Jurnal Manual',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'JRM',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Jurnal Otomatis',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'JRO',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Kas Masuk',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'KSM',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Kas Keluar',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'KSK',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Kas Transfer',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'KST',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Kas Transfer',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'KST',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Saldo Awal Akuntansi',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'SAAK',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Penyusutan Aset',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'PA',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'POS',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'POS',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Jurnal Transaksi POS',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'TRPOS',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Pembelian Barang Vendor',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'PMBS',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Penerimaan Barang Vendor',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'PNMS',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Retur Barang Vendor',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'RTRS',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Pengiriman Barang Cabang',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'PNGC',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Penerimaan Barang Cabang',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'PNMC',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);

        \App\Model\Pengaturan\Nomor::create([
            'modul'     => 'Stock Opname',
            'kode_awal' => 'kode',
            'pemisah'   => '-',
            'kode_awal2'=> 'digit',
            'kode'      => 'SOP',
            'nomor_now'     => 0,
            'jumlah_digit'  => 5,
            'nomor_akhir'   => 0
        ]);


    }
}
