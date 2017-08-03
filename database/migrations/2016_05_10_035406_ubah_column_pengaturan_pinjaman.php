<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UbahColumnPengaturanPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['digunakan_untuk', 'sumber_dana', 'keterangan']);
        });

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->string('digunakan_untuk', 50)->nullable()->after('perhitungan_bunga');
            $table->string('sumber_dana', 50)->nullable()->after('digunakan_untuk');
            $table->text('keterangan')->nullable()->after('kolektibilitas');
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
