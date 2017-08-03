<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TablePerkiraan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perkiraan', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('tipe_akun', ['header', 'detail']);
            $table->integer('kelompok');
            $table->integer('parent');
            $table->string('kode_akun', 50);
            $table->string('nama_akun', 100);
            $table->tinyInteger('kas');
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
        Schema::drop('perkiraan');
    }
}
