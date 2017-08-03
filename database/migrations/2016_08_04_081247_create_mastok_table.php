<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMastokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mastok', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('stok_awal');
            $table->string('stok_akhir');
            $table->string('harga_beli');
            $table->string('harga_jual');
            $table->string('hpp');
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
        Schema::drop('mastok');
    }
}
