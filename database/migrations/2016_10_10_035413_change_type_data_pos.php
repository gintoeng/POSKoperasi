<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeDataPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mastok', function(Blueprint $table){
            $table->dropColumn('id_produk');
        });

        Schema::table('mastok', function(Blueprint $table){
            $table->unsignedInteger('id_produk')->nullable();
        });
        Schema::table('mastok', function(Blueprint $table){
            $table->foreign('id_produk')->references('id')->on('produk')->onDelete('CASCADE');
        });

        //HPP

        Schema::table('hpp', function(Blueprint $table){
            $table->dropColumn('id_produk');
            $table->dropColumn('persedian_awal');
            $table->dropColumn('qty_persediaan');
            $table->dropColumn('pembelian');
            $table->dropColumn('qty_pembelian');
            $table->dropColumn('hpp_unit');
            $table->dropColumn('hpp_asli');
            $table->dropColumn('tanggal');
            $table->dropColumn('cabang');
            $table->dropColumn('penjualan');
            $table->dropColumn('qty_penjualan');
            $table->dropColumn('stok_akhir');
        });

        Schema::table('hpp', function(Blueprint $table){
            $table->decimal('persedian_awal',20,2);
            $table->integer('qty_persediaan');
            $table->decimal('pembelian',20,2);
            $table->integer('qty_pembelian');
            $table->decimal('hpp_unit',20,2);
            $table->decimal('hpp_asli',20,2);
            $table->date('tanggal');
            $table->unsignedInteger('id_produk')->nullable();
            $table->unsignedInteger('cabang')->nullable();
            $table->foreign('id_produk')->references('id')->on('produk')->onDelete('CASCADE');
            $table->foreign('cabang')->references('id')->on('cabang')->onDelete('CASCADE');
            $table->decimal('penjualan',20,2);
            $table->integer('qty_penjualan');
            $table->integer('stok_akhir');
        });
        //Transaksi Detail
        Schema::table('transaksi_detail', function(Blueprint $table){
            $table->dropColumn('harga');
            $table->dropColumn('sub_total');
            $table->dropColumn('kasir');
            $table->dropColumn('cabang');
        });

        Schema::table('transaksi_detail', function(Blueprint $table){
            $table->decimal('harga',20,2);
            $table->decimal('sub_total',20,2);
            $table->unsignedInteger('cabang')->nullable();
            $table->foreign('cabang')->references('id')->on('cabang')->onDelete('CASCADE');
            $table->integer('kasir');
        });
        //Transaksi Sementara
        Schema::table('transaksi_sementara', function(Blueprint $table){
            $table->dropColumn('harga');
            $table->dropColumn('qty');
            $table->dropColumn('sub_total');
            $table->dropColumn('cabang');
        });

        Schema::table('transaksi_sementara', function(Blueprint $table){
            $table->decimal('harga',20,2);
            $table->decimal('sub_total',20,2);
            $table->unsignedInteger('cabang')->nullable();
            $table->foreign('cabang')->references('id')->on('cabang')->onDelete('CASCADE');
            $table->integer('qty');
        });


        //Transaksi Header
        Schema::table('transaksi_header', function(Blueprint $table){
            $table->dropColumn('jumlah');
            $table->dropColumn('kasir');
            $table->dropColumn('cabang');
        });

        Schema::table('transaksi_header', function(Blueprint $table){
            $table->decimal('jumlah',20,2);
            $table->unsignedInteger('cabang')->nullable();
            $table->foreign('cabang')->references('id')->on('cabang')->onDelete('CASCADE');
            $table->integer('kasir');
        });

        //Retur POS
        Schema::table('detail_retur', function(Blueprint $table){
            $table->dropColumn('harga');
            $table->dropColumn('sub_total');
            $table->dropColumn('cabang');
            $table->dropColumn('kasir');
        });

        Schema::table('detail_retur', function(Blueprint $table){
            $table->decimal('harga',20,2);
            $table->decimal('sub_total',20,2);
            $table->unsignedInteger('cabang')->nullable();
            $table->foreign('cabang')->references('id')->on('cabang')->onDelete('CASCADE');
            $table->integer('kasir');
        });

        //IKLAN
        Schema::table('iklan', function(Blueprint $table){
            $table->dropColumn('status');
        });

        Schema::table('iklan', function(Blueprint $table){
            $table->integer('status');
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
