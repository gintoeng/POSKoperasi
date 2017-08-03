<?php

use Illuminate\Database\Seeder;
use App\Model\Akuntansi\pengaturanAkuns;

class pengaturanakunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '1';
        $pengaturanakun->caption = 'SHU';
        $pengaturanakun->status = 'header';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '2';
        $pengaturanakun->caption = 'SHU Anggota';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '3';
        $pengaturanakun->caption = 'Dana Cadangan';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '4';
        $pengaturanakun->caption = 'Penjualan';
        $pengaturanakun->status = 'header';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '5';
        $pengaturanakun->caption = 'Pemasukan';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '6';
        $pengaturanakun->caption = 'Pembangunan';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '7';
        $pengaturanakun->caption = 'Dan Lain Lain';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '8';
        $pengaturanakun->caption = 'Pengeluaran';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '9';
        $pengaturanakun->caption = 'Dana Pengurus';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '10';
        $pengaturanakun->caption = 'Dana Karyawan';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '11';
        $pengaturanakun->caption = 'Dana Pendidikan';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '12';
        $pengaturanakun->caption = 'Dana Sosial';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '13';
        $pengaturanakun->caption = 'Jasa Usaha';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();

        $pengaturanakun = new pengaturanAkuns;
        $pengaturanakun->id = '14';
        $pengaturanakun->caption = 'Jasa Modal';
        $pengaturanakun->status = 'detail';
        $pengaturanakun->save();
    }
}
