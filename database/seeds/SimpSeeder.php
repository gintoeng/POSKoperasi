<?php

use Illuminate\Database\Seeder;

class SimpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Simpanan\Pengaturan::create([
            'kode' => 'SP',
            'jenis_simpanan' => 'Simpanan Pokok',
            'suku_bunga' => 6,
            'sistem_bunga' => 1,
            'setoran_minimum' => 100000,
            'akun_kas_bank' => 1,
            'akun_setoran' => 1,
            'akun_penarikan' => 1,
            'akun_bunga' => 1,
            'akun_administrasi' => 1,
            'akun_pajak' => 1,
            'kode_awal_rekening' => 'SP',
            'jumlah_digit_rekening' => 4,
            'nomor_akhir_rekening' => "0",
        ]);

        \App\Model\Simpanan\Pengaturan::create([
            'kode' => 'SW',
            'jenis_simpanan' => 'Simpanan Wajib',
            'suku_bunga' => 6,
            'sistem_bunga' => 1,
            'setoran_minimum' => 50000,
            'akun_kas_bank' => 1,
            'akun_setoran' => 1,
            'akun_penarikan' => 1,
            'akun_bunga' => 1,
            'akun_administrasi' => 1,
            'akun_pajak' => 1,
            'kode_awal_rekening' => 'SW',
            'jumlah_digit_rekening' => 4,
            'nomor_akhir_rekening' => "0",
        ]);
    }
}
