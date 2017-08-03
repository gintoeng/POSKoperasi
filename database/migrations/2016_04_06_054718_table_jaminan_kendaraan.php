<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJaminanKendaraan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaminan_kendaraan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jaminan');
            $table->string('nomor_plat');
            $table->string('nomor_bpkb');
            $table->string('merek');
            $table->string('jenis');
            $table->integer('tahun');
            $table->string('warna');
            $table->string('nomor_rangka');
            $table->string('bahan_bakar');
            $table->string('tipe');
            $table->string('model');
            $table->string('cc');
            $table->string('jumlah_roda');
            $table->string('nomor_mesin');
            $table->foreign('id_jaminan')->references('id')->on('jaminan_pinjaman')->onDelete('CASCADE');
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
        Schema::drop('jaminan_kendaraan');
    }
}
