<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutodebetWaserda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autodebet_waserda_header', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_proses');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('keterangan');
            $table->integer('shunya');
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
        Schema::drop('autodebet_waserda_header');
    }
}
