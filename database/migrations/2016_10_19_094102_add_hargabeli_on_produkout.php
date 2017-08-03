<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHargabeliOnProdukout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produkout', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });

        Schema::table('produkout', function (Blueprint $table) {
            $table->decimal('harga_beli',20,2);
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
