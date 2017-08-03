<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeyShu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::table('pengaturan_simpanan', function(Blueprint $table){
            $table->foreign('id_shu')->references('id')->on('kategori_shu_detail')->onDelete('CASCADE');
        });

        \Illuminate\Support\Facades\Schema::table('pengaturan_pinjaman', function(Blueprint $table){
            $table->foreign('id_shu')->references('id')->on('kategori_shu_detail')->onDelete('CASCADE');
        });

        \Illuminate\Support\Facades\Schema::table('produk', function(Blueprint $table){
            $table->foreign('id_shu')->references('id')->on('kategori_shu_detail')->onDelete('CASCADE');
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
