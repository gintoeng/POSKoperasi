<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProdukExpired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk', function(Blueprint $table){
            $table->dropColumn(['expired','status']);
        });

        Schema::table('produk', function(Blueprint $table){
            $table->date('expired');
            $table->enum('status', ['AKTIF', 'NONAKTIF']);
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
