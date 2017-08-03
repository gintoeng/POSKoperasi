<?php

use Illuminate\Database\Seeder;
use App\Model\Akuntansi\Perkiraan;

class perkiraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perkiraan::create(
            ['id' => '1','tipe_akun' => 'header','kelompok' => '1','parent' => '0','kode_akun' => '1-0000','nama_akun' => 'ACTIVA','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '2','tipe_akun' => 'header','kelompok' => '2','parent' => '0','kode_akun' => '2-0000','nama_akun' => 'PASIVA','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '3','tipe_akun' => 'header','kelompok' => '3','parent' => '0','kode_akun' => '3-0000','nama_akun' => 'CADANGAN, MODAL & RUGI LABA','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '4','tipe_akun' => 'header','kelompok' => '4','parent' => '0','kode_akun' => '4-0000','nama_akun' => 'PENDAPATAN','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '5','tipe_akun' => 'header','kelompok' => '5','parent' => '0','kode_akun' => '5-0000','nama_akun' => 'HARGA POKOK PENJUALAN','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '6','tipe_akun' => 'header','kelompok' => '6','parent' => '0','kode_akun' => '6-0000','nama_akun' => 'BIAYA UMUM & ADMNISTRASI','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '7','tipe_akun' => 'header','kelompok' => '7','parent' => '0','kode_akun' => '7-0000','nama_akun' => 'PENDAPATAN NON OPERASIONAL','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '8','tipe_akun' => 'header','kelompok' => '8','parent' => '0','kode_akun' => '8-0000','nama_akun' => 'BIAYA NON OPERASIONAL','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '9','tipe_akun' => 'header','kelompok' => '1','parent' => '1','kode_akun' => '1-1000','nama_akun' => 'ACTIVA LANCAR','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '10','tipe_akun' => 'header','kelompok' => '2','parent' => '2','kode_akun' => '2-1000','nama_akun' => 'PASIVA LANCAR','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '11','tipe_akun' => 'header','kelompok' => '1','parent' => '9','kode_akun' => '1-1100','nama_akun' => 'KAS','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '12','tipe_akun' => 'detail','kelompok' => '1','parent' => '25','kode_akun' => '1-1100-0001','nama_akun' => 'KAS','kas' => '1']
        );

        Perkiraan::create(
            ['id' => '15','tipe_akun' => 'detail','kelompok' => '1','parent' => '25','kode_akun' => '1-1100-0002','nama_akun' => 'KAS BERJALAN','kas' => '1']
        );

        Perkiraan::create(
            ['id' => '16','tipe_akun' => 'detail','kelompok' => '1','parent' => '25','kode_akun' => '1-1100-0003','nama_akun' => 'KAS TETAP','kas' => '1']
        );

        Perkiraan::create(
            ['id' => '13','tipe_akun' => 'header','kelompok' => '2','parent' => '10','kode_akun' => '2-1100','nama_akun' => 'HUTANG USAHA','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '14','tipe_akun' => 'detail','kelompok' => '2','parent' => '13','kode_akun' => '2-1100-0001','nama_akun' => 'HUTANG KEPADA SUPLIER','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '17','tipe_akun' => 'detail','kelompok' => '2','parent' => '13','kode_akun' => '2-1100-0002','nama_akun' => 'HUTANG KEPADA ANGGOTA','kas' => '0']
        );

        Perkiraan::create(
            ['id' => '18','tipe_akun' => 'detail','kelompok' => '2','parent' => '13','kode_akun' => '2-1100-0003','nama_akun' => 'HUTANG SIMPAN PINJAM','kas' => '0']
        );
    }
}
