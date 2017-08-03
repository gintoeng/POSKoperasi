<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailPenyusutanAset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyusutan_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_penyusutan');
            $table->integer('bulan_ke');
            $table->decimal('penyusutan', 20, 2);
            $table->decimal('sisa', 20, 2);
            $table->tinyInteger('stat');
            $table->foreign('id_penyusutan')->references('id')->on('penyusutan_aset')->onDelete('CASCADE');
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
        Schema::drop('penyisitan_detail');
    }
}
