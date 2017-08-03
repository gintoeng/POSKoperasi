<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keterangan');
            $table->string('akhir_promo');
            $table->string('type');
            $table->string('nominal');
            $table->string('diskon');
            $table->string('status');
            $table->string('nama');
            $table->string('id_cabang');
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
        Schema::drop('promo_header');
    }
}
