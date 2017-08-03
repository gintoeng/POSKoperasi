<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PembagianShu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembagian_shu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_pengaturan')->nullable();
            $table->unsignedInteger('id_anggota')->nullable();
            $table->integer('senioritas');
            $table->decimal('total_simpanan', 20, 2);
            $table->decimal('total_bunga', 20, 2);
            $table->decimal('total_waserda', 20, 2);
            $table->decimal('keanggotaan', 20, 2);
            $table->decimal('kon_senioritas', 20, 2);
            $table->decimal('kon_simpanan', 20, 2);
            $table->decimal('kon_bunga', 20, 2);
            $table->decimal('kon_waserda', 20, 2);
            $table->decimal('total', 20, 2);
            $table->decimal('terima', 20, 2);
            $table->decimal('mwajib', 20, 2);
            $table->foreign('id_pengaturan')->references('id')->on('pengaturan_shu')->onDelete('CASCADE');
            $table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('CASCADE');
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
        //
    }
}
