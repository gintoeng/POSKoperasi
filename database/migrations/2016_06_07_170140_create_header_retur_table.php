<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderReturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_retur', function (Blueprint $table) {
          $table->increments('id');
          $table->string('noref');
          $table->date('tanggal');
          $table->float('jumlah');
          $table->string('no_kartu');
          $table->string('type_pembayaran');
          $table->string('kasir');
          $table->string('status');
          $table->string('kategori');
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
        Schema::drop('header_retur');
    }
}
