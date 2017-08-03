<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 20);
            $table->string('nama_vendor', 50)->nullable();
            $table->string('nama_kontak', 50)->nullable();
            $table->string('alamat_1')->nullable();
            $table->string('alamat_2')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->unsignedInteger('mata_uang')->nullable();
            $table->unsignedInteger('bank')->nullable();
            $table->string('nomor_akun', 50)->nullable();
            $table->string('nama_akun', 50)->nullable();
            $table->string('keterangan', 50)->nullable();
            $table->foreign('mata_uang')->references('id')->on('matauang')->onDelete('CASCADE');
            $table->foreign('bank')->references('id')->on('bank')->onDelete('CASCADE');
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
        Schema::drop('vendor');
    }
}
