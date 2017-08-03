<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStokMin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produk', function(Blueprint $table){
            $table->dropForeign(['id_vendor']);
            $table->dropForeign(['id_cabang']);
            $table->dropColumn(['adjust', 'proc']);
            $table->decimal('disc_nominal', 20, 2)->after('disc');
            $table->enum('disc_tipe', ['nominal', 'percent'])->after('disc_nominal');
            $table->date('tanggal_awal_diskon')->after('disc_tipe');
            $table->date('tanggal_akhir_diskon')->after('tanggal_awal_diskon');
            $table->integer('stok_minimum')->after('stok');
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
