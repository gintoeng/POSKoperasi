<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProdukOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produkout', function(Blueprint $table){
        $table->dropColumn('barcode');
        $table->dropColumn('nama');
        $table->dropColumn('jumlah');
        $table->dropColumn('tanggal');
        $table->dropColumn('id_koperasi');
        $table->dropColumn('type_keluar');
        $table->dropColumn('kode_type');
        $table->dropColumn('kasir');
        $table->dropColumn('sub_harga');
    });

        Schema::table('produkout', function (Blueprint $table) {
            $table->string('barcode');
            $table->string('nama');
            $table->decimal('jumlah',20,2);
            $table->date('tanggal');
            $table->unsignedInteger('id_cabang')->nullable();
            $table->foreign('id_cabang')->references('id')->on('cabang')->onDelete('CASCADE');
            $table->string('jenis_pembayaran');
            $table->integer('qty');
            $table->decimal('sub_total',20,2);
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
