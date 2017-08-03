<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank', function(Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 20);
            $table->string('nama_bank', 50)->nullable();
            $table->unsignedInteger('mata_uang')->nullable();
            $table->string('nama_akun', 50)->nullable();
            $table->string('nomor_akun', 50)->nullable();
            $table->string('keterangan', 50)->nullable();
            $table->foreign('mata_uang')->references('id')->on('matauang')->onDelete('CASCADE');
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
        Schema::drop('bank');
    }
}
