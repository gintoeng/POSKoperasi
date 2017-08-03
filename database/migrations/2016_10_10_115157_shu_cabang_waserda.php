<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShuCabangWaserda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pembelianedit');
        });

        Schema::table('cabang', function (Blueprint $table) {
            $table->unsignedInteger('id_shu')->nullable();
        });

        Schema::table('cabang', function (Blueprint $table) {
            $table->foreign('id_shu')->references('id')->on('kategori_shu_detail')->onDelete('CASCADE');
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['id_shu']);
        });

        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('id_shu');
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
