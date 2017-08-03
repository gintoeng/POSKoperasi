<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnOnProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk', function(Blueprint $table){
//            $table->dropForeign(['id_vendor']);
//            $table->dropForeign(['id_cabang']);
            $table->dropColumn(['no_faktur', 'id_vendor', 'id_cabang']);
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
