<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiDetail2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('transaksi_detail', function (Blueprint $table) {
         $table->string('cabang');
      });
    }

    /**
    * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('transaksi_detail');
    }
}
