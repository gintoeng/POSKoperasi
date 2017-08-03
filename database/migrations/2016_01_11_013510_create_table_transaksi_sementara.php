<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransaksiSementara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_sementara', function (Blueprint $table) {
            $table->increments('id');
            $table->string('produk');
            $table->string('qty');
            $table->float('harga');
            $table->float('sub_total');
            $table->string('barcode');
            $table->string('no_ref');
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
        Schema::drop('transaksi_sementara');
    }
}
