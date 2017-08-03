<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJaminanSimpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaminan_simpanan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jaminan');
            $table->string('nomor_simpanan');
            $table->string('bank');
            $table->integer('jumlah');
            $table->foreign('id_jaminan')->references('id')->on('jaminan_pinjaman')->onDelete('CASCADE');
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
        Schema::drop('jaminan_simpanan');
    }
}
