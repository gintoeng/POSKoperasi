<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PembelianSupplierDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PembelianSupplierDetail', function(Blueprint $table){
            $table->increments('id');
            $table->integer('id_header');
            $table->integer('id_barang');
            $table->integer('qty');
            $table->float('sub_total');
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
        Schema::drop('PembelianSupplierDetail');
    }
}
