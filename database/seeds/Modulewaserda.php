<?php

use Illuminate\Database\Seeder;

class Modulewaserda extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modwaserda::create(['kode' => '9999999991', 'nama' => 'Informasi Instansi', 'path' => 'pos/master']);
        \App\Modwaserda::create(['kode' => '9999999992', 'nama' => 'Iklan', 'path' => 'pos/master/iklan']);
        \App\Modwaserda::create(['kode' => '9999999993', 'nama' => 'Jenis Transaksi', 'path' => 'pos/master/jenis']);

        \App\Modwaserda::create(['kode' => '9999999994', 'nama' => 'Cek Saldo', 'path' => 'pos/ceksaldo']);
        \App\Modwaserda::create(['kode' => '9999999995', 'nama' => 'Pembayaran', 'path' => 'pos/payment']);
        \App\Modwaserda::create(['kode' => '9999999996', 'nama' => 'Tahan Transaksi', 'path' => 'pos/tahan']);
        \App\Modwaserda::create(['kode' => '9999999997', 'nama' => 'Retur', 'path' => 'pos/retur']);
        \App\Modwaserda::create(['kode' => '9999999998', 'nama' => 'List Barang Belanjaan', 'path' => 'pos/penjualan']);

        \App\Modwaserda::create(['kode' => '9999999971', 'nama' => 'Proses Hitung HPP', 'path' => 'pos/hpp/akumulasi']);
        \App\Modwaserda::create(['kode' => '9999999972', 'nama' => 'Laporan Stok Barang', 'path' => 'pos/laporan/stok/barang']);
        \App\Modwaserda::create(['kode' => '9999999973', 'nama' => 'Laporan HPP', 'path' => 'pos/laporan/hpp']);
        \App\Modwaserda::create(['kode' => '9999999974', 'nama' => 'Laporan Penjualan', 'path' => 'pos/laporan/transaksi/penjualan']);
        \App\Modwaserda::create(['kode' => '9999999975', 'nama' => 'Laporan Penjualan Anggota', 'path' => 'pos/laporan/transaksi/anggota']);
        \App\Modwaserda::create(['kode' => '9999999976', 'nama' => 'Retur Penjualan', 'path' => 'pos/laporan/transaksi/retur']);
        \App\Modwaserda::create(['kode' => '9999999977', 'nama' => 'Rekap Penjualan', 'path' => 'pos/laporan/rekap']);
        \App\Modwaserda::create(['kode' => '9999999977', 'nama' => 'Fast Moving & Slow Moving', 'path' => 'pos/laporan/transaksi/fastmoving/slowmoving']);

        \App\Modwaserda::create(['kode' => '9999999981', 'nama' => 'Pembelian Supplier', 'path' => 'inventory/supplier/pembelian']);
        \App\Modwaserda::create(['kode' => '9999999982', 'nama' => 'Penerimaan Supplier', 'path' => 'inventory/supplier/penerimaan']);
        \App\Modwaserda::create(['kode' => '9999999983', 'nama' => 'Retur Supplier', 'path' => 'inventory/supplier/retur']);
        \App\Modwaserda::create(['kode' => '9999999984', 'nama' => 'Pengiriman Cabang', 'path' => 'inventory/cabang/pengiriman']);
        \App\Modwaserda::create(['kode' => '9999999985', 'nama' => 'Penerimaan Cabang', 'path' => 'inventory/cabang/penerimaan']);
        \App\Modwaserda::create(['kode' => '9999999986', 'nama' => 'Stock Opname', 'path' => 'inventory/cabang/opname']);
        \App\Modwaserda::create(['kode' => '9999999987', 'nama' => 'Laporan Barang Masuk', 'path' => 'lapbarangmasuk']);
        \App\Modwaserda::create(['kode' => '9999999988', 'nama' => 'Laporan Barang Keluar', 'path' => 'lapbarangkeluar']);
        \App\Modwaserda::create(['kode' => '9999999989', 'nama' => 'Stock Minimum', 'path' => 'stokminimum']);
        \App\Modwaserda::create(['kode' => '9999999990', 'nama' => 'Barang Expired', 'path' => 'inventory/expired']);
    }
}
