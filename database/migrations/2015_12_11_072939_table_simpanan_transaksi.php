<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableSimpananTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 20);
            $table->enum('tipe', ['TARIK', 'SETOR', 'TRANSFER']);
            $table->unsignedInteger('id_simpanan');
            $table->integer('id_dari')->nullable();
            $table->integer('id_tujuan')->nullable();
            $table->decimal('saldo_awal', 20, 2);
            $table->decimal('kredit', 20, 2);
            $table->decimal('debet', 20, 2);
            $table->decimal('nominal', 20, 2);
            $table->date('tanggal');
            $table->enum('status', ['AKTIF', 'VOID']);
            $table->string('info');
            $table->string('keterangan');
            $table->foreign('id_simpanan')->references('id')->on('simpanan')->onDelete('CASCADE');
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
        Schema::drop('simpanan_transaksi');
    }
}
