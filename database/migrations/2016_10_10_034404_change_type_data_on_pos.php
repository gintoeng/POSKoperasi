<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeDataOnPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mastok', function(Blueprint $table){
            $table->dropColumn('harga_beli');
            $table->dropColumn('stok_awal');
        });

        Schema::table('mastok', function(Blueprint $table){
            $table->decimal('harga_beli', 20,2);
            $table->integer('stok_awal');
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
