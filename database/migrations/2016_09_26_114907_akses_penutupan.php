<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AksesPenutupan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_tutup', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->integer('id_for');
            $table->enum('jenis', ['tutup', 'block', 'aktif', 'blokir', 'edit']);
            $table->enum('tutup', ['anggota', 'simpanan', 'pinjaman', 'waserda']);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::drop('akses_tutup');
    }
}
