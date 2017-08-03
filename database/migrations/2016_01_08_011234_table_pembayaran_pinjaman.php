<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TablePembayaranPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_pinjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pinjaman');
            $table->string('nomor_transaksi');
            $table->integer('bulan_ke');
            $table->enum('cara_bayar', ['TUNAI', 'SIMPANAN']);
            $table->string('status', 10);
            $table->date('tanggal');
            $table->decimal('saldo', 20, 2);
            $table->decimal('pokok', 20, 2);
            $table->decimal('bunga', 20, 2);
            $table->decimal('denda', 20, 2);
            $table->decimal('lain', 20, 2);
            $table->decimal('total', 20, 2);
            $table->tinyInteger('start');
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
        Schema::drop('pembayaran_pinjaman');
    }
}
