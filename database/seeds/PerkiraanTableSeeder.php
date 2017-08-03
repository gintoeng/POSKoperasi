<?php

use Illuminate\Database\Seeder;
use App\Model\Akuntansi\Perkiraan;

class PerkiraanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '1',
          'kode_akun'  =>  '1-0000',
          'nama_akun' =>  'ACTIVA',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '2',
          'kode_akun'  =>  '2-0000',
          'nama_akun' =>  'PASIVA',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '3',
          'kode_akun'  =>  '3-0000',
          'nama_akun' =>  'CADANGAN, MODAL & RUGI/LABA',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '4',
          'kode_akun'  =>  '4-0000',
          'nama_akun' =>  'PENDAPATAN',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '5',
          'kode_akun'  =>  '5-0000',
          'nama_akun' =>  'HARGA POKOK PENJUALAN',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '6',
          'kode_akun'  =>  '6-0000',
          'nama_akun' =>  'BIAYA UMUM & ADMINISTRASI',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '7',
          'kode_akun'  =>  '7-0000',
          'nama_akun' =>  'PENDAPATAN NON OPERASIONAL',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '8',
          'kode_akun'  =>  '8-0000',
          'nama_akun' =>  'BIAYA NON OPERASIONAL',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '1',
          'parent'  =>  '1',
          'kode_akun'  =>  '1-1000',
          'nama_akun' =>  'ACTIVA LANCAR',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '1',
          'parent'  =>  '1',
          'kode_akun'  =>  '1-2000',
          'nama_akun' =>  'AKTIVA TETAP (NILAI BUKU)',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '1',
          'parent'  =>  '1',
          'kode_akun'  =>  '1-3000',
          'nama_akun' =>  'AKTIVA TETAP TIDAK BERWUJUD',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '1',
          'parent'  =>  '1',
          'kode_akun'  =>  '1-4000',
          'nama_akun' =>  'AKTIVA LAIN-LAIN',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '2',
          'parent'  =>  '2',
          'kode_akun'  =>  '2-1000',
          'nama_akun' =>  'PASIVA LANCAR',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '2',
          'parent'  =>  '2',
          'kode_akun'  =>  '2-2000',
          'nama_akun' =>  'PASIVA JANGKA PANCAR',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '3',
          'parent'  =>  '3',
          'kode_akun'  =>  '3-1000',
          'nama_akun' =>  'MODAL',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '3',
          'parent'  =>  '3',
          'kode_akun'  =>  '3-2000',
          'nama_akun' =>  'RUGI/LABAL',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '3',
          'parent'  =>  '3',
          'kode_akun'  =>  '3-3000',
          'nama_akun' =>  'DIVIDEND',
          'kas' =>  '1',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '4',
          'parent'  =>  '4',
          'kode_akun'  =>  '4-1000',
          'nama_akun' =>  'PENDAPATAN OPERASIONAL',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '4',
          'parent'  =>  '4',
          'kode_akun'  =>  '4-2000',
          'nama_akun' =>  'PENDAPATAN UNIT USAHA',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '4',
          'parent'  =>  '4',
          'kode_akun'  =>  '4-3000',
          'nama_akun' =>  'DISCOUNT & RETUR',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '5',
          'parent'  =>  '5',
          'kode_akun'  =>  '5-1000',
          'nama_akun' =>  'BIAYA LANGSUNG',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '6',
          'parent'  =>  '6',
          'kode_akun'  =>  '6-1000',
          'nama_akun' =>  'BIAYA ADMINISTRASI & UMUM',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '7',
          'parent'  =>  '7',
          'kode_akun'  =>  '7-1000',
          'nama_akun' =>  'PENDAPATAN DILUAR USAHA',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '8',
          'parent'  =>  '8',
          'kode_akun'  =>  '8-1000',
          'nama_akun' =>  'BIAYA DILUAR USAHA',
          'kas' =>  '0',
        ]);

        Perkiraan::create([
          'tipe_akun' =>  'header',
          'kelompok'  =>  '1',
          'parent'  =>  '9',
          'kode_akun'  =>  '1-1100',
          'nama_akun' =>  'KAS',
          'kas' =>  '1',
        ]);
    }
}
