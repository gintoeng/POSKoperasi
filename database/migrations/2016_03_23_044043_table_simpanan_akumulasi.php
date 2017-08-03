<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSimpananAkumulasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_akumulasi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_simpanan');
            $table->decimal('saldo', 20, 2);
            $table->foreign('id_simpanan')->references('id')->on('simpanan')->onDelete('CASCADE');
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
        Schema::drop('simpanan_akumulasi');
    }
}
