<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJaminanBangunan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaminan_bangunan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jaminan');
            $table->string('nomor_sertifikat');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('nib');
            $table->string('peruntukan');
            $table->string('ser_hak');
            $table->decimal('luas_tanah', 5, 2);
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
        Schema::drop('jaminan_bangunan');
    }
}
