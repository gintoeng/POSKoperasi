<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeriodeAutodebet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proses_simpanan_header', function (Blueprint $table) {
            $table->date('tanggal_awal')->nullable();
            $table->date('tanggal_akhir')->nullable();
        });

        Schema::table('autodebet_pinjaman_header', function (Blueprint $table) {
            $table->date('tanggal_awal')->nullable();
            $table->date('tanggal_akhir')->nullable();
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
