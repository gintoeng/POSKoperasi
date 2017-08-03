<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableProdukout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produkout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode', 50);
            $table->string('nama', 100);
            $table->integer('jumlah');
            $table->string('tanggal', 20);
            $table->integer('id_koperasi');
            $table->string('type_keluar', 50);
            $table->string('kode_type', 30);
            $table->string('kasir', 50);
            $table->string('sub_harga', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('produkout');
    }
}
