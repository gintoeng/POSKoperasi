<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank', function (Blueprint $table) {
            $table->dropColumn(['nama_akun', 'nomor_akun']);
        });

        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['id_cabang']);
            $table->unsignedInteger('id_bank')->nullable();
            $table->string('nama_akun')->nullable();
            $table->string('nomor_akun')->nullable();
            $table->string('cabang')->nullable();
        });
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn('id_cabang');
            $table->foreign('id_bank')->references('id')->on('bank')->onDelete('CASCADE');
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
