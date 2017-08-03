<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hpp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('produk');
            $table->string('id_produk');
            $table->string('persedian_awal');
            $table->string('qty_persediaan');
            $table->string('pembelian');
            $table->string('qty_pembelian');
            $table->string('hpp_unit');
            $table->string('hpp_asli');
            $table->string('tanggal');
            $table->string('cabang');
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
        Schema::drop('hpp');
    }
}
