<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAutodebetWaserda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autodebet_waserda_detail', function(Blueprint $table) {
           $table->dropForeign(['id_transaksi']);
        });

        Schema::table('autodebet_waserda_detail', function(Blueprint $table) {
           $table->dropColumn('id_transaksi');
        });

        Schema::table('autodebet_waserda_detail', function(Blueprint $table) {
           $table->unsignedInteger('id_transaksi_detail')->nullable();
        });

        Schema::table('autodebet_waserda_detail', function(Blueprint $table) {
           $table->foreign('id_transaksi_detail')->references('id')->on('transaksi_detail')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
