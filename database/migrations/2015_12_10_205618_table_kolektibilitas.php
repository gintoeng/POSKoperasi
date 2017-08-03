<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableKolektibilitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kolektibilitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 20);
            $table->string('keterangan')->nullable();
            $table->tinyInteger('batas_hari');
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
        Schema::drop('kolektibilitas');
    }
}
