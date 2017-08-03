<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TablePengaturanAkun extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_akun', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('laba_tahun_berjalan');
            $table->integer('laba_tahun_sebelumnya');
            $table->integer('dana_cadangan');
            $table->integer('jasa_usaha');
            $table->integer('jasa_modal');
            $table->integer('dana_pengurus');
            $table->integer('dana_karyawan');
            $table->integer('dana_pendidikan');
            $table->integer('dana_sosial');
            $table->integer('dana_pembangunan');
            $table->integer('dana_lain2');
            $table->string('tipe_akun', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pengaturan_akun');
    }
}
