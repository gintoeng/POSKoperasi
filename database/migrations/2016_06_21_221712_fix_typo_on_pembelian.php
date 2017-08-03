<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTypoOnPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PembelianSupplierHeader', function(Blueprint $table){
            $table->dropColumn('tipe');
        });

        Schema::table('PembelianSupplierHeader', function(Blueprint $table){
            $table->enum('tipe', ['retur', 'pembelian', 'penerimaan']);
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
