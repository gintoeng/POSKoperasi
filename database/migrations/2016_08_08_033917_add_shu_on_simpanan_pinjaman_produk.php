<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShuOnSimpananPinjamanProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaturan_simpanan', function(Blueprint $table){
            $table->unsignedInteger('id_shu')->nullable();
        });

        Schema::table('pengaturan_pinjaman', function(Blueprint $table){
            $table->unsignedInteger('id_shu')->nullable();
        });

        Schema::table('produk', function(Blueprint $table){
            $table->unsignedInteger('id_shu')->nullable();
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
