<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatusTranaksiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_detail', function (Blueprint $table) {
            $table->integer('stat')->nullable();
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->unsignedInteger('id_shu')->nullable();
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->foreign('id_shu')->references('id')->on('kategori_shu_detail')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
