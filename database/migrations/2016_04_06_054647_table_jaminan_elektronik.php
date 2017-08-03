<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJaminanElektronik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaminan_elektronik', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jaminan');
            $table->string('nomor_serial');
            $table->string('tipe');
            $table->string('merek');
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
        Schema::drop('jaminan_elektronik');
    }
}
