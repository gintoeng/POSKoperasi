<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJaminanPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaminan_pinjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pinjaman')->nullable();
            $table->unsignedInteger('jenis_jaminan');
            $table->string('ikatan_hukum');
            $table->string('nama_pemilik', 50);
            $table->string('alamat_pemilik');
            $table->decimal('nilai', 20, 2);
            $table->string('nomor_arsip', 100);
            $table->string('keterangan');
            $table->string('foto');
            $table->string('foto2');
            $table->foreign('jenis_jaminan')->references('id')->on('jenis_jaminan')->onDelete('CASCADE');
            $table->foreign('id_pinjaman')->references('id')->on('pinjaman')->onDelete('CASCADE');
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
        Schema::drop('jaminan_pinjaman');
    }
}
