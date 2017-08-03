<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableProdukin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode', 50);
            $table->string('nama', 100);
            $table->integer('jumlah');
            $table->string('tanggal', 20);
            $table->integer('id_koperasi');
            $table->string('type_masuk', 50);
            $table->string('pj', 50);
            $table->string('sub_harga', 20);
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
        Schema::drop('produkin');
    }
}
