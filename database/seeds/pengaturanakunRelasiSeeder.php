<?php

use App\Model\Akuntansi\pengaturanAkunRelasi;
use Illuminate\Database\Seeder;

class pengaturanakunRelasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '1';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '2';
        $akunrelasi->id_akun = '73';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '2';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '3';
        $akunrelasi->id_akun = '76';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '3';
        $akunrelasi->id_header = '4';
        $akunrelasi->id_detail = '5';
        $akunrelasi->id_akun = '12';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '4';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '6';
        $akunrelasi->id_akun = '74';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '5';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '7';
        $akunrelasi->id_akun = '78';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '6';
        $akunrelasi->id_header = '4';
        $akunrelasi->id_detail = '8';
        $akunrelasi->id_akun = '17';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '7';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '9';
        $akunrelasi->id_akun = '0';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '8';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '10';
        $akunrelasi->id_akun = '0';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '9';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '11';
        $akunrelasi->id_akun = '0';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '10';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '12';
        $akunrelasi->id_akun = '0';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '11';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '13';
        $akunrelasi->id_akun = '0';
        $akunrelasi->save();

        $akunrelasi = new pengaturanAkunRelasi;
        $akunrelasi->id = '12';
        $akunrelasi->id_header = '1';
        $akunrelasi->id_detail = '14';
        $akunrelasi->id_akun = '0';
        $akunrelasi->save();
    }
}
