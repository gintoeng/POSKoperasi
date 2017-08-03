<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutodebetWaserdaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autodebet_waserda_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_auto_header');
            $table->unsignedInteger('id_transaksi');
            $table->decimal('debet', 20 ,2);
            $table->integer('status');
            $table->foreign('id_auto_header')->references('id')->on('autodebet_waserda_header')->onDelete('CASCADE');
            $table->foreign('id_transaksi')->references('id')->on('transaksi_header')->onDelete('CASCADE');
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
        Schema::drop('autodebet_waserda_detail');
    }
}
