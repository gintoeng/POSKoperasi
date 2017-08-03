<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableRealisasiPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi_pinjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pinjaman');
            $table->date('tanggal_realisasi');
            $table->integer('suku_bunga');
            $table->integer('jangka_waktu');
            $table->decimal('biaya_administrasi', 20, 2);
            $table->decimal('biaya_provinsi', 20, 2);
            $table->decimal('biaya_lain', 20, 2);
            $table->decimal('realisasi', 20, 2);
            $table->decimal('uang_diterima', 20, 2);
            $table->decimal('angsuran', 20, 2);
            $table->string('keterangan');
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
        Schema::drop('realisasi_pinjaman');
    }
}