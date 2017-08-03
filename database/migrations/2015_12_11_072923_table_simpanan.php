<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSimpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('jenis_simpanan');
            $table->string('nomor_simpanan', 50);
            $table->unsignedInteger('anggota');
            $table->tinyInteger('suku_bunga');
            $table->date('tanggal_pembuatan');
            $table->decimal('setoran_bulanan', 20, 2);
            $table->tinyInteger('jangka_waktu');
            $table->tinyInteger('status');
            $table->date('tanggal_status');
            $table->decimal('saldo_blokir', 20, 2);
            $table->string('keterangan');
            $table->foreign('jenis_simpanan')->references('id')->on('pengaturan_simpanan')->onDelete('CASCADE');
            $table->foreign('anggota')->references('id')->on('anggota')->onDelete('CASCADE');
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
        Schema::drop('simpanan');
    }
}
