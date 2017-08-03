<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutodebetShu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proses_simpanan_header', function (Blueprint $table) {
            $table->integer('shunya');
        });

        Schema::table('autodebet_pinjaman_header', function (Blueprint $table) {
            $table->integer('shunya');
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
