<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableMastok2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mastok', function(Blueprint $table){
            $table->string('retur');
        });
        Schema::table('PembelianSupplierHeader', function(Blueprint $table){
            $table->dropColumn('retur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
