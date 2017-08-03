<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditstokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mastok', function (Blueprint $table) {
            $table->dropColumn('hpp');
            $table->dropColumn('retur');
            $table->dropColumn('nama');
            $table->dropColumn('stok_akhir');
            $table->dropColumn('harga_beli');
            $table->dropColumn('harga_jual');
        });

        Schema::table('mastok', function (Blueprint $table) {
            $table->string('id_produk');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mastok', function (Blueprint $table) {
            //
        });
    }
}
