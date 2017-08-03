<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSimpananKolektif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan_kolektif', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipe', ['TARIK', 'SETOR']);
            $table->unsignedInteger('id_simpanan');
            $table->decimal('nominal', 20, 2);
            $table->date('tanggal');
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
        Schema::drop('simpanan_kolektif');
    }
}
