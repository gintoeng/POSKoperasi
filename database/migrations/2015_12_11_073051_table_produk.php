<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100);
            $table->string('classification', 50);
            $table->unsignedInteger('unit')->nullable();
            $table->unsignedInteger('curr')->nullable();
            $table->decimal('harga_jual', 20, 2);
            $table->decimal('harga_beli', 20, 2);
            $table->decimal('disc', 5, 2);
            $table->integer('stok');
            $table->string('barcode', 50);
            $table->string('remark', 30);
            $table->string('status', 30);
            $table->string('expired', 20);
            $table->string('print_label', 10);
            $table->string('ganti_harga', 10);
            $table->unsignedInteger('kategori')->nullable();
            $table->integer('id_koperasi');
            $table->text('ket');
            $table->decimal('untung', 20, 2);
            $table->foreign('unit')->references('id')->on('unit')->onDelete('CASCADE');
            $table->foreign('curr')->references('id')->on('matauang')->onDelete('CASCADE');
            $table->foreign('kategori')->references('id')->on('kategori')->onDelete('CASCADE');
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
        Schema::drop('produk');
    }
}
