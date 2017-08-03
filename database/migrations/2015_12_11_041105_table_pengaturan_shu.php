<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TablePengaturanShu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_shu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dana_cadangan');
            $table->integer('shu_anggota');
            $table->integer('dana_pengurus');
            $table->integer('dana_karyawan');
            $table->integer('dana_pendidikan');
            $table->integer('dana_sosial');
            $table->integer('dana_pembangunan');
            $table->integer('dana_lain2');
            $table->integer('jasa_usaha');
            $table->integer('jasa_modal');
            $table->integer('tahun');
            $table->decimal('jumlah_shulabarugi', 10,2);
            $table->date('tanggal_pembagian');
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
        Schema::drop('pengaturan_shu');
    }
}
