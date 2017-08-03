<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNoRekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profil', function (Blueprint $table) {
            $table->dropColumn('nomor_rekening');
        });

        Schema::table('profil', function (Blueprint $table) {
            $table->string('nomor_rekening');
        });

        Schema::table('cabang', function (Blueprint $table) {
            $table->dropColumn('nomor_rekening');
        });

        Schema::table('cabang', function (Blueprint $table) {
            $table->string('nomor_rekening');
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
