<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnNomr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomor', function (Blueprint $table) {
            $table->string('pemisah', 5)->after('kode_awal');
            $table->string('kode_awal2', 30)->after('pemisah');
            $table->string('pemisah2', 5)->after('kode_awal2');
            $table->string('kode_awal3', 30)->after('pemisah2');
            $table->string('pemisah3', 5)->after('kode_awal3');
            $table->string('kode_awal4', 30)->after('pemisah3');
            $table->string('kode', 30)->after('kode_awal4');
            $table->integer('nomor_now')->after('kode');
            $table->integer('jumlah_digit')->after('nomor_now');
            $table->integer('nomor_akhir')->after('jumlah_digit');
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
