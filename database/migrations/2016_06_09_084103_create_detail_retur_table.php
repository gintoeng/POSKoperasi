<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailReturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_retur', function (Blueprint $table) {
            $table->increments('id');
            $table->string('produk');
            $table->integer('qty');
            $table->float('harga');
            $table->float('sub_total');
            $table->string('barcode');
            $table->string('kasir');
            $table->string('no_ref');
            $table->string('cabang');
            $table->string('type_pembayaran');
            $table->date('tanggal');
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
        Schema::drop('detail_retur');
    }
}
