<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PelengkapAkun extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaturan_pinjaman', function (Blueprint $table) {
            $table->unsignedInteger('akun_pinjaman')->nullable();
            $table->unsignedInteger('akun_piutang_baru')->nullable();
            $table->unsignedInteger('akun_piutang_lama')->nullable();
            $table->unsignedInteger('akun_piutang_tak_tertagih')->nullable();
        });

        Schema::table('cabang', function (Blueprint $table) {
            $table->unsignedInteger('akun_cabang')->nullable();
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
