<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PembelianSupller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PembelianSupplierHeader', function(Blueprint $table){
            $table->increments('id');
            $table->string('nopembelian');
            $table->integer('id_cabang')->nullable();
            $table->integer('id_vendor')->nullable();
            $table->string('status');
            $table->date('tanggal');
            $table->enum('tipe', ['retur', 'pembelian', 'penemerimaan']);
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
        Schema::drop('PembelianSupplierHeader');
    }
}
