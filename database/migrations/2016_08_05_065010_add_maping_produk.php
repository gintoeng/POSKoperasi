<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMapingProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_mapping', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_produk');
            $table->unsignedInteger('id_cabang');
            $table->integer('stok');
            $table->foreign('id_produk')->references('id')->on('produk')->onDelete('CASCADE');
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('CASCADE');
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
        Schema::drop('produk_mapping');
    }
}
